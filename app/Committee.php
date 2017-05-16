<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    protected $table = "committee";
    protected $fillable=['name','general_info','service', 'banner', 'icon' , 'color' , 'status'];
}

