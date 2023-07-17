<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload_file_car extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'file_path',
        'file_name',
    ];
}
