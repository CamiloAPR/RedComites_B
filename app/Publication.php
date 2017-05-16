<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $table = "publication";
    protected $fillable=['committee' , 'title' , 'content' , 'status'];
}

