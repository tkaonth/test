<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill_doc extends Model
{
    use HasFactory;
    protected $fillable = [
        'cus_id',
        'bill_id',
        'bill_name',
        'bill_filename',
        'bill_doc_path',
    ];
}
