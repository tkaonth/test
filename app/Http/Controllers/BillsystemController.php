<?php

namespace App\Http\Controllers;

use App\Models\Billsystem;
use Illuminate\Http\Request;
use App\Models\CusManage;
use App\Models\Car_manage;
use App\Models\Ins_down;
use App\Models\Ins;
use App\Models\Customer_st_logs;
use App\Models\Gift;
use App\Models\Doc_st;
use App\Models\Cus_st;
use App\Models\Car_accessorys;
use App\Models\Ins_ins_down;
use App\Models\Ins_ins;
use App\Models\Bill_detail;
use App\Models\Billnumber;
use App\Models\Bill_doc;
use App\Models\Bill_st;
use App\Models\OtherBill;
use App\Models\Adddownpay;
use App\Models\Discount;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;

class BillsystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$id )
    {
        //
        $data['cusdata'] = CusManage::where('id',$id)->first();
        $data['cardata'] = Car_manage::where('cus_id',$id)->first();
        $data['ins'] = Ins::where('cus_id',$id)->orderByRAW('CAST(ins_number AS UNSIGNED)')->get();
        $data['insdown'] = Ins_down::where('cus_id',$id)->orderByRAW('CAST(ins_down_number AS UNSIGNED)')->get();
        $data['ins_insdowns'] = Ins_ins_down::where('cus_id',$id)->orderByRAW('CAST(ins_number AS UNSIGNED)')->get();
        $data['ins_inss'] = Ins_ins::where('cus_id',$id)->orderByRAW('CAST(ins_number AS UNSIGNED)')->get();
        $data['discounts'] = Discount::where('cus_id',$id)->get();
        $data['cus_st'] = Cus_st::where('keyword',$data['cusdata']['cus_st'])->first();
        return view('billsystem.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //dd($request->all());
        $data['branch'] = $request->branch;
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if($request->bill_type == 'discount_bill'){
            $data['bill_number'] = 'DISCOUNT-'.$data['branch'].'-'.$characters[rand(0, strlen($characters) - 1)].date('YmdHis');
        }else{
            $data['bill_number'] = 'BILL-'.$data['branch'].'-'.$characters[rand(0, strlen($characters) - 1)].date('YmdHis');
        }
        
        $data['payment_type'] = $request->payment_type;
        $data['bill_date'] = $request->bill_date;
        $data['bill_type'] = $request->bill_type;
        $data['cus_id'] = $request->cus_id;
        $data['cus_code'] = $request->cus_code;
        $data['ins_down_number'] = $request->ins_down_number;
        $data['ins_down_divid_num'] = $request->ins_down_divid_num;
        $data['ins_down_id'] = $request->ins_down_id;
        $data['list_type'] = $request->list_type;
        $data['ins_down_appointpay'] = $request->ins_down_appointpay;
        $data['ins_down_name'] = $request->ins_down_name;
        $data['ins_down_payment'] = $request->ins_down_payment;
        $data['ins_down_fine'] = $request->ins_down_fine;
        $data['ins_down_tracking'] = $request->ins_down_tracking;
        $data['ins_down_balance'] = $request->ins_down_balance;
        $data['ins_id'] = $request->ins_id;
        $data['ins_number'] = $request->ins_number;
        $data['ins_divid_num'] = $request->ins_divid_num;
        $data['ins_name'] = $request->ins_name;
        $data['ins_appointpay'] = $request->ins_appointpay;
        $data['ins_payment'] = $request->ins_payment;
        $data['ins_fine'] = $request->ins_fine;
        $data['ins_tracking'] = $request->ins_tracking;
        $data['ins_balance'] = $request->ins_balance;
        $status = 'update';
        
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'success-mes' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'success-mes' => 'Save data successfully',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'success-mes' => 'ບັນທຶກຂໍ້ມູນສໍາເລັດ',
            ];
        }
        $data['bill'] = Billsystem::create([
            'cus_id' => $data['cus_id'],
            'bill_number' => $data['bill_number'],
            'bill_type' => $data['bill_type'],
            'bill_date' => $data['bill_date'],
            'payment_branch' => $data['branch'],
            'payment_type' => $data['payment_type'],
            'bill_upload' => 'waiting',
            'bill_status' => 'created',
            'create_by' => auth()->user()->username,
            'create_at' => Carbon::now()->format('d-m-Y H:i:s'),
            'approve_st' => 'waiting',
        ]);


        /* Billnumber::create([
            'cus_id' => $data['cus_id'],
            'bill_id' => $data['bill']['id'],
            'bill_number' => $data['bill_number'],
        ]); */
        if($data['bill_type'] != 'discount_bill'){
            if($data['ins_down_id']){
                for ($i=0; $i < count($data['ins_down_id']); $i++) { 
                    $status = 'update';
                    $list_type = $data['list_type'][$i];
                    $bill_detail = Bill_detail::create([
                                    'cus_id' => $data['cus_id'],
                                    'bill_id' => $data['bill']['id'],
                                    'bill_number' => $data['bill_number'],
                                    'bill_status' => 'create',
                                    'ins_id' => $data['ins_down_id'][$i],
                                    'list_type' => $data['list_type'][$i],
                                    'list_number' => $i+1,
                                    'list_name' => $data['ins_down_name'][$i],
                                    'list_payments' => $data['ins_down_payment'][$i],
                                    'list_fine' => $data['ins_down_fine'][$i],
                                    'list_tracking' => $data['ins_down_tracking'][$i],
                                    'list_balance' => $data['ins_down_balance'][$i],
                                ]);
                    if($data['list_type'][$i] == 'ins_down'){
                        if($data['ins_down_balance'][$i] == 0){
                            $status = 'close';
                        }
                        $insdown_data = Ins_down::where('id',$data['ins_down_id'][$i])->first();
                        //dd($insdown_data['bill_number']);
                        if(!$insdown_data['bill_number']){
                            Ins_down::where('id',$data['ins_down_id'][$i])->update([
                                'payment' => $data['ins_down_payment'][$i],
                                'payment_date' => $data['bill_date'],
                                'bill_number' => $data['bill_number'],
                                'fine' => $data['ins_down_fine'][$i],
                                'tracking_fee' => $data['ins_down_tracking'][$i],
                                'status' => $status,
                            ]);
                        }else{
                            $subins_down = Ins_ins_down::create([
                                'cus_id' => $data['cus_id'],
                                'ins_id' => $data['ins_down_id'][$i],
                                'ins_number' =>  $data['ins_down_divid_num'][$i],
                                'appoint_pay' => $data['ins_down_appointpay'][$i],
                                'payment' => $data['ins_down_payment'][$i],
                                'payment_date' => $data['bill_date'],
                                'bill_number' => $data['bill_number'],
                                'balance' => $data['ins_down_balance'][$i],
                                'fine' => $data['ins_down_fine'][$i],
                                'tracking_fee' => $data['ins_down_tracking'][$i],
                                'status' => $status,
                            ]);

                            if($subins_down){
                                Bill_detail::where('id',$bill_detail['id'])->update([
                                                'subins_id' => $subins_down['id'],
                                            ]);
                            }
                        }
                    }else if($data['list_type'][$i] == 'ins_insdown'){
                        if($data['ins_down_balance'][$i] == 0){
                            $status = 'close';
                        }
                        $subins_down = Ins_ins_down::create([
                                    'cus_id' => $data['cus_id'],
                                    'ins_id' => $data['ins_down_id'][$i],
                                    'ins_number' => $data['ins_down_divid_num'][$i],
                                    'appoint_pay' => $data['ins_down_appointpay'][$i],
                                    'payment' => $data['ins_down_payment'][$i],
                                    'payment_date' => $data['bill_date'],
                                    'bill_number' => $data['bill_number'],
                                    'balance' => $data['ins_down_balance'][$i],
                                    'fine' => $data['ins_down_fine'][$i],
                                    'tracking_fee' => $data['ins_down_tracking'][$i],
                                    'status' => $status,
                                ]);
                        if($subins_down){
                            Bill_detail::where('id',$bill_detail['id'])->update([
                                            'subins_id' => $subins_down['id'],
                                        ]);
                        }
                    }
                    if($status == 'close'){
                        Ins_down::where('id',$data['ins_down_id'][$i])->update(['status' => $status]);
                    }
                }
            }
        
            if($data['ins_id']){
                for ($i=0; $i < count($data['ins_id']); $i++) { 
                    $status = 'update';
                    if($data['ins_down_id']){
                        $count = count($data['ins_down_id']);
                    }else{
                        $count = 0;
                    }
                    $bill_detail = Bill_detail::create([
                                'cus_id' => $data['cus_id'],
                                'bill_id' => $data['bill']['id'],
                                'bill_number' => $data['bill_number'],
                                'bill_status' => 'create',
                                'ins_id' => $data['ins_id'][$i],
                                'list_type' => $data['list_type'][$i+$count],
                                'list_number' => $i+1,
                                'list_name' => $data['ins_name'][$i],
                                'list_payments' => $data['ins_payment'][$i],
                                'list_fine' => $data['ins_fine'][$i],
                                'list_tracking' => $data['ins_tracking'][$i],
                                'list_balance' => $data['ins_balance'][$i],
                            ]);
                    if($data['list_type'][$i+$count] == 'ins'){
                        if($data['ins_balance'][$i] == 0){
                            $status = 'close';
                        }
                        $ins_data = Ins::where('id',$data['ins_id'][$i])->first();
                        if(!$ins_data['bill_number']){
                            Ins::where('id',$data['ins_id'][$i])->update([
                                'payment' => $data['ins_payment'][$i],
                                'payment_date' => $data['bill_date'],
                                'bill_number' => $data['bill_number'],
                                'fine' => $data['ins_fine'][$i],
                                'tracking_fee' => $data['ins_tracking'][$i],
                                'status' => $status,
                            ]);
                        }else{
                            $subins = Ins_ins::create([
                                'cus_id' => $data['cus_id'],
                                'ins_id' => $data['ins_id'][$i],
                                'ins_number' => $data['ins_number'][$i],
                                'appoint_pay' => $data['ins_appointpay'][$i],
                                'payment' => $data['ins_payment'][$i],
                                'payment_date' => $data['bill_date'],
                                'bill_number' => $data['bill_number'],
                                'balance' => $data['ins_balance'][$i],
                                'fine' => $data['ins_fine'][$i],
                                'tracking_fee' => $data['ins_tracking'][$i],
                                'status' => $status,
                            ]);

                            if($subins){
                                Bill_detail::where('id',$bill_detail['id'])->update([
                                                'subins_id' => $subins['id'],
                                            ]);
                            }
                        }
                    }else if($data['list_type'][$i+$count] == 'ins_ins'){
                        if($data['ins_balance'][$i] == 0){
                            $status = 'close';
                        }
                        $subins = Ins_ins::create([
                                'cus_id' => $data['cus_id'],
                                'ins_id' => $data['ins_id'][$i],
                                'ins_number' => $data['ins_number'][$i],
                                'appoint_pay' => $data['ins_appointpay'][$i],
                                'payment' => $data['ins_payment'][$i],
                                'payment_date' => $data['bill_date'],
                                'bill_number' => $data['bill_number'],
                                'balance' => $data['ins_balance'][$i],
                                'fine' => $data['ins_fine'][$i],
                                'tracking_fee' => $data['ins_tracking'][$i],
                                'status' => $status,
                            ]);
                        if($subins){
                            Bill_detail::where('id',$bill_detail['id'])->update([
                                'subins_id' => $subins['id'],
                            ]);
                        }
                        if($status == 'close'){
                            Ins::where('id',$data['ins_id'][$i])->update(['status' => $status]);
                        }
                    }
                }
            }
        
            $ins_st = Ins::where('cus_id',$data['cus_id'])->pluck('status');
            $insdown_st = Ins_down::where('cus_id',$data['cus_id'])->pluck('status');
            $close_count = 0;
            $cus_st = 'update';
            for ($i=0; $i < count($ins_st) ; $i++) { 
                if($ins_st[$i] == 'close'){
                    $close_count++;
                }
            }
            for ($i=0; $i < count($insdown_st) ; $i++) { 
                if($insdown_st[$i] == 'close'){
                    $close_count++;
                }
            }
            if((count($insdown_st)+count($ins_st)) == $close_count){
                $cus_st = 'close';
            }
            if($cus_st == 'close'){
                CusManage::where('id',$data['cus_id'])->update(['cus_st' => 'ปิดบัญชี']);
            }
            $data['cusdata'] = CusManage::where('id',$data['cus_id'])->first();

            Customer_st_logs::create([
                'cus_id' => $data['cus_id'],
                'status' => 'createbill',
                'description' => "Create bill ".$data['bill_number']." by ".auth()->user()->username,
                'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
                'update_by' => auth()->user()->username,
            ]);
            
            //return view('billsystem.billform',$data);
            return redirect()->route('cuscard', ['id' => $data['cus_id']])->with('success', $valid_mes['success-mes']);
        }else{
            if($data['ins_down_id']){
                for ($i=0; $i < count($data['ins_down_id']); $i++) { 
                    $status = 'waiting approve';
                    $list_type = $data['list_type'][$i];
                    $bill_detail = Bill_detail::create([
                                    'cus_id' => $data['cus_id'],
                                    'bill_id' => $data['bill']['id'],
                                    'bill_number' => $data['bill_number'],
                                    'bill_status' => 'create',
                                    'ins_id' => $data['ins_down_id'][$i],
                                    'list_type' => $data['list_type'][$i],
                                    'list_number' => $i+1,
                                    'list_name' => $data['ins_down_name'][$i],
                                    'list_payments' => $data['ins_down_payment'][$i],
                                    'list_fine' => $data['ins_down_fine'][$i],
                                    'list_tracking' => $data['ins_down_tracking'][$i],
                                    'list_balance' => $data['ins_down_balance'][$i],
                                ]);
                    if($data['list_type'][$i] == 'ins_down'){
                        $insdown_data = Ins_down::where('id',$data['ins_down_id'][$i])->first();
                        //dd($insdown_data['bill_number']);
                        if(!$insdown_data['bill_number']){
                            Ins_down::where('id',$data['ins_down_id'][$i])->update([
                                'payment' => '0',
                                'payment_date' => $data['bill_date'],
                                'bill_number' => $data['bill_number'],
                                'fine' => '0',
                                'tracking_fee' => '0',
                                'status' => $status,
                            ]);
                        }else{
                            $subins_down = Ins_ins_down::create([
                                'cus_id' => $data['cus_id'],
                                'ins_id' => $data['ins_down_id'][$i],
                                'ins_number' =>  $data['ins_down_divid_num'][$i],
                                'appoint_pay' => $data['ins_down_appointpay'][$i],
                                'payment' => '0',
                                'payment_date' => $data['bill_date'],
                                'bill_number' => $data['bill_number'],
                                'balance' => $data['ins_down_appointpay'][$i],
                                'fine' => '0',
                                'tracking_fee' => '0',
                                'status' => $status,
                            ]);

                            if($subins_down){
                                Bill_detail::where('id',$bill_detail['id'])->update([
                                                'subins_id' => $subins_down['id'],
                                            ]);
                            }
                        }
                    }else if($data['list_type'][$i] == 'ins_insdown'){
                        $status = 'waiting approve';
                        $subins_down = Ins_ins_down::create([
                                    'cus_id' => $data['cus_id'],
                                    'ins_id' => $data['ins_down_id'][$i],
                                    'ins_number' => $data['ins_down_divid_num'][$i],
                                    'appoint_pay' => $data['ins_down_appointpay'][$i],
                                    'payment' => '0',
                                    'payment_date' => $data['bill_date'],
                                    'bill_number' => $data['bill_number'],
                                    'balance' => $data['ins_down_appointpay'][$i],
                                    'fine' => '0',
                                    'tracking_fee' => '0',
                                    'status' => $status,
                                ]);
                        if($subins_down){
                            Bill_detail::where('id',$bill_detail['id'])->update([
                                            'subins_id' => $subins_down['id'],
                                        ]);
                        }
                    }
                    if($status == 'close'){
                        Ins_down::where('id',$data['ins_down_id'][$i])->update(['status' => $status]);
                    }
                }
            }
        
            if($data['ins_id']){
                for ($i=0; $i < count($data['ins_id']); $i++) { 
                    $status = 'waiting approve';
                    if($data['ins_down_id']){
                        $count = count($data['ins_down_id']);
                    }else{
                        $count = 0;
                    }
                    $bill_detail = Bill_detail::create([
                                'cus_id' => $data['cus_id'],
                                'bill_id' => $data['bill']['id'],
                                'bill_number' => $data['bill_number'],
                                'bill_status' => 'create',
                                'ins_id' => $data['ins_id'][$i],
                                'list_type' => $data['list_type'][$i+$count],
                                'list_number' => $i+1,
                                'list_name' => $data['ins_name'][$i],
                                'list_payments' => $data['ins_payment'][$i],
                                'list_fine' => $data['ins_fine'][$i],
                                'list_tracking' => $data['ins_tracking'][$i],
                                'list_balance' => $data['ins_balance'][$i],
                            ]);
                    if($data['list_type'][$i+$count] == 'ins'){
                        
                        $ins_data = Ins::where('id',$data['ins_id'][$i])->first();
                        if(!$ins_data['bill_number']){
                            Ins::where('id',$data['ins_id'][$i])->update([
                                'payment' => '0',
                                'payment_date' => $data['bill_date'],
                                'bill_number' => $data['bill_number'],
                                'fine' => '0',
                                'tracking_fee' => '0',
                                'status' => $status,
                            ]);
                        }else{
                            $subins = Ins_ins::create([
                                'cus_id' => $data['cus_id'],
                                'ins_id' => $data['ins_id'][$i],
                                'ins_number' => $data['ins_number'][$i],
                                'appoint_pay' => $data['ins_appointpay'][$i],
                                'payment' => '0',
                                'payment_date' => $data['bill_date'],
                                'bill_number' => $data['bill_number'],
                                'balance' => $data['ins_appointpay'][$i],
                                'fine' => '0',
                                'tracking_fee' => '0',
                                'status' => $status,
                            ]);

                            if($subins){
                                Bill_detail::where('id',$bill_detail['id'])->update([
                                                'subins_id' => $subins['id'],
                                            ]);
                            }
                        }
                    }else if($data['list_type'][$i+$count] == 'ins_ins'){
                        $status = 'waiting approve';
                        $subins = Ins_ins::create([
                                'cus_id' => $data['cus_id'],
                                'ins_id' => $data['ins_id'][$i],
                                'ins_number' => $data['ins_number'][$i],
                                'appoint_pay' => $data['ins_appointpay'][$i],
                                'payment' => '0',
                                'payment_date' => $data['bill_date'],
                                'bill_number' => $data['bill_number'],
                                'balance' => $data['ins_appointpay'][$i],
                                'fine' => '0',
                                'tracking_fee' => '0',
                                'status' => $status,
                            ]);
                        if($subins){
                            Bill_detail::where('id',$bill_detail['id'])->update([
                                'subins_id' => $subins['id'],
                            ]);
                        }
                        if($status == 'close'){
                            Ins::where('id',$data['ins_id'][$i])->update(['status' => $status]);
                        }
                    }
                }
            }
        
            $ins_st = Ins::where('cus_id',$data['cus_id'])->pluck('status');
            $insdown_st = Ins_down::where('cus_id',$data['cus_id'])->pluck('status');
            $close_count = 0;
            $cus_st = 'update';
            for ($i=0; $i < count($ins_st) ; $i++) { 
                if($ins_st[$i] == 'close'){
                    $close_count++;
                }
            }
            for ($i=0; $i < count($insdown_st) ; $i++) { 
                if($insdown_st[$i] == 'close'){
                    $close_count++;
                }
            }
            if((count($insdown_st)+count($ins_st)) == $close_count){
                $cus_st = 'close';
            }
            if($cus_st == 'close'){
                CusManage::where('id',$data['cus_id'])->update(['cus_st' => 'ปิดบัญชี']);
            }
            $data['cusdata'] = CusManage::where('id',$data['cus_id'])->first();

            Customer_st_logs::create([
                'cus_id' => $data['cus_id'],
                'status' => 'createbill',
                'description' => "Create Discount bill ".$data['bill_number']." by ".auth()->user()->username,
                'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
                'update_by' => auth()->user()->username,
            ]);
            
            //return view('billsystem.billform',$data);
            return redirect()->route('cuscard', ['id' => $data['cus_id']])->with('success', $valid_mes['success-mes']);
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Billsystem  $billsystem
     * @return \Illuminate\Http\Response
     */
    public function show(Billsystem $billsystem)
    { 
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Billsystem  $billsystem
     * @return \Illuminate\Http\Response
     */
    public function edit(Billsystem $billsystem)
    {
        //
    }


    public function createbill(Request $request)
    {
        //
        //dd($request->all());
        //$data['billnumber'] = 'BILL-' . date('YmdHis');
        $data['inss'] = "";
        $data['ins_inss'] = "";
        $data['ins_downs'] = "";
        $data['ins_insdowns'] = "";
        $data['ins_downs_data'] = [
            'id' => $request->ins_down_id,
            'payment' => $request->ins_down_payment,
            'fine' => $request->ins_down_fine,
            'tracking' => $request->ins_down_tracking,
            'total' => $request->ins_down_payment + $request->ins_down_fine + $request->ins_down_tracking,
            'balance' => $request->ins_down_balance,
        ];
        $data['inss_data'] = [
            'id' => $request->ins_id,
            'payment' => $request->ins_payment,
            'fine' => $request->ins_fine,
            'tracking' => $request->ins_tracking,
            'total' => $request->ins_payment + $request->ins_fine + $request->ins_tracking,
            'balance' => $request->ins_balance,
        ];
        if($request->ins_id){
            $ins_id = $request->ins_id;
            $data['inss'] = Ins::whereIn('id',$ins_id)->orderByRAW('CAST(ins_number AS UNSIGNED)')->get();
            $data['ins_inss'] = Ins_ins::whereIn('ins_id',$ins_id)->orderByRAW('CAST(ins_number AS UNSIGNED)')->get();
        }
        if($request->ins_down_id){

            $ins_down_id = $request->ins_down_id;
            //dd($ins_down_id);
            $data['ins_downs'] = Ins_down::whereIn('id',$ins_down_id)->orderByRAW('CAST(ins_down_number AS UNSIGNED)')->get();
            $data['ins_insdowns'] = Ins_ins_down::whereIn('ins_id',$ins_down_id)->orderByRAW('CAST(ins_number AS UNSIGNED)')->get();
        }
        
        
        
        $data['cusdata'] = CusManage::where('id',$request->cus_id)->first();
        //print_r($data['ins_downs_data']);
        //print_r($data['inss_data']);

        //echo $data['ins_downs_data']['id'][1];
        /*  echo($data['cusdata'].'<br>');
        echo('---------------------------------------------------------------------------------------<br>');
        print_r($data['inss'].'<br>');
        echo('---------------------------------------------------------------------------------------<br>');
        print_r($data['ins_downs'].'<br>');
        echo('---------------------------------------------------------------------------------------<br>');
        print_r($data['ins_insdowns'].'<br>');
        echo('---------------------------------------------------------------------------------------<br>');
        print_r($data['ins_inss'].'<br>');
        echo('---------------------------------------------------------------------------------------<br>');   */
        return view('billsystem.billsystem',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Billsystem  $billsystem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Billsystem $billsystem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Billsystem  $billsystem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Billsystem $billsystem)
    {
        //
    }

    public function printbillform(Request $request){
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'notfound' => 'ไม่พบข้อมูลที่ค้นหา',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'notfound' => 'Search information not found.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'notfound' => 'ບໍ່ພົບຂໍ້ມູນທີ່ຊອກຫາ.',
            ];
        }
        $billdata = Billsystem::where('bill_number',$request->bill_number)
                                    ->where('cus_id',$request->cus_id)
                                    ->first();
        if($billdata){
                $cusdata = CusManage::where('id',$billdata->cus_id)->first();
                $billdetails = Bill_detail::where('bill_id',$billdata->id)->get();
        }else{
            return redirect()->route('cuscard',['id' => $request->cus_id])->with('warning', $valid_mes['notfound']);
        }
        
        
        

        return view('billsystem.billform',compact('billdata','cusdata','billdetails'));
    }

    public function uploadform(Request $request){
        //dd($request->all());
        $cus_id = $request->cus_id;
        $ins_type = $request->bill_type;
        $billdatasb = null;
        $billdatas = Billsystem::where('bill_number',$request->bill_number)->first();
        if($billdatas){
            $bill_id = $billdatas->id;
        }else{
            $bill_id = '0';
        }
        if($bill_id != '0'){
            $bill_number = $billdatas->bill_number;
        }else{
            $bill_number = $request->bill_number;
        }
        
        
        return view('billsystem.upload_file',compact('cus_id','bill_id','bill_number','ins_type'));
        
    }

    public function uploadfile(Request $request){
        //dd($request->all());
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'name-string' => 'กรุณาตรวจสอบชื่อสถานะรถ',
                'success-mes' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'name-string' => 'Please check car status name.',
                'success-mes' => 'Save data successfully.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'name-string' => 'ກະລຸນາກວດສອບຊື່ສະຖານະລົດ.',
                'success-mes' => 'ບັນທຶກຂໍ້ມູນສຳເລັດແລ້ວ.',
            ];
        }
        $files = $request->file('file-input');
        $number = 0;
        $path = 'uploads/Customers/cus_id_'.$request->cus_id.'/'.'Bills/';
        foreach ($files as $file) {
            $newname = str_replace('/', '_', $request->bill_name);
            $name = uniqid().'_'.$newname. '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path), $name);
            $number++;
            
            Bill_doc::create([
                'cus_id' => $request->cus_id,
                'bill_id' => $request->bill_id,
                'bill_name' => $request->bill_name,
                'bill_doc_path' => $path,
                'bill_filename' => $name,
                'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
                'update_by' => auth()->user()->username,
            ]);
        }

        if($request->ins_type == 'deposit'){
            CusManage::where('id',$request->cus_id)->update([
                'upload_deposit' => 'uploaded'
            ]);
        }else if($request->ins_type == 'deli'){
            CusManage::where('id',$request->cus_id)->update([
                'upload_deli' => 'uploaded'
            ]);
            Adddownpay::where('bill_number',$request->bill_name)->update([
                'uploadfile' => 'uploaded',
            ]);
        }
        Ins_down::where('bill_number',$request->bill_name)->update([
            'uploadbill' => 'uploaded',
        ]);
        Ins_ins_down::where('bill_number',$request->bill_name)->update([
            'uploadbill' => 'uploaded',
        ]);
        Ins::where('bill_number',$request->bill_name)->update([
            'uploadbill' => 'uploaded',
        ]);
        Ins_ins::where('bill_number',$request->bill_name)->update([
            'uploadbill' => 'uploaded',
        ]);
        Billsystem::where('bill_number',$request->bill_name)->update([
            'bill_upload' => 'uploaded',
        ]);
        Discount::where('bill_number',$request->bill_name)->update([
            'uploadbill' => 'uploaded',
        ]);
        Customer_st_logs::create([
            'cus_id' => $request->cus_id,
            'status' => 'uploadcusbill',
            'description' => "Upload Bill file by ".auth()->user()->username,
            'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
            'update_by' => auth()->user()->username,
        ]);
        return redirect()->route('cuscard', ['id' => $request->cus_id])->with('success', $valid_mes['success-mes']);
    }

    public function getbillfile(Request $request){
        //dd($request->all());
        $data['doc_lists'] = Bill_doc::where('cus_id',$request->cus_id)
                                        ->where('bill_name',$request->bill_number)
                                        ->get();
        $data['cus_id'] = $request->cus_id;
        //dd($data);
        return view('billsystem.viewbill',$data);
    }

    function removebill($id){
        //dd($request->all());
        if(session()->get('locale') == 'th'){
            $this->valid_mes = [
                'deleted' => 'ลบข้อมูลเรียบร้อยแล้ว',
                'delete_fail' => 'ลบข้อมูลล้มเหลว โปรดลองอีกครั้ง',
            ];
        }else if(session()->get('locale') == 'en'){
            $this->valid_mes = [
                'deleted' => 'Data has been deleted.',
                'delete_fail' => 'Delete data failed please try again',
            ];
        }else if(session()->get('locale') == 'lo'){
            $this->valid_mes = [
                'deleted' => 'ຂໍ້ມູນຖືກລຶບແລ້ວ.',
                'delete_fail' => 'ລຶບຂໍ້ມູນລົ້ມເຫລວ ກະລຸນາລອງອີກຄັ້ງ',
            ];
        }
        $bill_file = Bill_doc::where('id',$id)->first();
        $cus_id = $bill_file->cus_id;
        $deletedFile = File::delete(public_path($bill_file->bill_doc_path.'/'.$bill_file->bill_filename));
        $bill_file->delete();
        Billsystem::where('bill_number',$bill_file->bill_name)->update([
            'bill_upload' => 'waiting',
        ]);
        
        $deposit = CusManage::where('bill_num_deposit',$bill_file['bill_name'])->first();
        $deli = CusManage::where('bill_num_down_pay_deli',$bill_file['bill_name'])->first();
        if($deposit){
            CusManage::where('id',$deposit['id'])->update([
                'upload_deposit' => 'waiting'
            ]);
        }else if($deli){
            CusManage::where('id',$deli['id'])->update([
                'upload_deli' => 'waiting'
            ]);
            Adddownpay::where('bill_number',$bill_file['bill_name'])->update([
                'uploadfile' => 'waiting',
            ]);
        }
        Ins_down::where('bill_number',$bill_file['bill_name'])->update([
            'uploadbill' => 'waiting',
        ]);
        Ins_ins_down::where('bill_number',$bill_file['bill_name'])->update([
            'uploadbill' => 'waiting',
        ]);
        Ins::where('bill_number',$bill_file['bill_name'])->update([
            'uploadbill' => 'waiting',
        ]);
        Ins_ins::where('bill_number',$bill_file['bill_name'])->update([
            'uploadbill' => 'waiting',
        ]);
        Billsystem::where('bill_number',$bill_file['bill_name'])->update([
            'bill_upload' => 'waiting',
        ]);
        Discount::where('bill_number',$bill_file['bill_name'])->update([
            'uploadbill' => 'waiting',
        ]);


        Customer_st_logs::create([
            'cus_id' => $id,
            'status' => 'removecusbill',
            'description' => "Remove Bill file by ".auth()->user()->username,
            'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
            'update_by' => auth()->user()->username,
        ]);
        if($deletedFile){
            return redirect()->route('cuscard',['id' => $cus_id])->with('success', $this->valid_mes['deleted']);
        }
    }

    public function otherbill(Request $request){
        $otherbills = OtherBill::orderBy('id','ASC')->paginate(10);
        return view('billsystem.indexotherbill',compact('otherbills'));
    }

    public function createotherbill(Request $request){
        return view('billsystem.other_bill');
    }

    public function getbilldetail($id){
        $otherbill = OtherBill::where('id',$id)->first();
        return view('billsystem.otherbillform',compact('otherbill'));
    }

    public function getbilldata($id){
        $billdetail = OtherBill::where('id',$id)->first();
        //$carCusIds = $car_data->pluck('cus_id');
        //$data['cuss'] = CusManage::whereIn('id', $carCusIds)->get();
        //dd($carCusIds);
        return compact('billdetail');
    }

    public function storeotherbill(Request $request){
        //dd($request->all());
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'name-string' => 'กรุณาตรวจสอบชื่อสถานะรถ',
                'success-mes' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'name-string' => 'Please check car status name.',
                'success-mes' => 'Save data successfully.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'name-string' => 'ກະລຸນາກວດສອບຊື່ສະຖານະລົດ.',
                'success-mes' => 'ບັນທຶກຂໍ້ມູນສຳເລັດແລ້ວ.',
            ];
        }
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $bill_number = 'BILL-'.$request->branch.'-'.$characters[rand(0, strlen($characters) - 1)].date('YmdHis');
        $otherbills = OtherBill::create([
            'cus_name' => $request->cus_name,
            'cus_address' => $request->cus_address,
            'cus_tel' => $request->cus_tel,
            'bill_number' => $bill_number,
            'bill_type' => $request->bill_type,
            'bill_status' => 'create',
            'payment_type' => $request->payment_type,
            'bill_date' => $request->bill_date,
            'payment_branch' => $request->branch,
            'payment' => $request->payment,
            'fine' => '0',
            'tracking' => '0',
            'totalpay' => $request->payment,
            'balance' => '0',
            'create_at' => Carbon::now()->format('d-m-Y H:i:s'),
            'create_by' => auth()->user()->username,
            'approve_st' => 'waiting',
        ]);
        return redirect()->route('otherbill')->with('success', $valid_mes['success-mes']);
    }

    public function cancelbill(Request $request){
        //dd($request->all());
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'notfound-mes' => 'ไม่พบใบเสร็จในระบบ',
                'success-mes' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'notfound-mes' => 'No receipt found in the system.',
                'success-mes' => 'Save data successfully.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'notfound-mes' => 'ບໍ່ພົບໃບຮັບເງິນໃນລະບົບ.',
                'success-mes' => 'ບັນທຶກຂໍ້ມູນສຳເລັດແລ້ວ.',
            ];
        }
        $bill_data = Billsystem::where('cus_id',$request->cus_id)
                                    ->where('bill_number',$request->bill_number)->first();
            
        if($bill_data){
            $bill_details = Bill_detail::where('bill_id',$bill_data['id'])->get();
            //dd($bill_details);
            foreach ($bill_details as $key => $bill_detail) {
                switch ($bill_detail->list_type) {
                    case 'ins_down':
                        $list_detail = Ins_ins_down::where('ins_id',$bill_detail->ins_id)->get();
                        $insdown_data = Ins_down::where('id',$bill_detail->ins_id)->first();
                            echo 'id : '.$bill_detail->ins_id.'<br>';
                            Ins_down::where('id',$bill_detail->ins_id)->update([
                                'payment' => '0',
                                'fine' => '0',
                                'tracking_fee' => '0',
                            ]);
                        $insdown_data = Ins_down::where('id',$bill_detail->ins_id)->first();
                        $insdown_balance = $insdown_data['appoint_pay'] - $insdown_data['payment'];
                        /* echo 'insdown appoint_pay : '.$insdown_data['appoint_pay'].'<br>';
                        echo 'insdown payment : '.$insdown_data['payment'].'<br>';
                        echo 'insdown balance : '.$insdown_balance.'<br>'; */
                        for ($i=0; $i < count($list_detail); $i++) { 
                            if($i==0){
                                $ins_insdownBalance = $insdown_balance - $list_detail[$i]['payment'];
                                /* echo 'insinsdown_balance : '.$ins_insdownBalance.'<br>';
                                echo 'insinsdown_pay : '.$list_detail[$i]['payment'].'<br>';
                                echo '---------------------------------------------<br>';
                                echo 'ins_insBalance : '.$ins_insdownBalance.'<br>';
                                echo '=============================================<br>'; */
                                Ins_ins_down::where('id',$list_detail[$i]['id'])->update([
                                    'appoint_pay' => $insdown_balance,
                                    'balance' => $ins_insdownBalance,
                                ]);
                            }else{
                                $ins_insdownBalance = $ins_insdownAppointpay - $list_detail[$i]['payment'];
                                /* echo 'ins_insAppointpay : '.$ins_insdownAppointpay.'<br>';
                                echo 'list_detail pay : '.$list_detail[$i]['payment'].'<br>';
                                echo '---------------------------------------------<br>';
                                echo 'ins_insBalance : '.$ins_insdownBalance.'<br>';
                                echo '=============================================<br>'; */
                                Ins_ins_down::where('id',$list_detail[$i]['id'])->update([
                                    'appoint_pay' => $ins_insdownAppointpay,
                                    'balance' => $ins_insdownBalance,
                                ]);
                            }
                            $ins_insdownAppointpay = $ins_insdownBalance;
                        }
                            Ins_down::where('id',$bill_detail->ins_id)->update([
                                'status' => 'update',
                            ]);
                        break;
                    case 'ins_insdown':
                        $list_detail = Ins_ins_down::where('ins_id',$bill_detail->ins_id)->get();
                        $counter = 0;
                        $ins_insdownBalance = 0;
                        //dd($list_detail);
                        for ($i=0; $i < count($list_detail); $i++) { 
                            
                            if($bill_detail->subins_id == $list_detail[$i]['id']){
                                /* echo 'id : '.$list_detail[$i]['id'].'<br>'; */
                                $ins_insdownBalance = $list_detail[$i]['appoint_pay'];
                                /* echo 'ins_insdownBalance : '.$list_detail[$i]['appoint_pay'].'<br>';
                                echo '---------------------------------------------<br>'; */
                                Ins_ins_down::where('id',$list_detail[$i]['id'])->update([
                                    'payment' => '0',
                                    'fine' => '0',
                                    'tracking_fee' => '0',
                                    'balance' => $ins_insdownBalance,
                                ]);
                                $counter = $i+1;
                                break;
                            }
                        }
                            
                        for ($i=$counter; $i < count($list_detail); $i++) { 
                            $ins_insdownAppointpay = $ins_insdownBalance;
                            $ins_insdownBalance = $ins_insdownAppointpay - $list_detail[$i]['payment'];
                            /* echo 'ins_insdownBalance : '.$ins_insdownBalance.'<br>';
                            echo 'ins_insAppointpay : '.$ins_insdownAppointpay.'<br>';
                            echo 'list_detail pay : '.$list_detail[$i]['payment'].'<br>';
                            echo '---------------------------------------------<br>';
                            echo 'ins_insBalance : '.$ins_insdownBalance.'<br>';
                            echo '=============================================<br>'; */
                            Ins_ins_down::where('id',$list_detail[$i]['id'])->update([
                                'appoint_pay' => $ins_insdownAppointpay,
                                'balance' => $ins_insdownBalance,
                            ]);
                        }
                            Ins_down::where('id',$bill_detail->ins_id)->update([
                                'status' => 'update',
                            ]);

                            
                        break;
                    case 'ins':
                        $list_detail = Ins_ins::where('ins_id',$bill_detail->ins_id)->get();
                        Ins::where('id',$bill_detail->ins_id)->update([
                            'payment' => '0',
                            'fine' => '0',
                            'tracking_fee' => '0',
                        ]);
                        $ins_data = Ins::where('id',$bill_detail->ins_id)->first();
                        $ins_balance = $ins_data['appoint_pay'] - $ins_data['payment'];
                        for ($i=0; $i < count($list_detail); $i++) { 
                            if($i==0){
                                $ins_insBalance = $ins_balance - $list_detail[$i]['payment'];
                                Ins_ins::where('id',$list_detail[$i]['id'])->update([
                                    'appoint_pay' => $ins_balance,
                                    'balance' => $ins_insBalance,
                                ]);
                            }else{
                                $ins_insBalance = $ins_insAppointpay - $list_detail[$i]['payment'];
                                Ins_ins::where('id',$list_detail[$i]['id'])->update([
                                    'appoint_pay' => $ins_insAppointpay,
                                    'balance' => $ins_insBalance,
                                ]);
                            }
                            $ins_insAppointpay = $ins_insBalance;
                        }
                        Ins::where('id',$bill_detail->ins_id)->update([
                            'status' => 'update',
                        ]);
                        break;
                    case 'ins_ins':
                        $list_detail = Ins_ins::where('ins_id',$bill_detail->ins_id)->get();
                        $counter = 0;
                        $ins_insBalance = 0;
                        for ($i=0; $i < count($list_detail); $i++) { 
                            /* echo 'list detail : '.$list_detail[$i]['id'].'<br>';
                            echo '---------------------------------------------<br>'; */
                            if($bill_detail->subins_id == $list_detail[$i]['id']){
                                $ins_insBalance = $list_detail[$i]['appoint_pay'];
                                /* echo 'list appoint : '.$list_detail[$i]['appoint_pay'].'<br>';
                                echo '---------------------------------------------<br>'; */
                                Ins_ins::where('id',$list_detail[$i]['id'])->update([
                                    'payment' => '0',
                                    'fine' => '0',
                                    'tracking_fee' => '0',
                                    'balance' => $ins_insBalance,
                                ]);
                                $counter = $i+1;
                                break;
                            }
                        }
                        for ($i=$counter; $i < count($list_detail); $i++) { 
                            $ins_insAppointpay = $ins_insBalance;
                            $ins_insBalance = $ins_insAppointpay - $list_detail[$i]['payment'];
                            /* echo 'ins_insBalance : '.$ins_insBalance.'<br>';
                            echo 'ins_insAppointpay : '.$ins_insAppointpay.'<br>';
                            echo 'list_detail pay : '.$list_detail[$i]['payment'].'<br>';
                            echo '---------------------------------------------<br>';
                            echo 'ins_insBalance : '.$ins_insBalance.'<br>';
                            echo '=============================================<br>'; */
                            Ins_ins::where('id',$list_detail[$i]['id'])->update([
                                'appoint_pay' => $ins_insAppointpay,
                                'balance' => $ins_insBalance,
                            ]);
                        }
                        Ins::where('id',$bill_detail->ins_id)->update([
                            'status' => 'update',
                        ]);
                        break;
                    default:
                        # code...
                        break;
                }
            }
            
            Bill_detail::where('bill_id',$bill_data['id'])->update([
                'bill_status' => 'cancel',
            ]);
            $bill_data = Billsystem::where('bill_number',$request->bill_number)
                                    ->update([
                                        'bill_status' => 'cancel',
                                        'note' => $request->note,
                                        'update_by' => auth()->user()->username,
                                    ]);
            if(!$bill_data){
                $bill_data = OtherBill::where('bill_number',$request->bill_number)
                                    ->update([
                                        'bill_status' => 'cancel',
                                        'note' => $request->note,
                                        'update_by' => auth()->user()->username,
                                    ]);
            }

            Customer_st_logs::create([
                'cus_id' => $request->cus_id,
                'status' => 'cancelcusbill',
                'description' => "Cancel Bill ".$request->bill_number." by ".auth()->user()->username,
                'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
                'update_by' => auth()->user()->username,
            ]);
            return redirect()->route('cuscard',['id' => $request->cus_id])->with('success', $valid_mes['success-mes']);
        }else{
            return redirect()->route('cuscard',['id' => $request->cus_id])->with('warning', $valid_mes['notfound-mes']);
        }
    }

    public function getdiscountbill()
    {
        
        $bill_datas = Billsystem::where('bill_type','discount_bill')->paginate(10);
        
        $bill_ids = [];
        $cus_ids = [];
        for ($i=0; $i < count($bill_datas) ; $i++) { 
            $bill_ids[] = $bill_datas[$i]['id'];
            $cus_ids[] = $bill_datas[$i]['cus_id'];
        }
        $cusdatas = CusManage::whereIn('id',$cus_ids)->get();
        $billdetails = Bill_detail::whereIn('bill_id',$bill_ids)->get();
        
        return view('report.discount.index',compact('bill_datas','cusdatas','billdetails'));
    }

    public function getotherbilldetail(Request $request)
    {
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'notfound-mes' => 'ไม่พบใบเสร็จในระบบ',
                'success-mes' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'notfound-mes' => 'No receipt found in the system.',
                'success-mes' => 'Save data successfully.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'notfound-mes' => 'ບໍ່ພົບໃບຮັບເງິນໃນລະບົບ.',
                'success-mes' => 'ບັນທຶກຂໍ້ມູນສຳເລັດແລ້ວ.',
            ];
        }
        $otherbill = OtherBill::where('cus_id',$request->cus_id)
                                ->where('bill_number',$request->bill_number)
                                ->first();
        if($otherbill){
            return view('billsystem.otherbillform',compact('otherbill'));
        }
        return redirect()->route('cuscard',['id' => $request->cus_id])->with('warning', $valid_mes['notfound-mes']);
    }

    public function updatediscountbill(Request $request)
    {
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'notfound-mes' => 'ไม่พบใบเสร็จในระบบ',
                'success-mes' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'notfound-mes' => 'No receipt found in the system.',
                'success-mes' => 'Save data successfully.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'notfound-mes' => 'ບໍ່ພົບໃບຮັບເງິນໃນລະບົບ.',
                'success-mes' => 'ບັນທຶກຂໍ້ມູນສຳເລັດແລ້ວ.',
            ];
        }
        //dd($request->all());
        $data['cus_id'] = $request->cus_id;
        $data['bill_id'] = $request->bill_id;
        $data['bill_number'] = $request->bill_number;
        $data['note'] = $request->note;
        $data['approve_st'] = $request->approve_st;
        $billdata = Billsystem::where('id',$data['bill_id'])->first();
        $billdetail = Bill_detail::where('bill_id',$data['bill_id'])->get();
        
        if($data['approve_st'] == 'approved'){
            for ($i=0; $i < count($billdetail) ; $i++) { 
                
                if($billdetail[$i]['list_type'] == 'ins_down'){
                    if($billdetail[$i]['ins_id'] != null && $billdetail[$i]['subins_id'] == null){
                        $insdown = Ins_down::where('id',$billdetail[$i]['ins_id'])->update([
                                    'payment_date' => $billdata['bill_date'],
                                    'bill_number' => $billdata['bill_number'],
                                    'fine' => $billdetail[$i]['list_fine'],
                                    'tracking_fee' => $billdetail[$i]['list_tracking'],
                                    'balance' => $billdetail[$i]['list_balance'],
                                    'status' => 'approved',
                                ]);
                        Billsystem::where('id',$billdetail[$i]['bill_id'])->update([
                            'note' => $data['note'],
                            'approve_st' => 'approved',
                            'approve_by' => auth()->user()->username,
                        ]);
                        Bill_detail::where('id',$billdetail[$i]['id'])->update([
                            'approve_st' => 'approved',
                            'approve_by' => auth()->user()->username,
                        ]);
                    }
                }else if($billdetail[$i]['list_type'] == 'ins_insdown'){
                    if($billdetail[$i]['ins_id'] != null && $billdetail[$i]['subins_id'] != null){
                        $insdown = Ins_ins_down::where('id',$billdetail[$i]['subins_id'])->update([
                            'payment_date' => $billdata['bill_date'],
                            'bill_number' => $billdata['bill_number'],
                            'fine' => $billdetail[$i]['list_fine'],
                            'tracking_fee' => $billdetail[$i]['list_tracking'],
                            'balance' => $billdetail[$i]['list_balance'],
                            'status' => 'approved',
                        ]);
                        Billsystem::where('id',$billdetail[$i]['bill_id'])->update([
                            'note' => $data['note'],
                            'approve_st' => 'approved',
                            'approve_by' => auth()->user()->username,
                        ]);
                        Bill_detail::where('id',$billdetail[$i]['id'])->update([
                            'approve_st' => 'approved',
                            'approve_by' => auth()->user()->username,
                        ]);
                    }
                }else if($billdetail[$i]['list_type'] == 'ins'){
                    if($billdetail[$i]['ins_id'] != null && $billdetail[$i]['subins_id'] == null){
                        $ins = Ins::where('id',$billdetail[$i]['ins_id'])->update([
                            'payment_date' => $billdata['bill_date'],
                            'bill_number' => $billdata['bill_number'],
                            'fine' => $billdetail[$i]['list_fine'],
                            'tracking_fee' => $billdetail[$i]['list_tracking'],
                            'balance' => $billdetail[$i]['list_balance'],
                            'status' => 'approved',
                        ]);
                        Billsystem::where('id',$billdetail[$i]['bill_id'])->update([
                            'note' => $data['note'],
                            'approve_st' => 'approved',
                            'approve_by' => auth()->user()->username,
                        ]);
                        Bill_detail::where('id',$billdetail[$i]['id'])->update([
                            'approve_st' => 'approved',
                            'approve_by' => auth()->user()->username,
                        ]);
                        
                    }
                }else if($billdetail[$i]['list_type'] == 'ins_ins'){
                    if($billdetail[$i]['ins_id'] != null && $billdetail[$i]['subins_id'] != null){
                        $ins = Ins_ins::where('id',$billdetail[$i]['subins_id'])->update([
                            'payment_date' => $billdata['bill_date'],
                            'bill_number' => $billdata['bill_number'],
                            'fine' => $billdetail[$i]['list_fine'],
                            'tracking_fee' => $billdetail[$i]['list_tracking'],
                            'balance' => $billdetail[$i]['list_balance'],
                            'status' => 'approved',
                        ]);
                        Billsystem::where('id',$billdetail[$i]['bill_id'])->update([
                            'note' => $data['note'],
                            'approve_st' => 'approved',
                            'approve_by' => auth()->user()->username,
                        ]);
                        Bill_detail::where('id',$billdetail[$i]['id'])->update([
                            'approve_st' => 'approved',
                            'approve_by' => auth()->user()->username,
                        ]);
                    }
                }
            }
            Customer_st_logs::create([
                'cus_id' => $data['cus_id'],
                'status' => 'approvediscount',
                'description' => "Approve Discount Bill ".$data['bill_number']." by ".auth()->user()->username,
                'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
                'update_by' => auth()->user()->username,
            ]);
        }else if($data['approve_st'] == 'reject'){
            for ($i=0; $i < count($billdetail) ; $i++) { 
                
                if($billdetail[$i]['list_type'] == 'ins_down'){
                    if($billdetail[$i]['ins_id'] != null && $billdetail[$i]['subins_id'] == null){
                        $insdown = Ins_down::where('id',$billdetail[$i]['ins_id'])->update([
                                    'status' => 'reject',
                                ]);
                        Billsystem::where('id',$billdetail[$i]['bill_id'])->update([
                            'note' => $data['note'],
                            'approve_st' => 'reject',
                            'approve_by' => auth()->user()->username,
                        ]);
                        Bill_detail::where('id',$billdetail[$i]['id'])->update([
                            'approve_st' => 'reject',
                            'approve_by' => auth()->user()->username,
                        ]);
                        
                    }
                }else if($billdetail[$i]['list_type'] == 'ins_insdown'){
                    if($billdetail[$i]['ins_id'] != null && $billdetail[$i]['subins_id'] != null){
                        $insdown = Ins_ins_down::where('id',$billdetail[$i]['subins_id'])->update([
                            'status' => 'reject',
                        ]);
                        Billsystem::where('id',$billdetail[$i]['bill_id'])->update([
                            'note' => $data['note'],
                            'approve_st' => 'reject',
                            'approve_by' => auth()->user()->username,
                        ]);
                        Bill_detail::where('id',$billdetail[$i]['id'])->update([
                            'approve_st' => 'reject',
                            'approve_by' => auth()->user()->username,
                        ]);
                    }
                }else if($billdetail[$i]['list_type'] == 'ins'){
                    if($billdetail[$i]['ins_id'] != null && $billdetail[$i]['subins_id'] == null){
                        $ins = Ins::where('id',$billdetail[$i]['ins_id'])->update([
                            'status' => 'reject',
                        ]);
                        Billsystem::where('id',$billdetail[$i]['bill_id'])->update([
                            'note' => $data['note'],
                            'approve_st' => 'reject',
                            'approve_by' => auth()->user()->username,
                        ]);
                        Bill_detail::where('id',$billdetail[$i]['id'])->update([
                            'approve_st' => 'reject',
                            'approve_by' => auth()->user()->username,
                        ]);
                    }else if($billdetail[$i]['ins_id'] != null && $billdetail[$i]['subins_id'] != null){
                        $ins = Ins_ins::where('id',$billdetail[$i]['subins_id'])->update([
                            'status' => 'reject',
                        ]);
                        Billsystem::where('id',$billdetail[$i]['bill_id'])->update([
                            'note' => $data['note'],
                            'approve_st' => 'reject',
                            'approve_by' => auth()->user()->username,
                        ]);
                        Bill_detail::where('id',$billdetail[$i]['id'])->update([
                            'approve_st' => 'reject',
                            'approve_by' => auth()->user()->username,
                        ]);
                    }
                }else if($billdetail[$i]['list_type'] == 'ins_ins'){
                    if($billdetail[$i]['ins_id'] != null && $billdetail[$i]['subins_id'] != null){
                        $ins = Ins_ins::where('id',$billdetail[$i]['subins_id'])->update([
                            'status' => 'reject',
                        ]);
                        Billsystem::where('id',$billdetail[$i]['bill_id'])->update([
                            'note' => $data['note'],
                            'approve_st' => 'reject',
                            'approve_by' => auth()->user()->username,
                        ]);
                        Bill_detail::where('id',$billdetail[$i]['id'])->update([
                            'approve_st' => 'reject',
                            'approve_by' => auth()->user()->username,
                        ]);
                    }
                }
            }


            Customer_st_logs::create([
                'cus_id' => $data['cus_id'],
                'status' => 'rejectdiscount',
                'description' => "Reject Discount Bill ".$data['bill_number']." by ".auth()->user()->username,
                'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
                'update_by' => auth()->user()->username,
            ]);
        }
        return redirect()->route('getdiscountbill')->with('success', $valid_mes['success-mes']);
    }

    public function discountbilldetail(Request $request,$id)
    {
        $billdata = Billsystem::where('id',$id)->first();
        $cusdata = CusManage::where('id',$billdata->cus_id)->first();
        $billdetails = Bill_detail::where('bill_id',$billdata->id)->get();
        return view('report.discount.discountbill',compact('billdata','cusdata','billdetails'));
    }
    
    public function searchdiscount(Request $request){
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'search-notfound' => 'ไม่พบข้อมูลที่กำลังค้นหา',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'search-notfound' => 'The information you are looking for is not found.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'search-notfound' => 'ຂໍ້ມູນທີ່ທ່ານກໍາລັງຊອກຫາແມ່ນບໍ່ພົບ.',
            ];
        }
        if($request->searchTerm !=""){
            $searchTerm = $request->searchTerm;
        }else{
            return redirect()->route('getdiscountbill');
        }
        
        $bill_datas = Billsystem::where('bill_type','discount_bill')
                    ->where('bill_number', 'LIKE', '%'.$searchTerm.'%')
                    ->paginate(10);
        $bill_ids = [];
        $cus_ids = [];
        for ($i=0; $i < count($bill_datas) ; $i++) { 
            $bill_ids[] = $bill_datas[$i]['id'];
            $cus_ids[] = $bill_datas[$i]['cus_id'];
        }
        $cusdatas = CusManage::whereIn('id',$cus_ids)->get();
        $billdetails = Bill_detail::whereIn('bill_id',$bill_ids)->get();
        return view('report.discount.index',compact('bill_datas','cusdatas','billdetails'));  
        


    }

    public function searchotherbill(Request $request){
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'search-notfound' => 'ไม่พบข้อมูลที่กำลังค้นหา',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'search-notfound' => 'The information you are looking for is not found.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'search-notfound' => 'ຂໍ້ມູນທີ່ທ່ານກໍາລັງຊອກຫາແມ່ນບໍ່ພົບ.',
            ];
        }
        if($request->searchTerm !=""){
            $searchTerm = $request->searchTerm;
        }else{
            return redirect()->route('getdiscountbill');
        }
        $otherbills = OtherBill::where('bill_number', 'LIKE', '%'.$searchTerm.'%')
                    ->orwhere('cus_code', 'LIKE', '%'.$searchTerm.'%')
                    ->orwhere('cus_name', 'LIKE', '%'.$searchTerm.'%')
                    ->paginate(10);
        $bill_ids = [];
        $cus_ids = [];
        for ($i=0; $i < count($otherbills) ; $i++) { 
            $bill_ids[] = $otherbills[$i]['id'];
            $cus_ids[] = $otherbills[$i]['cus_id'];
        }
        Bill_st::query()->get();
        $cusdatas = CusManage::whereIn('id',$cus_ids)->get();
        $billdetails = Bill_detail::whereIn('bill_id',$bill_ids)->get();
        return view('billsystem.indexotherbill',compact('otherbills','cusdatas','billdetails'));  
        


    }
}