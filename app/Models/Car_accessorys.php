<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class car_accessorys extends Model
{
    use HasFactory;
    protected $fillable = [
        'car_id',
        'car_acc_type',
        'acc_brand',
        'acc_model',
        'acc_code',
        'acc_price',
];
}
