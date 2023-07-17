<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherBill extends Model
{
    use HasFactory;
    protected $fillable = [
        'cus_id',
        'cus_code',
        'cus_name',
        'cus_address',
        'cus_tel',
        'bill_number',
        'bill_type',
        'bill_status',
        'note',
        'payment_type',
        'bill_date',
        'payment_branch',
        'payment',
        'fine',
        'tracking',
        'totalpay',
        'balance',
        'create_by',
        'create_at',
        'update_by',
    ];

    
}
