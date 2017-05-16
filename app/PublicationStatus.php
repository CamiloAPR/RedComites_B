<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PubicationStatus extends Model
{
    protected $table = "publication_status";
    protected $fillable=['status'];
}

