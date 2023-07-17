<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car_manage extends Model
{
    use HasFactory;
    protected $fillable = [
            'cus_id',
            'car_model',
            'car_number',
            'engine_number',
            'car_st',
            'update_date',
            'car_price',
            'total_acc_price',
            'car_expenses',
            'sum_price',
            'create_by',
    ];
}
