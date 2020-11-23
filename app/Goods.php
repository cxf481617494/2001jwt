<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
     protected $table = "p_goods";
    protected $primaryKey = 'goods_id';
    //不自动添加时间 create_at update_at
    public $timestamps = false;
    protected $guarded = [];	
}
