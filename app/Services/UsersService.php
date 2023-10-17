<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Users;
use Laililmahfud\Adminportal\Services\AdminService;
use Illuminate\Support\Carbon;
class UsersService extends AdminService
{
    public function __construct(
        public $model = Users::class,
    ) {}

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
    
    public function store(Request $request)
    {
        return $this->model::create([
            "email" => $request->email,
            "workforce" => $request->workforce,
            "identify_provider" => $request->identify_provider,
            "pts_id" => $request->pts_id,
            "status" => $request->status,
            "last_login" => $request->last_login,
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $data =  $request->only(['email','workforce','identify_provider','pts_id','status','last_login']);

        return $this->model::whereUuid($uuid)->update($data);
    }

    public function daysSinceLogin($lastLogin)
    {
        if ($lastLogin) {
            $lastLoginDate = Carbon::parse($lastLogin);
            $currentDate = Carbon::now();
            $daysSinceLogin = $currentDate->diffInDays($lastLoginDate);

            return $daysSinceLogin > 90 ? "> 90 days" : $daysSinceLogin . " days";
        }

        return "N/A";
    }
}
