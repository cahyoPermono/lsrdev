<?php
namespace App\Services\Account;

use Illuminate\Http\Request;
use App\Models\AuthorizationUser;
use App\Services\AppModulesService;
use Illuminate\Support\Str;
use Laililmahfud\Adminportal\Helpers\BadRequestException;
use Laililmahfud\Adminportal\Services\AdminService;
use App\Services\MedcoApi\MedcoUserService;
use Barryvdh\Debugbar\Facades\Debugbar;

class AuthorizationUserService extends AdminService
{
    public function __construct(
        public $model = AuthorizationUser::class,
        private $medcoUserService = new MedcoUserService,
        private $userService = new UserService,
        private $appModulesService = new AppModulesService
    ) {
    }

    public function datatable(Request $request, $perPage = 10)
    {
        $search = $request->search ?? '';


        return $this->model::with('modules')
            ->select('email')
            ->when($search, fn($query) => $query->where("email", "ilike", "%{$search}%"))
            ->groupBy('email')
            ->datatable($perPage, "email");
    }

    public function deleteByUuid($email)
    {
        return $this->model::where('email', 'ilike', $email)->delete();
    }

    public function findModuleIdByEmail($email)
    {
        return $this->model::query()
            ->where('email', 'ilike', $email)
            ->pluck('modules_id');
    }


    public function findFirstByEmail($email)
    {
        return $this->model::query()
            ->where('email',"ilike", $email)
            ->first();
    }


    public function findUserModule($email)
    {
        $excludeModuleKey = ['use-case-2'];

        $ptsModuleKeys = $this->appModulesService->getPTSModulesKeys()->toArray();

        $user = $this->userService->findUserByEmail($email);

        // if user is not an active PTS user, exclude PTS modules
        if (!$user->is_pts_active) {   
            $excludeModuleKey = array_merge($excludeModuleKey, $ptsModuleKeys);
        } 

        $modules = $this->model::query()
        ->join('app_modules as module', 'module.id', 'authorization_users.modules_id')
        ->where('authorization_users.email', "ilike", $email)
        ->whereNotIn('module.key',$excludeModuleKey)
        ->select(['module.*'])
        ->distinct()
        ->orderBy('module.sorting', 'asc')
        ->get();

        return $modules->whereNull('parent_id')
            ->map(function ($module) use ($modules) {
                return [
                    "label" => $module->name,
                    "key" => $module->key,
                    "icon" => asset($module->icon),
                    "sorting" => $module->sorting,
                    "is_module" => $module->is_module,
                    "subs" => $modules->where('parent_id', $module->id)
                        ->map(fn($row) => [
                            "label" => $row->name,
                            "key" => $row->key,
                            "icon" => asset($row->icon),
                            "sorting" => $row->sorting,
                            "is_module" => $row->is_module,
                        ])->values()
                ];
            })->values();
    }
    public function findOrCreateByEmailAndModuleID($email, $moduleID)
    {
         $authorization =  $this->model::where('email','ilike', $email)->where('modules_id', $moduleID)->first();
         if(!$authorization){
              $authorization = $this->model::create([
                'uuid' => Str::uuid(),
                'created_at' => now(),
                'email' => $email,
                'modules_id' => $moduleID
            ]);
         }
         return $authorization;
    }

    public function store(Request $request)
    {
        if(!$request->permissions){
            throw new BadRequestException('Mohon menambahkan permission terlebih dahulu !');
        }
        $email = $request->email;
        $this->model::where('email',"ilike", $email)->delete();

        $this->model::insert(
            collect($request->permissions)->map(fn($id) => [
                'uuid' => Str::uuid(),
                'created_at' => now(),
                'email' => $email,
                'modules_id' => $id
            ])->toArray()
        );
    }

    public function update(Request $request, $email)
    {
        return $this->store($request);
    }

    public function bulkDeleteByUuid($emails)
    {
        return $this->model::whereIn('email', "ilike", $emails)->delete();
    }
}