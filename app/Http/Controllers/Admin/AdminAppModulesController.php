<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laililmahfud\Adminportal\Controllers\AdminController;
use App\Services\AppModulesService;
use App\Models\AppModules;

class AdminAppModulesController extends AdminController
{
    protected $routePath = "admin.modules";
    protected $pageTitle = "App Modules";
    protected $resourcePath = "admin.modules";
    protected $moduleService = AppModulesService::class;


    protected $tableColumns = [
        ["label" => "Name", "name" => "name"],["label" => "Icon", "name" => "icon"],
        ["label" => "Key", "name" => "key"],
    ];

    protected $rules = [
        "name" => "required|min:3|max:150",
        "key" => "required|min:3|max:150",
    ];
    public function index(Request $request)
    {
        $data = AppModules::with('sub')->whereNull('parent_id')->get();
    
        return view('admin.modules.table', [
            'data' => $data
        ]);
    }

    public function sortingMenu(Request $request){
        $data = json_decode($request->data);
        foreach($data as $i => $row){
            $sorting = $i+1;
            AppModules::where('id',$row->id)->update([
                'sorting' => $sorting,
                'parent_id' => @$row->parent
            ]);
        }
        
        return response()->json([
            'message' => 'success'
        ]);
    }
}
