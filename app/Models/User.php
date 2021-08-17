<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles() {
      return $this->belongsToMany(Role::class,'users_roles');
    }

    public function permissions() {
      return $this->belongsToMany(Permission::class,'users_permissions');
    }

    public static function getUserListForDiscount($role, $values) {
      $users = self::select('id as Id',DB::raw("CONCAT(first_name,' ',last_name, ' (', email, ')') AS Name"))->whereHas('roles' , function($query) use ($role) {
          $query->where('name',$role);
      })
      ->having('Name', 'like', '%' . $values['query'] . '%')
      ->get()->toArray();
      // echo "<pre>";
      // print_R($users);
      // exit;
      return $users;
    }
    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class);
    // }
}
