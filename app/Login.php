<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
     protected $table = "login";
    protected $primaryKey = 'user_id';
    //不自动添加时间 create_at update_at
    public $timestamps = false;
    protected $guarded = [];	
}
