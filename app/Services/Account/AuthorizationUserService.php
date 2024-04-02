<?php
namespace App\Services\Account;

use Illuminate\Http\Request;
use App\Models\AuthorizationUser;
use Illuminate\Support\Str;
use Laililmahfud\Adminportal\Helpers\BadRequestException;
use Laililmahfud\Adminportal\Services\AdminService;

class AuthorizationUserService extends AdminService
{
    public function __construct(
        public $model = AuthorizationUser::class,
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
        return $this->model::where('email', $email)->delete();
    }

    public function findModuleIdByEmail($email)
    {
        return $this->model::query()
            ->where('email', $email)
            ->pluck('modules_id');
    }


    public function findFirstByEmail($email)
    {
        return $this->model::query()
            ->where('email', $email)
            ->first();
    }


    public function findUserModule($email)
    {
        $excludeModuleKey = ['use-case-2'];
        $modules = $this->model::query()
            ->join('app_modules as module', 'module.id', 'authorization_users.modules_id')
            ->where('authorization_users.email', $email)
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
                    "subs" => $modules->where('parent_id', $module->id)
                        ->map(fn($row) => [
                            "label" => $row->name,
                            "key" => $row->key
                        ])->values()
                ];
            })->values();
    }
    public function store(Request $request)
    {
        if(!$request->permissions){
            throw new BadRequestException('Mohon menambahkan permission terlebih dahulu !');
        }
        $email = $request->email;
        $this->model::where('email', $email)->delete();

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
        return $this->model::whereIn('email', $emails)->delete();
    }
}