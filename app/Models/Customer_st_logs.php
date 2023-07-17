<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_st_logs extends Model
{
    use HasFactory;
    protected $fillable = [
        'cus_id',
        'status',
        'description',
        'update_at',
        'update_by',
    ];
}
