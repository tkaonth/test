<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adddownpay extends Model
{
    use HasFactory;
    protected $fillable = [
        'cus_id',
        'number',
        'date',
        'bill_id',
        'bill_number',
        'payment',
        'create_by',
        'uploadfile',
    ];
}
