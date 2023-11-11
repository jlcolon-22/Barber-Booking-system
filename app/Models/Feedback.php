<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'user_id',
        'branch_id'
    ];
     public function userInfo()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
