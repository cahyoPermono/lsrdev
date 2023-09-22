<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\AppModules;
use Laililmahfud\Adminportal\Helpers\AdminPortal;
use Laililmahfud\Adminportal\Services\AdminService;

class AppModulesService extends AdminService
{
    public function __construct(
        public $model = AppModules::class,
    ) {}

    public function datatable(Request $request, $perPage = 10)
    {
        $search = $request->search ?? '';
        
        return $this->model::where(function ($q) use ($search) {
                $q->orWhere("name", "like", "%" . $search . "%");
                $q->orWhere("icon", "like", "%" . $search . "%");
                $q->orWhere("key", "like", "%" . $search . "%");;
            })
            ->select("*")
            ->datatable($perPage, "app_modules.created_at");

    }
    
    public function store(Request $request)
    {
        return $this->model::create([
            "name" => $request->name,
            "icon" => AdminPortal::uploadFile($request->file('icon')),
            "key" => $request->key,
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $data =  $request->only(['name','key']);

        return $this->model::whereUuid($uuid)->update($data);
    }
}
