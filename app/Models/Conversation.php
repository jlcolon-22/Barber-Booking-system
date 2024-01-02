<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Conversation extends Model
{
    use HasFactory;

//    public $primaryKey = 'id';

    protected $fillable = [
        'user_one',
        'user_two',
        'id',
        'type'
    ];
    public $incrementing = false;

    public function ownerInfo()
    {
        return $this->belongsTo(User::class, 'user_two');
    }

    public function customerInfo()
    {
        return $this->belongsTo(User::class, 'user_one');
    }

}
