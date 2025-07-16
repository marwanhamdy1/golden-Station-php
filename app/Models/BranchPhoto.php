<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchPhoto extends Model
{
    protected $fillable = ['branch_id', 'photo'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
