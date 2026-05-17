<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    protected $table = 'admin_users';
    public $timestamps = false;
    protected $hidden = ['password_hash'];
}
