<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Branch;
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo',
        'owner_id',
        'employee_id',
        'category',
        'price'

    ];

    public function employeeInfo()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

     public function ownerInfo()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
     public function branch()
    {
        return $this->belongsTo(Branch::class, 'owner_id','owner_id');
    }
}
