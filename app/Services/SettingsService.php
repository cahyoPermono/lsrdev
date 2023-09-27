<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Settings;
use Laililmahfud\Adminportal\Services\AdminService;

class SettingsService extends AdminService
{
    public function __construct(
        public $model = Settings::class,
    ) {}

    public function datatable(Request $request, $perPage = 10)
    {
        $search = $request->search ?? '';
        
        return $this->model::where(function ($q) use ($search) {
                $q->orWhere("value", "like", "%" . $search . "%");;
            })
            ->select("*")
            ->datatable($perPage, "settings.created_at");

    }
    
    public function store(Request $request)
    {
        return $this->model::updateOrCreate(
            ['key' => 'min_active_day'],
            ['value' => $request->input('min_active_day')]
        );
    }

    public function update(Request $request, $uuid)
    {
        //$data =  $request->only(['value','key']);

        //return $this->model::whereUuid($uuid)->update($data);
        return $this->model::updateOrCreate(
            ['key' => 'min_active_day'],
            ['value' => $request->input('min_active_day')]
        );
    }
}
