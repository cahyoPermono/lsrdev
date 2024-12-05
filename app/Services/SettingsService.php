<?php
namespace App\Services;

use App\Models\Settings;
use App\Constanta\Constanta;
use Illuminate\Http\Request;
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
            ['key' => Constanta::SETTING::MIN_ACTIVE_DAY],
            ['value' => $request->input(Constanta::SETTING::MIN_ACTIVE_DAY)]
        );
    }

    public function update(Request $request, $uuid)
    {
        return $this->model::updateOrCreate(
            ['key' => Constanta::SETTING::MIN_ACTIVE_DAY],
            ['value' => $request->input(Constanta::SETTING::MIN_ACTIVE_DAY)]
        );
    }
}
