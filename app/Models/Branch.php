<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'photo',
        'owner_id',
        'number',
        'email',
        'status',
        'start_time',
        'end_time',
        'lat_long',
    ];

    public function ownerInfo()
    {
        return $this->belongsTo(User::class,'owner_id');
    }
    public function postInfo()
    {
        return $this->hasMany(Post::class,'owner_id','owner_id');
    }
     public function feedbacks()
    {
        return $this->hasMany(Feedback::class,'branch_id','id');
    }
}
