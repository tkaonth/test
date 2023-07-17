<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_ins extends Model
{
    use HasFactory;
    protected $fillable = [
        'cus_id',
        'cus_code',
        'ins_number',
        'appoint_date',
        'appoint_pay',
        'principle',
        'interest',
        'payment',
        'payment_date',
        'bill_number',
        'status',
        'fine',
        'tracking_fee',
        'balance',
        'uploadbill',
    ];
}
