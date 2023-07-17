<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ins_ins_down extends Model
{
    use HasFactory;

    protected $fillable = [
        'cus_id',
        'ins_id',
        'ins_number',
        'appoint_date',
        'appoint_pay',
        'principle',
        'interest',
        'payment',
        'payment_date',
        'bill_number',
        'balance',
        'status',
        'fine',
        'tracking_fee',
        'uploadbill',
    ];
}
