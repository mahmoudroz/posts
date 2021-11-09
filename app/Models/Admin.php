<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject
{
    protected $table = 'admins';

    protected $fillable = [
        'name', 'email','password','created_at', 'updated_at'
    ];
    protected $hidden =['password'];
    public $timestamps =true;

    public function getJWTIdentifier()
    {
        // TODO: Implement getJWTIdentifier() method.
        return $this->getKey();
    }

    public function getJWTCustomClaims():array
    {
        // TODO: Implement getJWTCustomClaims() method.
        return [];
    }
}
