<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_doc extends Model
{
    use HasFactory;
    protected $fillable = [
        'cus_id',
        'doc_name',
        'doc_status',
        'update_at',
        'update_by',
        'doc_path',
    ];
}
