<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantor extends Model
{
    use HasFactory;
    protected $fillable = [
        'cus_id',
        'name',
        'idcard',
        'age',
        'bd',
        'tel',
        'address',
        'group',
        'village',
        'city',
        'district',
    ];
}
