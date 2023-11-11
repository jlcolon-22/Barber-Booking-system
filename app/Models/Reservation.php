<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstname',
        'lastname',
        'number',
        'email',
        'branch_id',
        'post_id',
        'time',
        'date',
        'status',
        'user_id'
    ];

    public function postInfo()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
     public function branchInfo()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
