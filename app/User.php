<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Model\Role', 'user_roles', 'user_id', 'role_id');
    }

 
    public function hasAnyRole($roles)
    {
        if (is_array($roles))
        {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('SA');
    }

    public function isPACD()
    {
        return $this->hasRole('PACD');
    }

    public function isSECT()
    {
        return $this->hasRole('SECT');
    }

    public function isCAO()
    {
        return $this->hasRole('CAO');
    }

    public function isCEPS()
    {
        return $this->hasRole('CEPS');
    }


}
