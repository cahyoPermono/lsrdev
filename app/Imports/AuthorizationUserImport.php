<?php

namespace App\Imports;

use App\Models\AppModules;
use App\Models\AuthorizationUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laililmahfud\Adminportal\Helpers\ImportExcel;
use Maatwebsite\Excel\Concerns\ToCollection;

class AuthorizationUserImport extends ImportExcel implements ShouldQueue
{
    public $modules;
    public function __init()
    {
        $this->modules = AppModules::query()
            ->select(['name', 'id'])
            ->get()
            ->map(fn($row) => [
                'id' => $row->id,
                'name' => Str::slug($row->name),
            ]);
    }
    public function handle($row)
    {
        $email = @$row['email'];
        $module = @$row['module'];
        $userModules = $module ? explode(",", $module) : [];
        foreach ($userModules as $userModule) {
            $userModule = Str::slug($userModule);
            if ($moduleId = $this->modules->where('name', $userModule)->first()) {
                AuthorizationUser::firstOrCreate([
                    'email' => $email,
                    'modules_id' => @$moduleId['id']
                ]);
            }
        }
    }
}
