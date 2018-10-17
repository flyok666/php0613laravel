<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    //
    protected $fillable = ['username','email','tel'];

    //获取该用户的所有文章   1对多
    public function articles()
    {
        return $this->hasMany(Article::class,'author_id','id');
    }
}
