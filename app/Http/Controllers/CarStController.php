<?php

namespace App\Http\Controllers;

use App\Models\Car_st;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CarStController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['car_sts'] = Car_st::orderBy('id','ASC')->paginate(10);
        return view('setting.car_st_manage.index',$data);
    }

    public function newform()
    {
        //
        return view('setting.car_st_manage.newcar_st');
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
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'name-string' => 'กรุณาระบุชื่อสถานะรถ',
                'name-unique' => 'กรุณาตรวจสอบชื่อสถานะรถ',
                'added-car-st' => 'เพิ่มสถานะรถใหม่สำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'name-string' => 'Please enter the name of the car status.',
                'name-unique' => 'Please check car status name.',
                'added-car-st' => 'Successfully added a new car status.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'name-string' => 'ກະລຸນາລະບຸຊື່ຂອງສະຖານະລົດ.',
                'name-unique' => 'ກະລຸນາກວດເບິ່ງຊື່ຂອງສະຖານະລົດ.',
                'added-car-st' => 'ເພີ່ມສະຖານະລົດໃໝ່ສຳເລັດແລ້ວ.',
            ];
        }

        Car_st::create([
            'keyword' => $request->keyword,
            'thai' => $request->thai,
            'lao' => $request->lao,
            'eng' => $request->eng,
            'create by' => auth()->user()->username,
            'create at' => Carbon::now()->format('d-m-Y H:i:s'),
        ]);
        return redirect()->route('carstatus')->with('success', $valid_mes['added-car-st']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car_st  $car_st
     * @return \Illuminate\Http\Response
     */
    public function show(Car_st $car_st)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car_st  $car_st
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $car_st =  Car_st::find($id);
        if($car_st){
            return view('setting.car_st_manage.editcar_st',compact('car_st'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car_st  $car_st
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if(session()->get('locale') == 'th'){
            $this->valid_mes = [
                'name-string' => 'กรุณาตรวจสอบชื่อสถานะรถ',
                'success-mes' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $this->valid_mes = [
                'name-string' => 'Please check car status name.',
                'success-mes' => 'Save data successfully.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $this->valid_mes = [
                'name-string' => 'ກະລຸນາກວດສອບຊື່ສະຖານະລົດ.',
                'success-mes' => 'ບັນທຶກຂໍ້ມູນສຳເລັດແລ້ວ.',
            ];
        }


        $car_st =  Car_st::find($id);
        $car_st->keyword = $request->keyword;
        $car_st->thai = $request->thai;
        $car_st->lao = $request->lao;
        $car_st->eng = $request->eng;
        $car_st->save();
        return redirect()->route('editcar-st', ['id' => $id])->with('success', $this->valid_mes['success-mes']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car_st  $car_st
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

        $cus_st =  Car_st::find($id);
        
        $cus_st->delete();
        return redirect()->route('carstatus')->with('success', $this->valid_mes['deleted']);
    }

    public function search(Request $request){
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
            return redirect()->route('carstatus');
        }
        
        $car_sts =  Car_st::where('keyword', 'LIKE', '%'.$searchTerm.'%')
                        ->orwhere('thai', 'LIKE', '%'.$searchTerm.'%')
                        ->orwhere('lao', 'LIKE', '%'.$searchTerm.'%')
                        ->orwhere('eng', 'LIKE', '%'.$searchTerm.'%')
                        ->select('*')
                        ->paginate(10);

        if($car_sts->isNotEmpty()){
            return view('setting.car_st_manage.index',compact('car_sts'));
        }else{
            return redirect()->route('carstatus')->with('notfound', $valid_mes['search-notfound']);
        }    
    }
}
