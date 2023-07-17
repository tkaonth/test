<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billnumber extends Model
{
    use HasFactory;
    protected $fillable = [
        'cus_id',
        'bill_id',
        'bill_number',
    ];
}
