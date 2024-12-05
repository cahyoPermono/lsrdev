<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laililmahfud\Adminportal\Traits\HasDatatable;
use Laililmahfud\Adminportal\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppModules extends Model
{
    use HasFactory,HasUuid,HasDatatable;

    protected $table = "app_modules";
    protected $fillable = ["name","icon","key","is_module"];
    public function sub() {
        return $this->hasMany(AppModules::class, 'parent_id', 'id');
    }
}
