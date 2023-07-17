<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill_detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'cus_id',
        'bill_id',
        'bill_number',
        'bill_status',
        'ins_id',
        'subins_id',
        'list_type',
        'list_number',
        'list_name',
        'list_payments',
        'list_fine',
        'list_tracking',
        'list_balance',
        'approve_st',
        'approve_by',
    ];
}
