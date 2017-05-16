<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommitteeMember extends Model
{
    protected $table = "committee_member";
    protected $fillable=['committee', 'member'];
}

