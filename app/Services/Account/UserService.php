<?php
namespace App\Services\Account;

use App\Models\Account\User;
use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Services\AdminService;

class UserService extends AdminService
{
     public function __construct(
          public $model = User::class
     ) {
     }

    public function datatable(Request $request, $perPage = 10)
    {
        $search = $request->search ?? '';
        
        return $this->model::where(function ($q) use ($search) {
                $q->orWhere("email", "ilike", "%" . $search . "%");
                $q->orWhere("workforce", "ilike", "%" . $search . "%");
                $q->orWhere("identify_provider", "ilike", "%" . $search . "%");
                $q->orWhere("pts_id", "ilike", "%" . $search . "%");
                $q->orWhere("status", "ilike", "%" . $search . "%");
                $q->orWhere("last_login", "ilike", "%" . $search . "%");
;
            })
            ->select("*")
            ->datatable($perPage, "users.created_at");
    }

     public function findUserByEmail($email)
     {
          return $this->model::where('email', $email)->first();
     }

     public function updateUser($id, $properties)
     {
          return $this->model::where('id', $id)->update($properties);
     }

     public function createOrUpdateUser($email, $properties)
     {
          return $this->model::updateOrCreate(['email' => $email], $properties);
     }

     public function update(Request $request, $uuid){
          return $this->model::where('uuid', $uuid)->update([
               'status' => $request->status,
               'last_login' => $request->last_login
          ]);
     }
}