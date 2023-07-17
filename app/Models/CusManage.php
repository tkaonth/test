<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CusManage extends Model
{
    use HasFactory;

    protected $fillable = [
        'cus_type',
        'cus_st',
        'cus_code',
        'cus_name',
        'cus_idcard',
        'cus_tel',
        'cus_age',
        'cus_bd',
        'cus_address',
        'cus_group',
        'cus_village',
        'cus_city',
        'cus_district',
        'cus_branch',
        'car_id',
        'deposit',
        'bill_num_deposit',
        'deposit_date',
        'down_pay_deli',
        'bill_num_down_pay_deli',
        'ins_LJT',
        'ins_money',
        'promotion',
        'ins_style',
        'ins_style_type',
        'total_price',
        'discount',
        'net_price',
        'down_pay',
        'total_pay_deli',
        'total_pay_deli_date',
        'remaining',
        'interest_rate',
        'ins_long',
        'ins_long_type',
        'divid_ins',
        'note',
        'deli_date',
        'stock',
        'start_ins',
        'upload_deposit',
        'upload_deli',
        'create_by',
        'approve_st',
        'approve_by',
        
    ];
}
