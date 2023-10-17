<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laililmahfud\Adminportal\Traits\HasDatatable;
use Laililmahfud\Adminportal\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuthorizationUser extends Model
{
    use HasFactory,HasUuid,HasDatatable;

    protected $table = "authorization_users";
    protected $fillable = ["email","modules_id"];

    public function appModules() {
        return $this->hasMany(AppModules::class);
    }

    public function modules() {
        return $this->hasMany(AuthorizationUser::class, 'email', 'email')
            ->join('app_modules' ,'app_modules.id', 'authorization_users.modules_id')
            ->select(['app_modules.id', 'app_modules.name','authorization_users.email'])
            ->distinct();
    }
    
}
