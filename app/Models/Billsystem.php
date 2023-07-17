<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billsystem extends Model
{
    use HasFactory;
    protected $fillable = [
        'cus_id',
        'bill_number',
        'bill_type',
        'bill_date',
        'payment_branch',
        'payment_type',
        'bill_upload',
        'bill_status',
        'note',
        'create_by',
        'create_at',
        'update_by',
        'approve_st',
        'approve_by',
    ];
}
