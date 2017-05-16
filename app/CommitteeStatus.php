<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommitteeStatus extends Model
{
    protected $table = "committee_status";
    protected $fillable=['status'];
}

