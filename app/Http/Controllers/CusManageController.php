<?php

namespace App\Http\Controllers;

use App\Models\CusManage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Branch;
use App\Models\Car_manage;
use App\Models\Boker;
use App\Models\Guarantor;
use App\Models\Ins_down;
use App\Models\Ins;
use App\Models\Bill_doc;
use App\Models\Customer_doc;
use App\Models\Customer_st_logs;
use App\Models\Gift;
use App\Models\Doc_st;
use App\Models\Cus_st;
use App\Models\Car_st;
use App\Models\Car_accessorys;
use App\Models\Ins_ins_down;
use App\Models\Ins_ins;
use App\Models\OtherBill;
use App\Models\Billsystem;
use App\Models\Bill_detail;
use App\Models\Adddownpay;
use App\Models\Discount;
use App\Models\Subcuscard;
use App\Models\Sub_ins;
use App\Models\Sub_dividins;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;

class CusManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['cusdata'] = CusManage::orderBy('cus_code','ASC')->paginate(20);
        $data['cardata'] = Car_manage::query()->get();
        $data['branchs'] = Branch::query()->get();
        $data['cus_sts'] = Cus_st::query()->get();
        return view('customermanage.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['cars'] = Car_manage::where('cus_id',NULL)->get();
        $data['branchs'] = Branch::query()->get();
        $data['cus_sts'] = Cus_st::query()->get();
        $data['car_sts'] = Car_st::query()->get();
        $data['otherbills'] = OtherBill::where('cus_id',NULL)->get();
        return view('customermanage.newcus',$data);
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

        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'name-string' => 'กรุณาระบุชื่อสถานะรถ',
                'name-unique' => 'กรุณาตรวจสอบชื่อสถานะรถ',
                'added-cus-st' => 'เพิ่มลูกค้าใหม่สำเร็จ',
                'all-valid' => 'กรุณากรอกข้อมูลให้ครบถ้วน',
                'all-string' => 'กรุณาตรวจสอบข้อมูลอีกครั้ง'
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'name-string' => 'Please enter the name of the car status.',
                'name-unique' => 'Please check car status name.',
                'added-cus-st' => 'Successfully added a new Customer.',
                'all-valid' => 'Please complete the information.',
                'all-string' => 'Please check the information again.'
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'name-string' => 'ກະລຸນາລະບຸຊື່ຂອງສະຖານະລົດ.',
                'name-unique' => 'ກະລຸນາກວດເບິ່ງຊື່ຂອງສະຖານະລົດ.',
                'added-cus-st' => 'ເພີ່ມລູກຄ້າໃໝ່ສຳເລັດແລ້ວ.',
                'all-valid' => 'ກະລຸນາຕື່ມຂໍ້ມູນໃສ່.',
                'all-string' => 'ກະລຸນາກວດເບິ່ງຂໍ້ມູນອີກຄັ້ງ.'
            ];
        }

        $request->validate([
            'cus_code' => ['required'],
            'cus_name' => ['required'],
            'cus_idcard' => ['required'],
            'cus_age' => ['required'],
            'cus_tel' => ['required'],
            'cus_address' => ['required'],
            'cus_group' => ['required'],
            'cus_village' => ['required'],
            'cus_city' => ['required'],
            'cus_district' => ['required'],
            'cus_branch' => ['required'],
            'car_id' => ['required'],
            'cus_type' => ['required'],
            'ins_type' => ['required'],
            'total_price' => ['required'],
            'net_price' => ['required'],
            'total_pay_deli_date' => ['required'],
            'remaining' => ['required'],
            'interest_rate' => ['required'],
            'ins_style' => ['required'],
            'ins_long' => ['required'],
            'ins_long_type' => ['required'],
            'deli_date' => ['required'],
            'start_ins' => ['required'],

        ],
        [
            'cus_code.required' => $valid_mes['all-valid'],
            'cus_name.required' => $valid_mes['all-valid'],
            'cus_idcard.required' => $valid_mes['all-valid'],
            'cus_age.required' => $valid_mes['all-valid'],
            'cus_tel.required' => $valid_mes['all-valid'],
            'cus_address.required' => $valid_mes['all-valid'],
            'cus_group.required' => $valid_mes['all-valid'],
            'cus_village.required' => $valid_mes['all-valid'],
            'cus_city.required' => $valid_mes['all-valid'],
            'cus_district.required' => $valid_mes['all-valid'],
            'cus_branch.required' => $valid_mes['all-valid'],
            'car_id.required' => $valid_mes['all-valid'],
            'cus_type.required' => $valid_mes['all-valid'],
            'ins_type.required' => $valid_mes['all-valid'],
            'total_price.required' => $valid_mes['all-valid'],
            'net_price.required' => $valid_mes['all-valid'],
            'total_pay_deli_date.required' => $valid_mes['all-valid'],
            'remaining.required' => $valid_mes['all-valid'],
            'interest_rate.required' => $valid_mes['all-valid'],
            'ins_style.required' => $valid_mes['all-valid'],
            'ins_long.required' => $valid_mes['all-valid'],
            'ins_long_type.required' => $valid_mes['all-valid'],
            'deli_date.required' => $valid_mes['all-valid'],
            'start_ins.required' => $valid_mes['all-valid'],


        ]);

        $ins_type = $request->ins_type;
        $ins_type_ljt = 0;
        $ins_type_money = 0;

        $insdown_flag = null;
        $ins_flag = null;

        for ($i=0; $i < count($ins_type); $i++) { 
            if($ins_type[$i] == 'LJT'){
                $ins_type_ljt = 1;
            }else if($ins_type[$i] == 'Money'){
                $ins_type_money = 1;
            }
        }
        dd($request->all());
        //$divid_ins = $request->divid_ins_small;
        if($request->divid_ins_small != "" && ($request->divid_ins_large !="" && intval($request->divid_ins_large) > 0)){
            $divid_ins = $request->divid_ins_small.'/'.$request->divid_ins_large;
        }else if($request->divid_ins_small != "" && ($request->divid_ins_large =="" || intval($request->divid_ins_large) == 0 || $request->divid_ins_large =="-")){
            $divid_ins = $request->divid_ins_small;
        }else if($request->divid_ins_small == "" && ($request->divid_ins_large !="" && intval($request->divid_ins_large) > 0)){
            $divid_ins = $request->divid_ins_large;
        }
        //dd($divid_ins);
        
/*         if($request->deposit_bill_book !="" && $request->deposit_bill_number !=""){
            $bill_num_deposit = $request->deposit_bill_book.'/'.$request->deposit_bill_number;
        }
        if($request->down_pay_deli_bill_book !="" && $request->down_pay_deli_bill_number !=""){
            $bill_num_down_pay_deli = $request->down_pay_deli_bill_book.'/'.$request->down_pay_deli_bill_number;
        }
        //dd($bill_num_down_pay_deli); */
        $cusdata = null;
        while (1) {
            $cusdata = CusManage::create([
                'cus_code' => $request->cus_code,
                'cus_name' => $request->cus_name,
                'cus_idcard' => $request->cus_idcard,
                'cus_age' => $request->cus_age,
                'cus_bd' => $request->cus_bd,
                'cus_tel' => $request->cus_tel,
                'cus_address' => $request->cus_address,
                'cus_group' => $request->cus_group,
                'cus_village' => $request->cus_village,
                'cus_city' => $request->cus_city,
                'cus_district' => $request->cus_district,
                'cus_branch' => $request->cus_branch,
                'car_id' => $request->car_id,
                'cus_type' => $request->cus_type,
                'cus_st' => $request->cus_st,
                'ins_LJT' => $ins_type_ljt,
                'ins_money' => $ins_type_money,
                'promotion' => $request->promotion,
                'total_price' => $request->total_price,
                'discount' => $request->discount,
                'net_price' => $request->net_price,
                'down_pay' => $request->down_pay,
                'deposit' => $request->deposit,
                'deposit_date' => $request->deposit_date,
                'bill_num_deposit' => $request->deposit_bill_number,
                'down_pay_deli' => $request->down_pay_deli,
                'bill_num_down_pay_deli' => $request->down_pay_deli_bill_number,
                'total_pay_deli' => $request->total_pay_deli,
                'total_pay_deli_date' => $request->total_pay_deli_date,
                'remaining' => $request->remaining,
                'interest_rate' => $request->interest_rate,
                'ins_style' => $request->ins_style,
                'ins_style_type' => $request->ins_style_type,
                'ins_long' => $request->ins_long,
                'ins_long_type' => $request->ins_long_type,
                'divid_ins' => $divid_ins,
                'deli_date' => $request->deli_date,
                'stock' => $request->stock,
                'start_ins' => $request->start_ins,
                'create_by' => auth()->user()->username,
                'note' => $request->note,
                'approve_st' => 'new_cus',
                'approve_by' => '',
            ]);
            if($cusdata){
                break;
            }
        }
        

        if($request->adddown_pay){
            for ($i=0; $i < count($request->adddown_pay) ; $i++) { 
                $adddown = null;
                $bill_id = null;
                if($request->adddownselect[$i] != 0){
                    $bill_id = $request->adddownselect[$i];
                }
                while (1) {
                    $adddown = Adddownpay::create([
                        'cus_id' => $cusdata->id,
                        'number' => $i+1,
                        'date' => $request->adddown_date[$i],
                        'bill_id' => $bill_id,
                        'bill_number' => $request->adddown_billnumber[$i],
                        'payment' => $request->adddown_pay[$i],
                        'create_by' => auth()->user()->username,
                    ]);
                    if($adddown){
                        $otherbill = null;
                        while (1) {
                            $otherbill = OtherBill::where('id',$bill_id)->update([
                                'cus_id' => $cusdata->id,
                                'cus_code' => $cusdata->cus_code,
                            ]);
                            if($otherbill){
                                break;
                            }
                        }
                        break;
                    }
                }
            }
        }

        
        if($request->deposit_select){
            $deposit = null;
            while (1) {
                $deposit = OtherBill::where('id',$request->deposit_select)->update([
                    'cus_id' => $cusdata->id,
                    'cus_code' => $cusdata->cus_code,
                ]);
                if($deposit){
                    break;
                }
            }
        }
        if($request->deli_select){
            $deli =null;
            while (1) {
                $deli = OtherBill::where('id',$request->deli_select)->update([
                    'cus_id' => $cusdata->id,
                    'cus_code' => $cusdata->cus_code,
                ]);
                if($deli){
                    break;
                }
            }
        }
        
        
        //dd($cusdata);
        if($request->guarantor_name){
            for ($i=0; $i < count($request->guarantor_name) ; $i++) { 
                $guarantor = null;
                while (1) {
                    $guarantor = Guarantor::create([
                                'cus_id' => $cusdata->id,
                                'name' => $request->guarantor_name[$i],
                                'idcard' => $request->guarantor_idcard[$i],
                                'age' => $request->guarantor_age[$i],
                                'bd' => $request->guarantor_bd[$i],
                                'tel' => $request->guarantor_tel[$i],
                                'address' => $request->guarantor_address[$i],
                                'group' => $request->guarantor_group[$i],
                                'village' => $request->guarantor_village[$i],
                                'city' => $request->guarantor_city[$i],
                                'district' => $request->guarantor_district[$i],
                            ]);
                    if($guarantor){
                        break;
                    }
                }
                
            }
        }

        if($request->car_id){
            $car = null;
            while (1) {
                $car = Car_manage::where('id',$request->car_id)->update(['cus_id' => $cusdata->id]);
                if($car){
                    break;
                }
            }
        }
        

        if($request->gift){
            $gift = $request->gift;
            for ($i=0; $i < count($gift) ; $i++) { 
                if($gift[$i] == 'other'){
                    if($request->other_item!=null){
                        $gift[$i] = $request->other_item;
                    }else{
                        break;
                    }
                    
                }
                $gift_flag = null;
                while (1) {
                    $gift_flag = Gift::create([
                                'cus_id' => $cusdata->id,
                                'name' => $gift[$i],
                            ]);
                    if($gift_flag){
                        break;
                    }
                }
                
            }
        }

        if($request->ins_down_appoint_pay){
            for ($i=0; $i < count($request->ins_down_appoint_pay) ; $i++) { 
                $insdowndata = null;
                while (1) {
                    $insdowndata = Ins_down::create([
                        'cus_id' => $cusdata->id,
                        'cus_code' => $cusdata->cus_code,
                        'ins_down_number' => $i+1,
                        'appoint_date' => $request->ins_down_appoint_date[$i],
                        'appoint_pay' => $request->ins_down_appoint_pay[$i],
                        'balance' => $request->ins_down_appoint_pay[$i],
                        'status' => 'new',
    
                    ]);
                    if($insdowndata){
                        break;
                    }
                }
            }
        }
        if($request->ins_appoint_pay){
            for ($i=0; $i < count($request->ins_appoint_pay) ; $i++) { 
                $insdata = null;
                while (1) {
                    $insdata = Ins::create([
                        'cus_id' => $cusdata->id,
                        'cus_code' => $cusdata->cus_code,
                        'ins_number' => $i+1,
                        'appoint_date' => $request->ins_appoint_date[$i],
                        'appoint_pay' => $request->ins_appoint_pay[$i],
                        'principle' => $request->principle[$i],
                        'interest' => $request->interest[$i],
                        'balance' => $request->ins_appoint_pay[$i],
                        'status' => 'new',

                    ]);
                    if($insdata){
                        break;
                    }
                }
                
            }
        }
        if($request->boker == "มีนายหน้า"){
            $boker = null;
            while (1) {
                $boker = Boker::create([
                    'cus_id' => $cusdata->id,
                    'name' => $request->boker_name,
                    'tel' => $request->boker_tel,
                    'boker_money' => $request->boker_money,
                    'address' => $request->boker_address,
                    'group' => $request->boker_group,
                    'village' => $request->boker_village,
                    'city' => $request->boker_city,
                    'district' => $request->boker_district,
                ]);
                if($boker){
                    break;
                }
            }
            
        }

        Customer_st_logs::create([
            'cus_id' => $cusdata->id,
            'status' => 'createnewcus',
            'description' => "Create new customer by ".auth()->user()->username,
            'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
            'update_by' => auth()->user()->username,
        ]);

        

        return redirect()->route('cuscard', ['id' => $cusdata->id])->with('success', $valid_mes['added-cus-st']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CusManage  $cusManage
     * @return \Illuminate\Http\Response
     */
    public function subcuscardform($id)
    {
        //
        $data['cusdata'] = CusManage::where('id',$id)->first();
        $data['branchs'] = Branch::query()->get();
        $data['cus_sts'] = Cus_st::query()->get();
        return view('customermanage.newsubcard',$data);
    }
    

    public function addsubcuscard(Request $request)
    {
        //
        //dd($request->all());

        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'name-string' => 'กรุณาระบุชื่อสถานะรถ',
                'name-unique' => 'กรุณาตรวจสอบชื่อสถานะรถ',
                'added-cus-st' => 'เพิ่มลูกค้าใหม่สำเร็จ',
                'all-valid' => 'กรุณากรอกข้อมูลให้ครบถ้วน',
                'all-string' => 'กรุณาตรวจสอบข้อมูลอีกครั้ง'
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'name-string' => 'Please enter the name of the car status.',
                'name-unique' => 'Please check car status name.',
                'added-cus-st' => 'Successfully added a new Customer.',
                'all-valid' => 'Please complete the information.',
                'all-string' => 'Please check the information again.'
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'name-string' => 'ກະລຸນາລະບຸຊື່ຂອງສະຖານະລົດ.',
                'name-unique' => 'ກະລຸນາກວດເບິ່ງຊື່ຂອງສະຖານະລົດ.',
                'added-cus-st' => 'ເພີ່ມລູກຄ້າໃໝ່ສຳເລັດແລ້ວ.',
                'all-valid' => 'ກະລຸນາຕື່ມຂໍ້ມູນໃສ່.',
                'all-string' => 'ກະລຸນາກວດເບິ່ງຂໍ້ມູນອີກຄັ້ງ.'
            ];
        }


        $ins_type = $request->ins_type;
        $ins_type_ljt = 0;
        $ins_type_money = 0;

        $insdown_flag = null;
        $ins_flag = null;

        //dd($request->all());
        //$divid_ins = $request->divid_ins_small;
        if($request->divid_ins_small != "" && ($request->divid_ins_large !="" && intval($request->divid_ins_large) > 0)){
            $divid_ins = $request->divid_ins_small.'/'.$request->divid_ins_large;
        }else if($request->divid_ins_small != "" && ($request->divid_ins_large =="" || intval($request->divid_ins_large) == 0 || $request->divid_ins_large =="-")){
            $divid_ins = $request->divid_ins_small;
        }else if($request->divid_ins_small == "" && ($request->divid_ins_large !="" && intval($request->divid_ins_large) > 0)){
            $divid_ins = $request->divid_ins_large;
        }
        //dd($divid_ins);
        

        $subcusdata = Subcuscard::create([
            'maincard' => $request->maincard,
            'cus_type' => $request->cus_type,
            'cus_st' => $request->cus_st,
            'cus_code' => $request->cus_code,
            'cus_name' => $request->cus_name,
            'cus_idcard' => $request->cus_idcard,
            'cus_tel' => $request->cus_tel,
            'cus_age' => $request->cus_age,
            'cus_bd' => $request->cus_bd,
            'cus_address' => $request->cus_address,
            'cus_group' => $request->cus_group,
            'cus_village' => $request->cus_village,
            'cus_city' => $request->cus_city,
            'cus_district' => $request->cus_district,
            'cus_branch' => $request->cus_branch,
            'car_id' => $request->car_id,
            'ins_LJT' => $request->ins_LJT,
            'ins_money' => $request->ins_money,
            'ins_style' => $request->ins_style,
            'ins_style_type' => $request->ins_style_type,
            'total_price' => $request->total_price,
            'interest_rate' => $request->interest_rate,
            'ins_long' => $request->ins_long,
            'ins_long_type' => $request->ins_long_type,
            'divid_ins' => $divid_ins,
            'note' => $request->note,
            'start_ins' => $request->start_ins,
            'deli_date' => $request->deli_date,
            'stock' => $request->stock,
            'create_by' => auth()->user()->username,
            'approve_st' => '',
            'approve_by' => '',
            
        ]);

        if($request->ins_appoint_pay){
            for ($i=0; $i < count($request->ins_appoint_pay) ; $i++) { 
                $insdata = null;
                $insdata = Sub_ins::create([
                        'cus_id' => $subcusdata['id'],
                        'cus_code' => $subcusdata['cus_code'],
                        'ins_number' => $request->ins_number[$i],
                        'appoint_date' => $request->ins_appoint_date[$i],
                        'appoint_pay' => $request->ins_appoint_pay[$i],
                        'principle' => $request->principle[$i],
                        'interest' => $request->interest[$i],
                        'balance' => $request->ins_appoint_pay[$i],
                        'status' => 'new',
                    ]);
                if($insdata){
                    continue;
                }else{
                    $i--;
                }
            }
        }
        
        Customer_st_logs::create([
            'cus_id' => $subcusdata['id'],
            'status' => 'createsubcus',
            'description' => "Create subcard customer by ".auth()->user()->username,
            'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
            'update_by' => auth()->user()->username,
        ]);

        return redirect()->route('cuscard', ['id' => $request->maincard])->with('success', $valid_mes['added-cus-st']);
    }

    public function cuscard($id)
    {
        //
        $ins_id = [];
        $data['cusdata'] = CusManage::where('id',$id)->first();
        $data['cardata'] = Car_manage::where('cus_id',$id)->first();
        $data['ins'] = Ins::where('cus_id',$id)->orderByRAW('CAST(ins_number AS UNSIGNED)')->get();
        $data['insdown'] = Ins_down::where('cus_id',$id)->orderByRAW('CAST(ins_down_number AS UNSIGNED)')->get();
        $data['ins_insdowns'] = Ins_ins_down::where('cus_id',$id)->orderByRAW('CAST(ins_number AS UNSIGNED)')->get();
        $data['ins_inss'] = Ins_ins::where('cus_id',$id)->orderByRAW('CAST(ins_number AS UNSIGNED)')->get();
        $data['billdatas'] = Billsystem::where('cus_id',$id)->get();
        $data['billdetails'] = Bill_detail::where('cus_id',$id)->get();
        $data['adddownpays'] = Adddownpay::where('cus_id',$id)->get();
        $data['discounts'] = Discount::where('cus_id',$id)->get();
        $data['cus_st'] = Cus_st::where('keyword', $data['cusdata']->cus_st)->first();
        $data['subcarddata'] = Subcuscard::where('maincard',$id)->first();
        if($data['subcarddata']){
            $data['subcardinss'] = Sub_ins::where('cus_id',$data['subcarddata']->id)->get();
            foreach ($data['subcardinss'] as $key => $value) {
                $ins_id[] = $value->id;
            }
            if($data['subcardinss']){
                $data['subcarddividinss'] = Sub_dividins::whereIn('ins_id',$ins_id)->get();
            }
        }
        return view('customermanage.customercard',$data);
    }

    public function renderaddform(Request $request)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CusManage  $cusManage
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data['cusdata'] = CusManage::where('id',$id)->first();
        $data['cardata'] = Car_manage::where('cus_id',$id)->first();
        $data['ins'] = Ins::where('cus_id',$id)->orderByRAW('CAST(ins_number AS UNSIGNED)')->get();
        $data['insdown'] = Ins_down::where('cus_id',$id)->orderByRAW('CAST(ins_down_number AS UNSIGNED)')->get();
        $data['cus_sts'] = Cus_st::query()->get();
        $data['ins_insdowns'] = Ins_ins_down::where('cus_id',$id)->orderByRAW('CAST(ins_number AS UNSIGNED)')->get();
        $data['ins_inss'] = Ins_ins::where('cus_id',$id)->orderByRAW('CAST(ins_number AS UNSIGNED)')->get();
        $data['adddownpays'] = Adddownpay::where('cus_id',$id)->orderByRAW('CAST(number AS UNSIGNED)')->get();
        $data['discounts'] = Discount::where('cus_id',$id)->get();
        $data['subcarddata'] = Subcuscard::where('maincard',$id)->first();
        if($data['subcarddata']){
            $data['subcardinss'] = Sub_ins::where('cus_id',$data['subcarddata']->id)->get();
            foreach ($data['subcardinss'] as $key => $value) {
                $ins_id[] = $value->id;
            }
            if($data['subcardinss']){
                $data['subcarddividinss'] = Sub_dividins::whereIn('ins_id',$ins_id)->get();
            }
        }
        return view('customermanage.edit_customercard',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CusManage  $cusManage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        //dd($request->all());

        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'updated' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'updated' => 'Save data successfully',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'updated' => 'ບັນທຶກຂໍ້ມູນສໍາເລັດ',
            ];
        }
        $insdown_st = "update";
        $ins_st = "update";
        $subins_st = "update";
        $cusdata = CusManage::where('id',$id)->first();
            
        CusManage::where('id',$id)->update([
            'deposit_date' => $request->deposit_date,
            'bill_num_deposit' => $request->bill_num_deposit,
            'deposit' => $request->deposit,
            'cus_st' => $request->cus_st,
            'total_pay_deli_date' => $request->total_pay_deli_date,
            'bill_num_down_pay_deli' => $request->bill_num_down_pay_deli,
            'down_pay_deli' => $request->down_pay_deli,
        ]);

        if($request->adddown_pay){
            for ($i=0; $i < count($request->adddown_pay) ; $i++) { 
                while (1) {
                    $adddown = Adddownpay::where('id',$request->adddown_id[$i])->update([
                        'date' => $request->adddown_date[$i],
                        'bill_number' => $request->adddown_billnumber[$i],
                        'payment' => $request->adddown_pay[$i],
                    ]);
                    if($adddown){
                        break;
                    }
                }
                
            }
        }

        if($request->ins_down_id){
            for ($i=0; $i < count($request->ins_down_id) ; $i++) {
                $insdown = null;
                $insdown_st = 'update';
                if($request->down_balance[$i] == 0){
                    $insdown_st = 'close';
                }
                
                while (1) {
                    $nsdown = Ins_down::where('id',$request->ins_down_id[$i])->update([
                        'appoint_date' => $request->down_appoint_date[$i],
                        'appoint_pay' => $request->down_appoint_pay[$i],
                        'payment' => $request->down_payment[$i],
                        'payment_date' => $request->down_payment_date[$i],
                        'bill_number' => $request->down_bill_number[$i],
                        'fine' => $request->down_fine[$i],
                        'tracking_fee' => $request->down_tracking_fee[$i],
                        'balance' => $request->down_balance[$i],
                        'status' => $insdown_st,
                    ]);
                    if($nsdown){
                        if($insdown_st == 'close'){
                            Ins_down::where('id',$request->ins_down_id[$i])->update(['status' => $insdown_st]);
                            //break;
                        }
                        break;
                    }
                }
                if($request->ins_insdown_id){
                    $insdown_st = null;
                    for ($k=0; $k < count($request->ins_insdown_id) ; $k++) {
                        $insdown_st = 'update';
                        $ins_insdown = null;
                        if($request->ins_insdown_insid[$k] == $request->ins_down_id[$i]){
                            if($request->ins_insdown_balance[$k] == 0){
                                $insdown_st = 'close';
                            }
                            while (1) {
                                $ins_insdown = Ins_ins_down::where('id',$request->ins_insdown_id[$k])->update([
                                    'appoint_pay' => $request->ins_insdown_appoint_pay[$k],
                                    'payment' => $request->ins_insdown_payment[$k],
                                    'payment_date' => $request->ins_insdown_payment_date[$k],
                                    'bill_number' => $request->ins_insdown_bill_number[$k],
                                    'fine' => $request->ins_insdown_fine[$k],
                                    'tracking_fee' => $request->ins_insdown_tracking_fee[$k],
                                    'balance' => $request->ins_insdown_balance[$k],
                                    'status' => $insdown_st,
                                ]);
                                if($ins_insdown){
                                    if($insdown_st == 'close'){
                                        Ins_down::where('id',$request->ins_down_id[$i])->update(['status' => $insdown_st]);
                                        //break;
                                    }
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }

        if($request->ins_id){
            for ($i=0; $i < count($request->ins_id) ; $i++) { 
                $ins_st = 'update';
                $ins = null;
                if($request->ins_payablebalance[$i] == 0){
                    $ins_st = 'close';
                }
                while (1) {
                    $ins = Ins::where('id',$request->ins_id[$i])->update([
                        'appoint_date' => $request->ins_appoint_date[$i],
                        'appoint_pay' => $request->ins_appoint_pay[$i],
                        'principle' => $request->ins_principle[$i],
                        'interest' => $request->ins_interest[$i],
                        'payment' => $request->ins_payment[$i],
                        'payment_date' => $request->ins_payment_date[$i],
                        'bill_number' => $request->ins_bill_number[$i],
                        'fine' => $request->ins_fine[$i],
                        'tracking_fee' => $request->ins_tracking_fee[$i],
                        'balance' => $request->ins_payablebalance[$i],
                        'status' => $ins_st,
                    ]);
                    if($ins){
                        if($ins_st == 'close'){
                            Ins::where('id',$request->ins_id[$i])->update(['status' => $ins_st]);
                            //break;
                        }
                        break;
                    }
                }
                
                if($request->ins_ins_id){
                    for ($k=0; $k < count($request->ins_ins_id) ; $k++) { 
                        $ins_ins = null;
                        if($request->ins_ins_insid[$k] == $request->ins_id[$i]){
                            $ins_st = 'update';
                            if($request->ins_ins_balance[$k] == 0){
                                $ins_st = 'close';
                            }
                            while (1) {
                                $ins_ins = Ins_ins::where('id',$request->ins_ins_id[$k])->update([
                                    'appoint_pay' => $request->ins_ins_appoint_pay[$k],
                                    'payment' => $request->ins_ins_payment[$k],
                                    'payment_date' => $request->ins_ins_payment_date[$k],
                                    'bill_number' => $request->ins_ins_bill_number[$k],
                                    'fine' => $request->ins_ins_fine[$k],
                                    'tracking_fee' => $request->ins_ins_tracking_fee[$k],
                                    'balance' => $request->ins_ins_balance[$k],
                                    'status' => $ins_st,
                                ]);
                                if($ins_ins){
                                    if($ins_st == 'close'){
                                        Ins::where('id',$request->ins_id[$i])->update(['status' => $ins_st]);
                                        //break;
                                    }
                                    break;
                                }
                            }
                            echo 'ins status : '.$ins_st.'<br>';
                            
                        }
                    }
                }
            }
        }

        if($request->subins_id){

            for ($i=0; $i < count($request->subins_id) ; $i++) { 
                $subins = null;
                $subins_st = 'update';
                if($request->subins_payablebalance[$i] == 0){
                    $subins_st = 'close';
                }
                while (1) {
                    $subins = Sub_ins::where('id',$request->subins_id[$i])->update([
                        'appoint_date' => $request->subins_appoint_date[$i],
                        'appoint_pay' => $request->subins_appoint_pay[$i],
                        'principle' => $request->subins_principle[$i],
                        'interest' => $request->subins_interest[$i],
                        'payment_date' => $request->subins_payment_date[$i],
                        'bill_number' => $request->subins_bill_number[$i],
                        'payment' => $request->subins_payment[$i],
                        'fine' => $request->subins_fine[$i],
                        'tracking_fee' => $request->subins_tracking_fee[$i],
                        'balance' => $request->subins_payablebalance[$i],
                        'status' => $subins_st,
                    ]);
                    if($subins){
                        if($subins_st == 'close'){
                            Sub_ins::where('id',$request->subins_id[$i])->update(['status' => $subins_st]);
                            //break;
                        }
                        break;
                    }
                }
                if($request->subdividins_id){
                    for ($k=0; $k < count($request->subdividins_id); $k++) { 
                        $subdividins = null;
                        $subins_st = 'update';
                        if($request->subdividins_balance[$k] == 0){
                            $subins_st = 'close';
                        }
                        while (1) {
                            $subdividins = Sub_dividins::where('id',$request->subdividins_id[$k])->update([
                                'appoint_pay' => $request->subdividins_appoint_pay[$k],
                                'principle' => $request->subdividins_principle[$k],
                                'interest' => $request->subdivdins_interest[$k],
                                'payment_date' => $request->subdividins_payment_date[$k],
                                'bill_number' => $request->subdividins_bill_number[$k],
                                'payment' => $request->subdividins_payment[$k],
                                'fine' => $request->subdividins_fine[$k],
                                'tracking_fee' => $request->subdividins_tracking_fee[$k],
                                'balance' => $request->subdividins_balance[$k],
                                'status' => $subins_st,
                            ]);
                            if($subdividins){
                                if($subins_st == 'close'){
                                    Sub_ins::where('id',$request->subins_id[$i])->update(['status' => $subins_st]);
                                    //break;
                                }
                                break;
                            }
                        }
                    }
                }
                
            }
        }

        if($request->discount_id){
            for ($i=0; $i < count($request->discount_id); $i++) { 
                $discount = null;
                $insdown_st = "update";
                $ins_st = "update";
                $subins_st = "update";
                $discountdata = null;
                //echo 'discount id : '.$request->discount_id[$i].'<br>';
                while (1) {
                    $discount = Discount::where('id',$request->discount_id[$i])->update([
                        'date' => $request->discount_date[$i],
                        'bill_number' => $request->discount_bill_number[$i],
                        'discount' => $request->discount[$i],
                        'balance' => $request->discount_balance[$i],
                    ]);
                    if($discount){
                        $discountdata = Discount::where('id',$request->discount_id[$i])->first();
                        if($discountdata){
                            if($discountdata['ins_type'] == "insdown" && $discountdata['balance'] == 0){
                                $insdown_st = 'close';
                                Ins_down::where('id',$discountdata['ins_id'])->update(['status' => $insdown_st]);
                            }else if($discountdata['ins_type'] == "ins" && $discountdata['balance'] == 0){
                                $ins_st = 'close';
                                Ins::where('id',$discountdata['ins_id'])->update(['status' => $ins_st]);
                            }else if($discountdata['ins_type'] == "subins" && $discountdata['balance'] == 0){
                                //dd($discountdata['balance']);
                                $subins_st = 'close';
                                Sub_ins::where('id',$discountdata['ins_id'])->update(['status' => $subins_st]);
                            }
                        }
                        break;
                    }
                }
            }
        }

        Customer_st_logs::create([
            'cus_id' => $id,
            'status' => 'editcusdata',
            'description' => "Edit customer data by ".auth()->user()->username,
            'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
            'update_by' => auth()->user()->username,
        ]);
        if($cusdata->cus_st != $request->cus_st){
            Customer_st_logs::create([
                'cus_id' => $id,
                'status' => 'changecus_st',
                'description' => "Change Customer Status from ".$cusdata['cus_st']." to ".$request->cus_st." by ".auth()->user()->username,
                'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
                'update_by' => auth()->user()->username,
            ]);
        }
        return redirect()->route('editcuscard', ['id' => $id])->with('success', $valid_mes['updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CusManage  $cusManage
     * @return \Illuminate\Http\Response
     */
    public function editcusdata($id)
    {
        //
        $ins_id = [];
        $data['cusdata'] = CusManage::where('id',$id)->first();
        $data['cars'] = Car_manage::where('cus_id',NULL)
                                    ->orwhere('id',$data['cusdata']->car_id)
                                    ->get();
        $data['inss'] = Ins::where('cus_id',$id)->orderByRAW('CAST(ins_number AS UNSIGNED)')->get();
        $data['insdowns'] = Ins_down::where('cus_id',$id)->orderByRAW('CAST(ins_down_number AS UNSIGNED)')->get();
        $data['adddownpays'] = Adddownpay::where('cus_id',$id)->get();
        $data['boker'] = Boker::where('cus_id',$id)->first();
        $data['discounts'] = Discount::where('cus_id',$id)->get();
        $data['guarantors'] = Guarantor::where('cus_id',$id)->get();
        $data['gifts'] = Gift::where('cus_id',$id)->get();
        $data['branchs'] = Branch::query()->get();
        $data['cus_sts'] = Cus_st::query()->get();
        $data['car_sts'] = Car_st::query()->get();
        $data['otherbills'] = OtherBill::where('cus_id',NULL)
                            ->orwhere('cus_id',$data['cusdata']->id)
                            ->get();
        $data['subcarddata'] = Subcuscard::where('maincard',$id)->first();;
        if(isset($data['subcarddata'])){
            $data['subcardinss'] = Sub_ins::where('cus_id',$data['subcarddata']->id)->get();
            foreach ($data['subcardinss'] as $key => $value) {
                $ins_id[] = $value->id;
            }
            if(isset($data['subcardinss'])){
                $data['subcarddividinss'] = Sub_dividins::whereIn('ins_id',$ins_id)->get();
            }
        }
        return view('customermanage.editcusdata',$data);
    }

    public function printcard($id){
        // Create a new Dompdf instance
        $dompdf = new Dompdf();
        $data['cusdata'] = CusManage::where('id',$id)->first();
        $data['cardata'] = Car_manage::where('cus_id',$id)->first();
        $data['ins'] = Ins::where('cus_id',$id)->orderByRAW('CAST(ins_number AS UNSIGNED)')->get();
        $data['insdown'] = Ins_down::where('cus_id',$id)->orderByRAW('CAST(ins_down_number AS UNSIGNED)')->get();
        // Retrieve the HTML content of the specific div
        $html = View::make('customermanage.customercard',$data)->renderSection(['customercard']);
        
        // Load the HTML content into Dompdf
        $dompdf->loadHtml($html);
        
        // Set paper size and orientation (optional)
        $dompdf->setPaper('A4', 'portrait');
        
        // Render the PDF
        $dompdf->render();
        
        
        // Output the PDF for download
        return $dompdf->stream('output.pdf', ['Attachment' => false]);
    }

    public function uploadform($id){
        $data['doc_st'] = Doc_st::query()->get();
        $data['id'] = $id;
        return view('customermanage.upload_file',$data);
    }

    public function uploadfile(Request $request,$id){
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
        $path = 'uploads/Customers/cus_id_'.$id;
        foreach ($files as $file) {
            $name = uniqid().'_'.$request->doc_name.'_'.$number. '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path), $name);
            $number++;
            Customer_doc::create([
                'cus_id' => $id,
                'doc_path' => $path,
                'doc_name' => $name,
                'doc_status' => $request->doc_status,
                'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
                'update_by' => auth()->user()->username,
            ]);
        }
        Customer_st_logs::create([
            'cus_id' => $id,
            'status' => 'uploadcusfile',
            'description' => "Upload customer file by ".auth()->user()->username,
            'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
            'update_by' => auth()->user()->username,
        ]);
        return redirect()->route('cuscard', ['id' => $id])->with('success', $valid_mes['success-mes']);
    }

    function viewcusdoc($id){
        $data['doc_lists'] = Customer_doc::where('cus_id',$id)->get();
        $data['id'] = $id;
        return view('customermanage.viewcusdoc',$data);
    }

    function removefile($id){
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
        $cus_file = Customer_doc::where('id',$id)->first();
        $cus_id = $cus_file->cus_id;
        $deletedFile = File::delete(public_path($cus_file->doc_path.'/'.$cus_file->doc_name));
        $cus_file->delete();
        Customer_st_logs::create([
            'cus_id' => $id,
            'status' => 'removecusfile',
            'description' => "Remove customer file by ".auth()->user()->username,
            'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
            'update_by' => auth()->user()->username,
        ]);
        if($deletedFile){
            return redirect()->route('viewcusdoc',['id' => $cus_id])->with('success', $this->valid_mes['deleted']);
        }
    }

    public function getcarfile($filepath,$filename){
        $path = public_path('uploads/'.$filepath.'/'.$filename);
        return response()->file($path);
    }

    public function getuploadicon($filename){
        
        $path = public_path('images/'.$filename);
        return response()->file($path);
    }

    public function searchcus(Request $request){
        //dd($request->all());
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
            $searchTerm= $request->searchTerm;
        }else{
            return redirect()->route('carsmanage');
        }
        
        $data['cusdata'] =  CusManage::where('cus_type', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere('cus_st', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere('cus_code', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere('cus_name', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere('cus_tel', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere('cus_district', 'LIKE', '%'.$searchTerm.'%')
                        ->select('*')
                        ->paginate(10);
        $CusIds = $data['cusdata']->pluck('id')->toArray();
        $data['cardata'] = Car_manage::query()->get();
        
        
        if(!$CusIds){
            $data['cars'] = Car_manage::where('car_model','LIKE','%'.$searchTerm.'%')
                                ->orWhere('car_number', 'LIKE', '%'.$searchTerm.'%')
                                ->orWhere('engine_number', 'LIKE', '%'.$searchTerm.'%')
                                ->select('*');
            $CarIds = $data['cars']->pluck('cus_id')->toArray();
            if($CarIds){
                $data['cusdata'] = CusManage::whereIn('id', $CarIds)
                                ->select('*')
                                ->paginate(10);
            }else{
                $data['car_acc'] = Car_accessorys::where('acc_code','LIKE','%'.$searchTerm.'%')
                                ->select('*');
                $CarIds = $data['car_acc']->pluck('car_id')->toArray();
                $data['cars'] = Car_manage::whereIn('id', $CarIds)
                            ->get();
                $carCusIds = $data['cars']->pluck('cus_id')->toArray();
                $data['cusdata'] = CusManage::whereIn('id', $carCusIds)
                                ->select('*')
                                ->paginate(10);
            }
        }
        $data['branchs'] = Branch::query()->get();
        $data['cus_sts'] = Cus_st::query()->get();
        /* $data['cusdata'] = CusManage::orderBy('id','ASC')->paginate(10);
        $data['cardata'] = Car_manage::query()->get(); */

        if($data['cardata']->isNotEmpty()){
            return view('customermanage.index',$data);
        }else{
            return redirect()->route('cusmanage')->with('notfound', $valid_mes['search-notfound']);
        }    
    }

    public function store_ins_insdown(Request $request){
        //dd($request->all());
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'updated' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'updated' => 'Save data successfully',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'updated' => 'ບັນທຶກຂໍ້ມູນສໍາເລັດ',
            ];
        }
        $data = null;
            while(1){
                $data = Ins_ins_down::create([
                    'cus_id' => $request->cus_id,
                    'ins_id' => $request->ins_down_id_modal,
                    'ins_number' => $request->ins_insdown_number_modal,
                    'appoint_pay' => $request->ins_insdown_appoint_pay,
                    'payment' => $request->ins_insdown_payment,
                    'payment_date' => $request->date_ins_insdown,
                    'bill_number' => $request->ins_insdown_billnum,
                    'balance' => $request->ins_insdown_balance,
                    'fine' => $request->ins_insdown_fine,
                    'tracking_fee' => $request->ins_insdown_tracking,
                ]);
                if($data){
                    if($request->ins_insdown_balance == 0){
                        Ins_down::where('id',$request->ins_down_id_modal)->update(['status' => "close"]);
                    }
                    Customer_st_logs::create([
                        'cus_id' => $request->cus_id,
                        'status' => 'updatecusdata',
                        'description' => "Update customer data by ".auth()->user()->username,
                        'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
                        'update_by' => auth()->user()->username,
                    ]);
                    break;
                }
            }
            
            
            
            
        if($data){
            return redirect()->route('editcuscard', ['id' => $request->cus_id])->with('success', $valid_mes['updated']);
        }else{
            return redirect()->route('editcuscard', ['id' => $request->cus_id])->with('error', $valid_mes['updated']);
        }
        
    }

    public function store_discountdown(Request $request){
        //dd($request->all());
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'updated' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'updated' => 'Save data successfully',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'updated' => 'ບັນທຶກຂໍ້ມູນສໍາເລັດ',
            ];
        }
        $sub_insid = null;
        $ins_downdata = null;
        if($request->ins_down_id_discountmodal){
            if($request->ins_insdown_number_discountmodal > 1){
                $ins_downdata = Ins_ins_down::where('ins_id',$request->ins_down_id_discountmodal)->get();
            }
            if($ins_downdata){
                $sub_insid = $ins_downdata[count($ins_downdata)-1]['id'];
            }
            $datadiscount = null;
            while (1) {
                $datadiscount = Discount::create([
                    'cus_id' => $request->cus_id,
                    'ins_type' => 'insdown',
                    'ins_id' => $request->ins_down_id_discountmodal,
                    'sub_ins_id' => $sub_insid,
                    'date' => $request->discountdown_date,
                    'bill_number' => $request->discount_bill,
                    'discount' => $request->dispcountdown_pay,
                    'balance' => $request->discountdown_balance,
                    'create_by' => auth()->user()->username,
                ]);
                if($datadiscount){
                    if($datadiscount['balance'] == 0){
                        Ins_down::where('id',$datadiscount['ins_id'])->update(['status' => "close"]);
                    }
                    Customer_st_logs::create([
                        'cus_id' => $request->cus_id,
                        'status' => 'updatecusdata[discount]',
                        'description' => "Update customer data[discount] by ".auth()->user()->username,
                        'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
                        'update_by' => auth()->user()->username,
                    ]);
                    break;
                }
            }
            
        }
        
            
        if($datadiscount){
            return redirect()->route('editcuscard', ['id' => $request->cus_id])->with('success', $valid_mes['updated']);
        }else{
            return redirect()->route('editcuscard', ['id' => $request->cus_id])->with('error', $valid_mes['updated']);
        }
        
    }
    
    public function store_discountins(Request $request){
        //dd($request->all());
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'updated' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'updated' => 'Save data successfully',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'updated' => 'ບັນທຶກຂໍ້ມູນສໍາເລັດ',
            ];
        }
        $sub_insid = null;
        $ins_data = null;
        if($request->ins_id_discountmodal){
            if($request->ins_ins_number_discountmodal > 1){
                $ins_data = Ins_ins::where('ins_id',$request->ins_id_discountmodal)->get();
            }
            if($ins_data){
                $sub_insid = $ins_data[count($ins_data)-1]['id'];
            }
            $datadiscount = null;
            while(1){
                $datadiscount = Discount::create([
                    'cus_id' => $request->cus_id,
                    'ins_type' => 'ins',
                    'ins_id' => $request->ins_id_discountmodal,
                    'sub_ins_id' => $sub_insid,
                    'date' => $request->discountins_date,
                    'bill_number' => $request->discountins_bill,
                    'discount' => $request->dispcountins_pay,
                    'balance' => $request->discountins_balance,
                    'create_by' => auth()->user()->username,
                ]);
                if($datadiscount){
                    if(intval($request->discountins_balance) == 0){
                        Ins::where('id',$request->ins_id_discountmodal)->update(['status' => "close"]);
                    }
                    Customer_st_logs::create([
                        'cus_id' => $request->cus_id,
                        'status' => 'updatecusdata[discount]',
                        'description' => "Update customer data[discount] by ".auth()->user()->username,
                        'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
                        'update_by' => auth()->user()->username,
                    ]);
                    break;
                }
            }
            
        }
       
            
        if($datadiscount){
            return redirect()->route('editcuscard', ['id' => $request->cus_id])->with('success', $valid_mes['updated']);
        }else{
            return redirect()->route('editcuscard', ['id' => $request->cus_id])->with('error', $valid_mes['updated']);
        }
        
    }

    public function store_discountsubins(Request $request){
        //dd($request->all());
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'updated' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'updated' => 'Save data successfully',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'updated' => 'ບັນທຶກຂໍ້ມູນສໍາເລັດ',
            ];
        }
        $subins_data = null;
        $sub_subinsid = null;
        if($request->subins_id_discountmodal){
            if($request->subdividins_number_discountmodal > 1){
                $subins_data = Sub_dividins::where('ins_id',$request->subins_id_discountmodal)->get();
            }
            if($subins_data){
                $sub_subinsid = $subins_data[count($subins_data)-1]['id'];
            }
            //dd($sub_subinsid);
            $datadiscount = null;
            while(1){
                $datadiscount = Discount::create([
                    'cus_id' => $request->cus_id,
                    'ins_type' => 'subins',
                    'ins_id' => $request->subins_id_discountmodal,
                    'sub_ins_id' => $sub_subinsid,
                    'date' => $request->discountsubins_date_modal,
                    'bill_number' => $request->discountsubins_bill,
                    'discount' => $request->dispcountsubins_pay,
                    'balance' => $request->discountsubins_balance,
                    'create_by' => auth()->user()->username,
                ]);
                if($datadiscount){
                    echo 'id : '.$request->subins_id_discountmodal.'<br>';
                    echo 'balance : '.$request->discountsubins_balance.'<br>';
                    if(intval($request->discountsubins_balance) == 0){
                        Sub_ins::where('id',$request->subins_id_discountmodal)->update([
                            'status' => "close"
                        ]);
                    }
                    Customer_st_logs::create([
                        'cus_id' => $request->cus_id,
                        'status' => 'updatecusdata[discount]',
                        'description' => "Update customer data[discount] by ".auth()->user()->username,
                        'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
                        'update_by' => auth()->user()->username,
                    ]);
                    break;
                }
            }
            
        }
        
            
        if($datadiscount){
            return redirect()->route('editcuscard', ['id' => $request->cus_id])->with('success', $valid_mes['updated']);
        }else{
            return redirect()->route('editcuscard', ['id' => $request->cus_id])->with('error', $valid_mes['updated']);
        }
        
    }

    public function store_ins_ins(Request $request){
        //dd($request->all());
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'updated' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'updated' => 'Save data successfully',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'updated' => 'ບັນທຶກຂໍ້ມູນສໍາເລັດ',
            ];
        }
            $data = Ins_ins::create([
                    'cus_id' => $request->cus_id,
                    'ins_id' => $request->ins_ins_id_modal,
                    'ins_number' => $request->ins_ins_number_modal,
                    'appoint_pay' => $request->ins_ins_appoint_pay,
                    'payment' => $request->ins_ins_payment,
                    'payment_date' => $request->date_ins_ins,
                    'bill_number' => $request->ins_ins_billnum,
                    'balance' => $request->ins_ins_balance,
                    'fine' => $request->ins_ins_fine,
                    'tracking_fee' => $request->ins_ins_tracking,
            ]);
            if($data['balance'] == 0){
                Ins::where('id',$data['ins_id'])->update(['status' => "close"]);
            }
            Customer_st_logs::create([
                'cus_id' => $request->cus_id,
                'status' => 'updatecusdata',
                'description' => "Update customer data by ".auth()->user()->username,
                'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
                'update_by' => auth()->user()->username,
            ]);
            
        if($data){
            return redirect()->route('editcuscard', ['id' => $request->cus_id])->with('success', $valid_mes['updated']);
        }else{
            return redirect()->route('editcuscard', ['id' => $request->cus_id])->with('error', $valid_mes['updated']);
        }
        
    }

    public function store_subins(Request $request){
        //dd($request->all());
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'updated' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'updated' => 'Save data successfully',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'updated' => 'ບັນທຶກຂໍ້ມູນສໍາເລັດ',
            ];
        }
        $data = null;
        while (1) {
                $data = Sub_dividins::create([
                    'cus_id' => $request->cus_id,
                    'ins_id' => $request->subdividins_id_modal,
                    'ins_number' => $request->subdividins_number_modal,
                    'appoint_pay' => $request->subdividins_appoint_pay,
                    'payment' => $request->subdividins_payment,
                    'payment_date' => $request->date_subdividins,
                    'bill_number' => $request->subdividins_billnum,
                    'balance' => $request->subdividins_balance,
                    'fine' => $request->subdividins_fine,
                    'tracking_fee' => $request->subdividins_tracking,
                ]);
            if($data){
                if($data['balance'] == 0){
                    Sub_ins::where('id',$data['ins_id'])->update(['status' => "close"]);
                }
                Customer_st_logs::create([
                    'cus_id' => $request->cus_id,
                    'status' => 'updatecusdata',
                    'description' => "Update customer data by ".auth()->user()->username,
                    'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
                    'update_by' => auth()->user()->username,
                ]);
                break;
            }
        }
            
            
            
        if($data){
            return redirect()->route('editcuscard', ['id' => $request->cus_id])->with('success', $valid_mes['updated']);
        }else{
            return redirect()->route('editcuscard', ['id' => $request->cus_id])->with('error', $valid_mes['updated']);
        }
        
    }

    public function deletediscount($id){
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'deleted' => 'ลบข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'deleted' => 'Delete data successfully',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'deleted' => 'ລຶບຂໍ້ມູນສໍາເລັດ',
            ];
        }
        $delete = Discount::findOrFail($id);
        $id = $delete['cus_id'];
        $delete->delete();
        $ins_id = $delete['ins_id'];
        $ins_type = $delete['ins_type'];
        $update = null;
        $delete->delete();
        while (1) {
            if($ins_type == 'insdown'){
                $update = Ins_down::where('id',$ins_id)->update([
                    'status' => 'update'
                ]);
                if($update){
                    break;
                }
            }else if($ins_type == 'ins'){
                $update = Ins::where('id',$ins_id)->update([
                    'status' => 'update'
                ]);
                if($update){
                    break;
                }
            }else if($ins_type == 'subins'){
                $update = Sub_ins::where('id',$ins_id)->update([
                    'status' => 'update'
                ]);
                if($update){
                    break;
                }
            }
            
        }

        return redirect()->route('editcuscard', ['id' => $id])->with('success', $valid_mes['deleted']);
            
    }

    public function deleteinsins($id){
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'deleted' => 'ลบข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'deleted' => 'Delete data successfully',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'deleted' => 'ລຶບຂໍ້ມູນສໍາເລັດ',
            ];
        }
        $delete = Ins_ins::findOrFail($id);
        $id = $delete['cus_id'];
        $ins_id = $delete['ins_id'];
        $update = null;
        $delete->delete();
        while (1) {
            $update = Ins::where('id',$ins_id)->update([
                'status' => 'update'
            ]);
            if($update){
                break;
            }
        }

        return redirect()->route('editcuscard', ['id' => $id])->with('success', $valid_mes['deleted']);
    }

    public function deleteinsinsdown($id){
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'deleted' => 'ลบข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'deleted' => 'Delete data successfully',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'deleted' => 'ລຶບຂໍ້ມູນສໍາເລັດ',
            ];
        }
        $delete = Ins_ins_down::findOrFail($id);
        $id = $delete['cus_id'];
        $ins_id = $delete['ins_id'];
        $update = null;
        $delete->delete();
        while (1) {
            $update = Ins_down::where('id',$ins_id)->update([
                'status' => 'update'
            ]);
            if($update){
                break;
            }
        }

        return redirect()->route('editcuscard', ['id' => $id])->with('success', $valid_mes['deleted']);
    }

    public function deletesubdividins($id){
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'deleted' => 'ลบข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'deleted' => 'Delete data successfully',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'deleted' => 'ລຶບຂໍ້ມູນສໍາເລັດ',
            ];
        }
        $delete = Sub_dividins::findOrFail($id);
        $id = $delete['cus_id'];
        $ins_id = $delete['ins_id'];
        $update = null;
        $delete->delete();
        while (1) {
            $update = Sub_ins::where('id',$ins_id)->update([
                'status' => 'update'
            ]);
            if($update){
                break;
            }
        }

        return redirect()->route('editcuscard', ['id' => $id])->with('success', $valid_mes['deleted']);
    }

    public function removeadddown($id){

        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'deleted' => 'ลบข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'deleted' => 'Delete data successfully',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'deleted' => 'ລຶບຂໍ້ມູນສໍາເລັດ',
            ];
        }
        $delete = Adddownpay::findOrFail($id);
        $id = $delete['cus_id'];
        $bill_id = $delete['bill_id'];
        $ins_id = $delete['ins_id'];
        $update = null;
        if($bill_id != null){
            while (1) {
                $update = OtherBill::where('id',$bill_id)->update([
                    'cus_id' => null,
                    'cus_code' => null,
                ]);
                if($update){
                    break;
                }
            }
        }
        
        $delete->delete();
    }

    public function removeguarantor($id){

        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'deleted' => 'ลบข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'deleted' => 'Delete data successfully',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'deleted' => 'ລຶບຂໍ້ມູນສໍາເລັດ',
            ];
        }
        $delete = Guarantor::findOrFail($id);
        $id = $delete['cus_id'];
        $ins_id = $delete['ins_id'];
        $update = null;
        $delete->delete();
    }
    

    public function updatecusdata(Request $request)
    {
        //
        dd($request->all());

        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'updated' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'updated' => 'Save data successfully',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'updated' => 'ບັນທຶກຂໍ້ມູນສໍາເລັດ',
            ];
        }
        $cusdata = CusManage::where('id',$request->cus_id)->first();
        $adddowndatas = Adddownpay::where('cus_id',$request->cus_id)->get();
        if($cusdata->car_id != $request->car_id){
            $cardata = null;
            while (1) {
                $cardata = Car_manage::where('id',$cusdata->car_id)->update([
                    'cus_id' => null,
                ]);
                if($cardata){
                    $cardata = null;
                    break;
                }
            }
            while (1) {
                $cardata = Car_manage::where('id',$request->car_id)->update([
                    'cus_id' => $request->cus_id,
                ]);
                if($cardata){
                    $cardata = null;
                    break;
                }
            }
        }

        if($request->cus_id){
            $ins_type = $request->ins_type;
            $ins_type_ljt = 0;
            $ins_type_money = 0;

            $insdown_flag = null;
            $ins_flag = null;

            for ($i=0; $i < count($ins_type); $i++) { 
                if($ins_type[$i] == 'LJT'){
                    $ins_type_ljt = 1;
                }else if($ins_type[$i] == 'Money'){
                    $ins_type_money = 1;
                }
            }
            //dd($request->all());
            //$divid_ins = $request->divid_ins_small;
            if($request->divid_ins_small != "" && ($request->divid_ins_large !="" && intval($request->divid_ins_large) > 0)){
                $divid_ins = $request->divid_ins_small.'/'.$request->divid_ins_large;
            }else if($request->divid_ins_small != "" && ($request->divid_ins_large =="" || intval($request->divid_ins_large) == 0 || $request->divid_ins_large =="-")){
                $divid_ins = $request->divid_ins_small;
            }else if($request->divid_ins_small == "" && ($request->divid_ins_large !="" && intval($request->divid_ins_large) > 0)){
                $divid_ins = $request->divid_ins_large;
            }
            $updatecus = null;
            while (1) {
                $updatecus = CusManage::where('id',$request->cus_id)->update([
                                'cus_code' => $request->cus_code,
                                'cus_name' => $request->cus_name,
                                'cus_idcard' => $request->cus_idcard,
                                'cus_age' => $request->cus_age,
                                'cus_bd' => $request->cus_bd,
                                'cus_tel' => $request->cus_tel,
                                'cus_address' => $request->cus_address,
                                'cus_group' => $request->cus_group,
                                'cus_village' => $request->cus_village,
                                'cus_city' => $request->cus_city,
                                'cus_district' => $request->cus_district,
                                'cus_branch' => $request->cus_branch,
                                'car_id' => $request->car_id,
                                'cus_type' => $request->cus_type,
                                'cus_st' => $request->cus_st,
                                'ins_LJT' => $ins_type_ljt,
                                'ins_money' => $ins_type_money,
                                'promotion' => $request->promotion,
                                'total_price' => $request->total_price,
                                'discount' => $request->discount,
                                'net_price' => $request->net_price,
                                'down_pay' => $request->down_pay,
                                'deposit' => $request->deposit,
                                'deposit_date' => $request->deposit_date,
                                'bill_num_deposit' => $request->deposit_bill_number,
                                'down_pay_deli' => $request->down_pay_deli,
                                'bill_num_down_pay_deli' => $request->down_pay_deli_bill_number,
                                'total_pay_deli' => $request->total_pay_deli,
                                'total_pay_deli_date' => $request->total_pay_deli_date,
                                'remaining' => $request->remaining,
                                'interest_rate' => $request->interest_rate,
                                'ins_style' => $request->ins_style,
                                'ins_style_type' => $request->ins_style_type,
                                'ins_long' => $request->ins_long,
                                'ins_long_type' => $request->ins_long_type,
                                'divid_ins' => $divid_ins,
                                'deli_date' => $request->deli_date,
                                'stock' => $request->stock,
                                'start_ins' => $request->start_ins,
                                'note' => $request->note,
                            ]);
                if($updatecus){
                    break;
                }
            }
        }
        
        if($request->guarantor_id){
            for ($i=0; $i < count($request->guarantor_id) ; $i++) { 
                $guarantor = null;
                while (1) {
                    if($request->guarantor_id[$i] != 'null'){
                        $guarantor = Guarantor::where('id',$request->guarantor_id[$i])->update([
                            'cus_id' => $request->cus_id,
                            'name' => $request->guarantor_name[$i],
                            'idcard' => $request->guarantor_idcard[$i],
                            'age' => $request->guarantor_age[$i],
                            'bd' => $request->guarantor_bd[$i],
                            'tel' => $request->guarantor_tel[$i],
                            'address' => $request->guarantor_address[$i],
                            'group' => $request->guarantor_group[$i],
                            'village' => $request->guarantor_village[$i],
                            'city' => $request->guarantor_city[$i],
                            'district' => $request->guarantor_district[$i],
                        ]);
                    }else{
                        $guarantor = Guarantor::create([
                            'cus_id' => $request->cus_id,
                            'name' => $request->guarantor_name[$i],
                            'idcard' => $request->guarantor_idcard[$i],
                            'age' => $request->guarantor_age[$i],
                            'bd' => $request->guarantor_bd[$i],
                            'tel' => $request->guarantor_tel[$i],
                            'address' => $request->guarantor_address[$i],
                            'group' => $request->guarantor_group[$i],
                            'village' => $request->guarantor_village[$i],
                            'city' => $request->guarantor_city[$i],
                            'district' => $request->guarantor_district[$i],
                        ]);
                    }
                    if($guarantor){
                        break;
                    }
                }
            }
        }

        if($request->adddown_pay){
            
            for ($i=0; $i < count($request->adddownpay_id) ; $i++) { 
                $adddown = null;
                $bill_id = null;
                if($request->adddownselect[$i] != 0){
                    $bill_id = $request->adddownselect[$i];
                }
                while (1) {
                    if($request->adddownpay_id[$i] > 0){
                        dd($request->adddownpay_id[$i]);
                        $adddown = Adddownpay::where('id',$request->adddownpay_id[$i])->update([
                            'date' => $request->adddown_date[$i],
                            'bill_id' => $bill_id,
                            'bill_number' => $request->adddown_billnumber[$i],
                            'payment' => $request->adddown_pay[$i],
                        ]);
                    }else{
                        dd($request->adddownpay_id[$i]);
                        $adddown = Adddownpay::create([
                            'cus_id' => $request->cus_id,
                            'number' => $i+1,
                            'date' => $request->adddown_date[$i],
                            'bill_id' => $bill_id,
                            'bill_number' => $request->adddown_billnumber[$i],
                            'payment' => $request->adddown_pay[$i],
                            'create_by' => auth()->user()->username,
                        ]);
                    }
                    
                    if($bill_id != null){
                        $bill = null;
                        while (1) {
                            $bill = OtherBill::where('id',$bill_id)->update([
                                'cus_id' => $request->cus_id,
                                'cus_code' => $request->cus_code,
                            ]);
                            if($bill){
                                break;
                            }
                        }
                    }else{
                        for ($k=0; $k < count($adddowndatas) ; $k++) { 
                            if($adddowndatas[$k]->id == $request->adddownpay_id[$i] && $adddowndatas[$k]->bill_id != null){
                                $update = null;
                                while (1) {
                                    $update = OtherBill::where('id',$adddowndatas[$k]->bill_id)->update([
                                        'cus_id' => null,
                                        'cus_code' => null,
                                    ]);
                                    if($update){
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    if($adddown){
                        break;
                    }
                }
            }
        }

        if($request->ins_down_appoint_pay){
            if($request->insdown_id){
                for ($i=0; $i < count($request->insdown_id) ; $i++) {
                    $nsdown = null;             
                    while (1) {
                        $nsdown = Ins_down::where('id',$request->insdown_id[$i])->update([
                            'appoint_date' => $request->ins_down_appoint_date[$i],
                            'appoint_pay' => $request->ins_down_appoint_pay[$i],
                        ]);
                        if($nsdown){
                            break;
                        }
                    }
                }
            }else{
                for ($i=0; $i < count($request->ins_down_appoint_pay) ; $i++) {   
                    $nsdown = null;
                    $updated = null;
                    while (1) {
                        $update = Ins_down::where('cus_id',$request->cus_id)->update([
                            'cus_id' => $request->cus_id.'old',
                        ]);
                        if($update){
                            $updated = null;
                            break;
                        }
                    }
                    while (1) {
                        $update = Ins_ins_down::where('cus_id',$request->cus_id)->update([
                            'cus_id' => $request->cus_id.'old',
                        ]);
                        if($update){
                            $updated = null;
                            break;
                        }
                    }
                    while (1) {
                        $update = Discount::where('cus_id',$request->cus_id)
                        ->where('ins_type','insdown')
                        ->update([
                            'cus_id' => $request->cus_id.'old',
                        ]);
                        if($update){
                            $updated = null;
                            break;
                        }
                    }
                    while (1) {
                        $nsdown = Ins_down::create([
                            'cus_id' => $request->cus_id,
                            'cus_code' => $request->cus_code,
                            'ins_down_number' => $i+1,
                            'appoint_date' => $request->ins_down_appoint_date[$i],
                            'appoint_pay' => $request->ins_down_appoint_pay[$i],
                            'balance' => $request->ins_down_appoint_pay[$i],
                            'status' => 'new',
                        ]);
                        if($nsdown){
                            break;
                        }
                    }
                }
            }
        }
        
        if($request->ins_appoint_pay){
            if($request->ins_id){
                for ($i=0; $i < count($request->ins_id) ; $i++) {
                    $ns = null;             
                    while (1) {
                        $ns = Ins::where('id',$request->ins_id[$i])->update([
                            'appoint_date' => $request->ins_appoint_date[$i],
                            'appoint_pay' => $request->ins_appoint_pay[$i],
                        ]);
                        if($ns){
                            break;
                        }
                    }
                }
            }else{
                for ($i=0; $i < count($request->ins_appoint_pay) ; $i++) {   
                    $ns = null;  
                    $updated = null;
                    while (1) {
                        $update = Ins::where('cus_id',$request->cus_id)->update([
                            'cus_id' => $request->cus_id.'old',
                        ]);
                        if($update){
                            $updated = null;
                            break;
                        }
                    }
                    while (1) {
                        $update = Ins_ins::where('cus_id',$request->cus_id)->update([
                            'cus_id' => $request->cus_id.'old',
                        ]);
                        if($update){
                            $updated = null;
                            break;
                        }
                    }
                    while (1) {
                        $update = Discount::where('cus_id',$request->cus_id)
                        ->where('ins_type','ins')
                        ->update([
                            'cus_id' => $request->cus_id.'old',
                        ]);
                        if($update){
                            $updated = null;
                            break;
                        }
                    }           
                    while (1) {
                        $ns = Ins::create([
                            'cus_id' => $request->cus_id,
                            'cus_code' => $request->cus_code,
                            'ins_down_number' => $i+1,
                            'appoint_date' => $request->ins_appoint_date[$i],
                            'appoint_pay' => $request->ins_appoint_pay[$i],
                            'balance' => $request->ins_appoint_pay[$i],
                            'status' => 'new',
                        ]);
                        if($ns){
                            break;
                        }
                    }
                }
            }
        }

        Customer_st_logs::create([
            'cus_id' => $request->cus_id,
            'status' => 'editapprovedcusdata',
            'description' => "Edit approved customer data by ".auth()->user()->username,
            'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
            'update_by' => auth()->user()->username,
        ]);
        if($cusdata->cus_st != $request->cus_st){
            Customer_st_logs::create([
                'cus_id' => $request->cus_id,
                'status' => 'changecus_st',
                'description' => "Change Customer Status from ".$cusdata['cus_st']." to ".$request->cus_st." by ".auth()->user()->username,
                'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
                'update_by' => auth()->user()->username,
            ]);
        }
        return redirect()->route('editcusdata', ['id' => $request->cus_id])->with('success', $valid_mes['updated']);
    }
}
