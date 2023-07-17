<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boker extends Model
{
    use HasFactory;
    protected $fillable = [
        'cus_id',
        'name',
        'boker_money',
        'address',
        'group',
        'village',
        'city',
        'district',
    ];
}
