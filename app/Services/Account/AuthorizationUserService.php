<?php
namespace App\Services\Account;

use Illuminate\Http\Request;
use App\Models\AuthorizationUser;
use Illuminate\Support\Str;
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
        return $this->model::where('email',$email)->delete();
    }

    public function findModuleIdByEmail($email)
    {
        return $this->model::query()
            ->where('email', $email)
            ->pluck('modules_id');
    }
    public function store(Request $request)
    {
        $email = $request->email;
        $this->model::where('email',$email)->delete();
        
        $this->model::insert(
            collect($request->permissions)->map(fn($id)=>[
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
        return $this->model::whereIn('email',$emails)->delete();
    }
}