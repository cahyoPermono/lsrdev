<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\AuthorizationUser;
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

        return $this->model::where(function ($q) use ($search) {
            $q->orWhere("email", "like", "%" . $search . "%");
        })
            ->select("*")
            ->datatable($perPage, "created_at");

    }

    public function store(Request $request)
    {
        foreach($request->permissions as $id){
            $this->model::create([
                'email' => $request->email,
                'modules_id' => $id
            ]);
        }
    }

    public function update(Request $request, $uuid)
    {
        $data = $request->only(['email', 'select_modules']);

        return $this->model::whereUuid($uuid)->update($data);
    }
}