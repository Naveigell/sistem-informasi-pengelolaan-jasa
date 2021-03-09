<?php

namespace App\Authentications;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = "id_users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_users', 'name', 'username', 'email', 'role'
    ];

    /**
     * The attributes that are used to appends a custom key value
     *
     * @var array
     */
    protected $appends = [
        "id"
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

    /**
     * @return mixed get id attribute
     */
    public function getIdAttribute() {
        return $this->attributes["id_users"];
    }

    /**
     * @return mixed get role attribute
     */
    public function getRoleAttribute()
    {
        return $this->attributes["role"];
    }
}
