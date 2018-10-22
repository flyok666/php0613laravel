<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Admin extends User
{
    use Notifiable;

    //必须要设置才可以正常赋值
    protected $fillable = ['username','email','password','sex'];
}
