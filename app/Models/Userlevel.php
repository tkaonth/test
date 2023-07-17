<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userlevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'keyword',
        'menulist',
        'thai',
        'lao',
        'eng',
        'create by',
        'create at',
    ];
}
