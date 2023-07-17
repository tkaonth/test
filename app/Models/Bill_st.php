<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill_st extends Model
{
    use HasFactory;
    protected $fillable = [
        'keyword',
        'thai',
        'lao',
        'eng',
        'create by',
        'create at',
    ];
}
