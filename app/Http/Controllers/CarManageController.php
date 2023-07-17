<?php

namespace App\Http\Controllers;

use App\Models\Car_manage;
use App\Models\Car_st;
use App\Models\Cus_st;
use App\Models\Car_accessorys;
use App\Models\Car_status_logs;
use App\Models\Upload_file_car;
use App\Models\CusManage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

Carbon::setLocale('th');

class CarManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['cars'] = Car_manage::orderBy('id','ASC')->paginate(20);
        $carCusIds = $data['cars']->pluck('cus_id')->toArray();
        $data['cuss'] = CusManage::whereIn('id', $carCusIds)->get();
        $data['car_sts'] = Car_st::query()->get();
        return view('carsmanage.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['car_sts'] = Car_st::query()->get();
        return view('carsmanage.newcar',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'carmodel-string' => 'กรุณาระบุรุ่นรถ',
                'carnumber-string' => 'กรุณาระบุเลขตัวถัง',
                'carnumber-unique' => 'เลขตัวถังนี้มีในระบบแล้ว',
                'engine_number' => 'กรุณาระบุเลขเครื่องยนต์',
                'car-st-string' => 'กรุณาระบุสถานะรถ',
                'car-price-string' => 'กรุณาระบุราคารถ',
                'car-sumprice-string' => 'กรุณาระบุราคารวมรถ',
                'success-mes' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'carmodel-string' => 'กรุณาระบุรุ่นรถ',
                'carnumber-string' => 'กรุณาระบุเลขตัวถัง',
                'carnumber-unique' => 'เลขตัวถังนี้มีในระบบแล้ว',
                'engine_number' => 'กรุณาระบุเลขเครื่องยนต์',
                'car-st-string' => 'กรุณาระบุสถานะรถ',
                'car-price-string' => 'กรุณาระบุราคารถ',
                'car-sumprice-string' => 'กรุณาระบุราคารวมรถ',
                'success-mes' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'carmodel-string' => 'กรุณาระบุรุ่นรถ',
                'carnumber-string' => 'กรุณาระบุเลขตัวถัง',
                'carnumber-unique' => 'เลขตัวถังนี้มีในระบบแล้ว',
                'engine_number' => 'กรุณาระบุเลขเครื่องยนต์',
                'car-st-string' => 'กรุณาระบุสถานะรถ',
                'car-price-string' => 'กรุณาระบุราคารถ',
                'car-sumprice-string' => 'กรุณาระบุราคารวมรถ',
                'success-mes' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }
        $request->validate([
            'car_model' => ['required','string'],
            'car_number' => ['required','string', 'unique:car_manages'],
            'engine_number' => ['required','string'],
            'car_st' => ['required'],
            'car_price' => ['required'],
            'sum_price' => ['required'],
        ],
        [
            'car_model.required' => $valid_mes['carmodel-string'],
            'car_number.required' => $valid_mes['carnumber-string'],
            'car_number.unique' => $valid_mes['carnumber-unique'],  
            'engine_number.required' => $valid_mes['engine_number'],
            'car_st.required' => $valid_mes['car-st-string'],
            'car_price.required' => $valid_mes['car-price-string'],
            'sum_price.required' => $valid_mes['car-sumprice-string'],
            
        ]);
        $total_acc_price = 0;
        $total_expenses = 0;
        $cardata = Car_manage::create([
            'car_model' => $request->car_model,
            'car_number' => $request->car_number,
            'engine_number' => $request->engine_number,
            'car_st' => $request->car_st,
            'car_price' => $request->car_price,
            'total_acc_price' => $request->total_acc_price,
            'car_expenses' => $request->car_expenses,
            'sum_price' => $request->sum_price,
            'update_date' => Carbon::now(),
            'create_by' => auth()->user()->username,
        ]);
        $acc_type = $request->car_acc_type;
        if($request->car_acc_type && $cardata){
            for ($i=0; $i < count($request->car_acc_type) ; $i++) { 
                if($request->acc_type[$i] !=''){
                    $acc_type[$i] = $request->acc_type[$i];
                }
                $accdata = Car_accessorys::create([
                    'car_id' => $cardata->id,
                    'car_acc_type' => $acc_type[$i],
                    'acc_brand' => $request->acc_brand[$i],
                    'acc_model' => $request->acc_model[$i],
                    'acc_code' => $request->acc_code[$i],
                    'acc_price' => $request->price[$i],
                ]);
                $total_acc_price += $request->price[$i];
            }
        }
        
        if($cardata){
            Car_status_logs::create([
                'car_id' => $cardata->id,
                'status' => "เพิ่มเข้าระบบ",
                'expenses' => '0',
                'description' => '',
                'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
                'update_by' => auth()->user()->username,
            ]);
        }
        
        return redirect()->route('detailcar', ['id' => $cardata->id])->with('success', $valid_mes['success-mes']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car_manage  $car_manage
     * @return \Illuminate\Http\Response
     */
    public function uploadform($id)
    {
        //
        $data['id'] = $id;
        return view('carsmanage.upload_file',$data);
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
        $path = 'uploads/Cars/car_id_'.$id;
        foreach ($files as $file) {
            $name = uniqid().'_'.$request->doc_name.'_'.$number. '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path), $name);
            $number++;
            Upload_file_car::create([
                'car_id' => $id,
                'file_path' => $path,
                'file_name' => $name,
            ]);
        }
        Car_status_logs::create([
            'car_id' => $id,
            'status' => "uploadfile",
            'expenses' => '0',
            'description' => 'Upload File by '.auth()->user()->username,
            'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
            'update_by' => auth()->user()->username,
        ]);
        return redirect()->route('uploadform_car', ['id' => $id])->with('success', $valid_mes['success-mes']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car_manage  $car_manage
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        
    }

    public function detail($id){
        $cusdata = null;
        $cus_st = null;
        $car_data = Car_manage::where('id',$id)->first();
        $car_acc_data = Car_accessorys::where('car_id',$id)->get();
        $car_logs = Car_status_logs::where('car_id',$id)->get();
        $car_file = Upload_file_car::where('car_id',$id)->get();
        $car_sts = Car_st::query()->get();
        if($car_data['cus_id']){
            $cusdata = CusManage::where('id', $car_data['cus_id'])->first();
            if($cusdata['cus_st']){
                $cus_st = Cus_st::where('keyword',$cusdata['cus_st'])->first();
            }
        }
        //dd($cus_st['keyword']);
        return view('carsmanage.detail',[
            'car_data' => $car_data,
            'car_acc_data' => $car_acc_data,
            'car_logs' => $car_logs,
            'car_sts' => $car_sts,
            'car_file' => $car_file,
            'cusdata' => $cusdata,
            'cus_st' => $cus_st,
        ]);
    }
    
    public function detaildata($id){
        $car_data = Car_manage::where('id',$id)->first();
        $car_acc_data = Car_accessorys::where('car_id',$id)->get();
        $car_file = Upload_file_car::where('car_id',$id)->get();
        $car_st = Car_st::where('keyword',$car_data['car_st'])->first();
        //$carCusIds = $car_data->pluck('cus_id');
        //$data['cuss'] = CusManage::whereIn('id', $carCusIds)->get();
        //dd($carCusIds);
        return compact('car_data','car_acc_data','car_file','car_st');
    }   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car_manage  $car_manage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //

        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'carmodel-string' => 'กรุณาระบุรุ่นรถ',
                'carnumber-string' => 'กรุณาระบุเลขตัวถัง',
                'carnumber-unique' => 'เลขตัวถังนี้มีในระบบแล้ว',
                'engine_number' => 'กรุณาระบุเลขเครื่องยนต์',
                'car-st-string' => 'กรุณาระบุสถานะรถ',
                'car-price-string' => 'กรุณาระบุราคารถ',
                'car-sumprice-string' => 'กรุณาระบุราคารวมรถ',
                'success-mes' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'carmodel-string' => 'กรุณาระบุรุ่นรถ',
                'carnumber-string' => 'กรุณาระบุเลขตัวถัง',
                'carnumber-unique' => 'เลขตัวถังนี้มีในระบบแล้ว',
                'engine_number' => 'กรุณาระบุเลขเครื่องยนต์',
                'car-st-string' => 'กรุณาระบุสถานะรถ',
                'car-price-string' => 'กรุณาระบุราคารถ',
                'car-sumprice-string' => 'กรุณาระบุราคารวมรถ',
                'success-mes' => 'Save data successfully',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'carmodel-string' => 'กรุณาระบุรุ่นรถ',
                'carnumber-string' => 'กรุณาระบุเลขตัวถัง',
                'carnumber-unique' => 'เลขตัวถังนี้มีในระบบแล้ว',
                'engine_number' => 'กรุณาระบุเลขเครื่องยนต์',
                'car-st-string' => 'กรุณาระบุสถานะรถ',
                'car-price-string' => 'กรุณาระบุราคารถ',
                'car-sumprice-string' => 'กรุณาระบุราคารวมรถ',
                'success-mes' => 'ບັນທຶກຂໍ້ມູນສໍາເລັດ',
            ];
        }
        $request->validate([
            'car_model' => ['required','string'],
            'car_number' => ['required','string'],
            'engine_number' => ['required','string'],
            'car_st' => ['required'],
            'car_price' => ['required'],
            'sum_price' => ['required'],
        ],
        [
            'car_model.required' => $valid_mes['carmodel-string'],
            'car_number.required' => $valid_mes['carnumber-string'],
            'engine_number.required' => $valid_mes['engine_number'],
            'car_st.required' => $valid_mes['car-st-string'],
            'car_price.required' => $valid_mes['car-price-string'],
            'sum_price.required' => $valid_mes['car-sumprice-string'],
            
        ]);
        
        $acc_type = $request->car_acc_type;
        $cardata = Car_manage::where('id', $id)->update([
            'car_model' => $request->car_model,
            'car_number' => $request->car_number,
            'engine_number' => $request->engine_number,
            'car_st' => $request->car_st,
            'car_price' => $request->car_price,
            'total_acc_price' => $request->total_acc_price,
            'car_expenses' => $request->car_expenses,
            'sum_price' => $request->sum_price,
            'update_date' => Carbon::now(),
        ]);
        if($request->acc_remove_list != ''){
            $acc_remove = Car_accessorys::where('id',$request->acc_remove_list)->delete();
        }
        //dd($request->all());
        if($request->car_acc_type){
            for ($i=0; $i < count($request->car_acc_type) ; $i++) { 
                if($request->acc_type[$i] !=''){
                    $acc_type[$i] = $request->acc_type[$i];
                }
                if($request->acc_id[$i] != null){
                    $accdata = Car_accessorys::where('id',$request->acc_id[$i])->update([
                        'car_id' => $id,
                        'car_acc_type' => $acc_type[$i],
                        'acc_brand' => $request->acc_brand[$i],
                        'acc_model' => $request->acc_model[$i],
                        'acc_code' => $request->acc_code[$i],
                        'acc_price' => $request->price[$i],
                    ]);
                }else{
                    $accdata = Car_accessorys::create([
                        'car_id' => $id,
                        'car_acc_type' => $acc_type[$i],
                        'acc_brand' => $request->acc_brand[$i],
                        'acc_model' => $request->acc_model[$i],
                        'acc_code' => $request->acc_code[$i],
                        'acc_price' => $request->price[$i],
                    ]);
                }
                
            }
        }
        if($cardata){
            Car_status_logs::create([
                'car_id' => $id,
                'status' => "แก้ไขข้อมูล",
                'expenses' => '0',
                'description' => '',
                'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
                'update_by' => auth()->user()->username,
            ]);
        }

    return redirect()->route('detailcar', ['id' => $id])->with('success', $valid_mes['success-mes']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car_manage  $car_manage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car_manage $car_manage)
    {
        //
    }

    public function newhistory($id)
    {
        //
        
        $data['id'] = $id;
        $data['car_sts'] = Car_st::query()->get();
        //dd($data);
        return view('carsmanage.newhistory',$data);
    }

    public function addhistory(Request $request,$id)
    {
        //
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
        Car_status_logs::create([
            'car_id' => $id,
            'status' => $request->car_st,
            'expenses' => $request->car_expenses,
            'description' => $request->car_description,
            'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
            'update_by' => auth()->user()->username,
        ]);
        $cardata = Car_manage::where('id',$id)->first();
        $records = Car_status_logs::where('car_id', $id)->get();
        $total_expenses = 0;
        $totla_price = 0;
        foreach ($records as $record) {
            $total_expenses += $record->expenses;
        }
        $total_price = intval($total_expenses) + intval($cardata->total_acc_price) + intval($cardata->car_price);

        if(intval($request->car_expenses) > 0){
            Car_manage::where('id', $id)->update([
                'car_model' => $cardata->car_model,
                'car_number' => $cardata->car_number,
                'engine_number' => $cardata->engine_number,
                'car_st' => $cardata->car_st,
                'car_price' => $cardata->car_price,
                'total_acc_price' => $cardata->total_acc_price,
                'car_expenses' => $total_expenses,
                'sum_price' => $total_price,
                'update_date' => Carbon::now(),
            ]);
        }

        return redirect()->route('detailcar', ['id' => $id])->with('success', $valid_mes['success-mes']);
    }

    public function detailhistory($id){
        
       
        $car_sts = Car_st::query()->get();
        $car_log = Car_status_logs::where('id',$id)->first();

        $id = $car_log->car_id;
        //dd($data);
        return view('carsmanage.detailhistory',compact([
            'car_sts',
            'car_log',
            'id',
        ]));
    }

    public function deletecarhistory($id){
        if(session()->get('locale') == 'th'){
            $this->valid_mes = [
                'deleted' => 'ลบข้อมูลเรียบร้อยแล้ว',
            ];
        }else if(session()->get('locale') == 'en'){
            $this->valid_mes = [
                'deleted' => 'Data has been deleted.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $this->valid_mes = [
                'deleted' => 'ຂໍ້ມູນຖືກລຶບແລ້ວ.',
            ];
        }

        $car_log =  Car_status_logs::find($id);
        $id = $car_log->car_id;
        $car_log->delete();
        $records = Car_status_logs::where('car_id', $id)->get();
        $total_expenses = 0;
        foreach ($records as $record) {
            $total_expenses += $record->expenses;
        }
        $cardata = Car_manage::where('id',$id)->first();
        
        $total_price = intval($total_expenses) + intval($cardata->car_price) + intval($cardata->total_acc_price);
            Car_manage::where('id', $id)->update([
                'car_model' => $cardata->car_model,
                'car_number' => $cardata->car_number,
                'engine_number' => $cardata->engine_number,
                'car_st' => $cardata->car_st,
                'car_price' => $cardata->car_price,
                'total_acc_price' => $cardata->total_acc_price,
                'car_expenses' => $total_expenses,
                'sum_price' => $total_price,
                'update_date' => Carbon::now(),
            ]);
        
        
        return redirect()->route('detailcar',['id' => $id])->with('success', $this->valid_mes['deleted']);
    }

    public function updatehistory(Request $request,$id){
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
        $car_log = Car_status_logs::where('id',$id)->first();
        
        Car_status_logs::where('id',$id)->update([
            'car_id' => $car_log->car_id,
            'status' => $request->car_st,
            'expenses' => $request->car_expenses,
            'description' => $request->car_description,
            'update_at' => Carbon::now()->format('d-m-Y H:i:s'),
            'update_by' => auth()->user()->username,
        ]);
        $id = $car_log->car_id;
        $records = Car_status_logs::where('car_id', $id)->get();
        $total_expenses = 0;
        foreach ($records as $record) {
            $total_expenses += $record->expenses;
        }
        $car_data = Car_manage::where('id',$car_log->car_id)->first();
        $total_price = intval($total_expenses) + intval($car_data->car_price) + intval($car_data->total_acc_price);
            Car_manage::where('id', $id)->update([
                'car_model' => $car_data->car_model,
                'car_number' => $car_data->car_number,
                'engine_number' => $car_data->engine_number,
                'car_st' => $car_data->car_st,
                'car_price' => $car_data->car_price,
                'total_acc_price' => $car_data->total_acc_price,
                'car_expenses' => $total_expenses,
                'sum_price' => $total_price,
                'update_date' => Carbon::now(),
            ]);
        
        return redirect()->route('detailcar',['id' => $id])->with('success', $valid_mes['success-mes']);
    }

    public function removefile ($id){
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
        $car_file = Upload_file_car::where('id',$id)->first();
        $car_id = $car_file->car_id;
        $deletedFile = File::delete(public_path($car_file->file_path.'/'.$car_file->file_name));
        $car_file->delete();
        if($deletedFile){
            return redirect()->route('detailcar',['id' => $car_id])->with('success', $this->valid_mes['deleted']);
        }
        return redirect()->route('detailcar',['id' => $car_id])->with('success', $this->valid_mes['delete_fail']);
    }

    public function getcarfile($filepath,$filename){
        $path = public_path('uploads/'.$filepath.'/'.$filename);
        return response()->file($path);
    }

    public function getuploadicon($filename){
        
        $path = public_path('images/'.$filename);
        return response()->file($path);
    }

    public function searchcar(Request $request){
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
        
        $data['cars'] =  Car_manage::where('car_model', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere('car_number', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere('engine_number', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere('car_st', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere('car_price', 'LIKE', '%'.$searchTerm.'%')
                        ->select('*')
                        ->paginate(10);
        $carCusIds = $data['cars']->pluck('cus_id')->toArray();
        $data['cuss'] = CusManage::whereIn('id', $carCusIds)->get();
        
        
        if(!$carCusIds){
            $data['car_acc'] = Car_accessorys::where('acc_code','LIKE','%'.$searchTerm.'%')
                                ->select('*');
            $CarIds = $data['car_acc']->pluck('car_id')->toArray();
            if($CarIds){
                $data['cars'] = Car_manage::whereIn('id', $CarIds)
                                ->select('*')
                                ->paginate(10);
                $carCusIds = $data['cars']->pluck('cus_id')->toArray();
                $data['cuss'] = CusManage::whereIn('id', $carCusIds)->get();
            }else{
                $data['cus'] = CusManage::where('cus_code','LIKE','%'.$searchTerm.'%')
                                ->select('*');
                $CusIds = $data['cus']->pluck('id')->toArray();
                $data['cars'] = Car_manage::whereIn('cus_id', $CusIds)
                            ->select('*')
                            ->paginate(10);
                $carCusIds = $data['cars']->pluck('cus_id')->toArray();
                $data['cuss'] = CusManage::whereIn('id', $carCusIds)->get();
            }
        }
        $data['cus_sts'] = Cus_st::query()->get();
        $data['car_sts'] = Car_st::query()->get();
        /* $data['cus'] = CusManage::where('acc_code','LIKE','%'.$searchTerm.'%')->first();
        $carCusIds = $data['cars']->pluck('cus_id')->toArray();
        $data['cuss'] = CusManage::whereIn('id', $carCusIds)->get(); */

        if($data['cars']->isNotEmpty()){
            return view('carsmanage.index',$data);
        }else{
            return redirect()->route('carsmanage')->with('notfound', $valid_mes['search-notfound']);
        }    
    }

    
}

