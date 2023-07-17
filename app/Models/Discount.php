<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $fillable = [
        'cus_id',
        'ins_type',
        'ins_id',
        'sub_ins_id',
        'date',
        'bill_number',
        'discount',
        'balance',
        'create_by',
        'uploadbill',
    ];
    
}
