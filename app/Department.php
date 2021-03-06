<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];

    public function issue_details()
    {
        return $this->hasMany(IssueDetail::class);
    }
}
