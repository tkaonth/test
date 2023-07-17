<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car_status_logs extends Model
{
    use HasFactory;
    protected $fillable = [
        'car_id',
        'status',
        'expenses',
        'description',
        'update_at',
        'update_by',
    ];
}