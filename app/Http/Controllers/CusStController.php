<?php

namespace App\Http\Controllers;

use App\Models\Cus_st;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CusStController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['cus_sts'] = Cus_st::orderBy('id','ASC')->paginate(10);
        return view('setting.cus_st_manage.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function newform()
    {
        //
        return view('setting.cus_st_manage.newcus_st');
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
                'name-string' => 'กรุณาระบุชื่อสถานะลูกค้า',
                'name-unique' => 'กรุณาตรวจสอบชื่อสถานะลูกค้า',
                'added-cus-st' => 'เพิ่มสถานะลูกค้าใหม่สำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'name-string' => 'Please enter the name of the customer status.',
                'name-unique' => 'Please check customer status name.',
                'added-cus-st' => 'Successfully added a new customer status.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'name-string' => 'ກະລຸນາລະບຸຊື່ຂອງສະຖານະລູກຄ້າ.',
                'name-unique' => 'ກະລຸນາກວດເບິ່ງຊື່ຂອງສະຖານະລູກຄ້າ.',
                'added-cus-st' => 'ເພີ່ມສະຖານະລູກຄ້າໃໝ່ສຳເລັດແລ້ວ.',
            ];
        }
        Cus_st::create([
            'keyword' => $request->keyword,
            'thai' => $request->thai,
            'lao' => $request->lao,
            'eng' => $request->eng,
            'create by' => auth()->user()->username,
            'create at' => Carbon::now()->format('d-m-Y H:i:s'),
        ]);
        return redirect()->route('customerstatus')->with('success', $valid_mes['added-cus-st']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cus_st  $cus_st
     * @return \Illuminate\Http\Response
     */
    public function show(cus_st $cus_st)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cus_st  $cus_st
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $cus_st =  Cus_st::find($id);
        if($cus_st){
            return view('setting.cus_st_manage.editcus_st',compact('cus_st'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\cus_st  $cus_st
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if(session()->get('locale') == 'th'){
            $this->valid_mes = [
                'name-string' => 'กรุณาตรวจสอบชื่อสถานะลูกค้า',
                'success-mes' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $this->valid_mes = [
                'name-string' => 'Please check customer status name.',
                'success-mes' => 'Save data successfully.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $this->valid_mes = [
                'name-string' => 'ກະລຸນາກວດສອບຊື່ສະຖານະລູກຄ້າ.',
                'success-mes' => 'ບັນທຶກຂໍ້ມູນສຳເລັດແລ້ວ.',
            ];
        }


        $cus_st =  Cus_st::find($id);
        $cus_st->keyword = $request->keyword;
        $cus_st->thai = $request->thai;
        $cus_st->lao = $request->lao;
        $cus_st->eng = $request->eng;
        $cus_st->save();
        return redirect()->route('editcus-st', ['id' => $id])->with('success', $this->valid_mes['success-mes']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cus_st  $cus_st
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

        $cus_st =  Cus_st::find($id);
        
        $cus_st->delete();
        return redirect()->route('customerstatus')->with('success', $this->valid_mes['deleted']);
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
            return redirect()->route('customerstatus');
        }
        
        $cus_sts =  Cus_st::where('keyword', 'LIKE', '%'.$searchTerm.'%')
                        ->orwhere('thai', 'LIKE', '%'.$searchTerm.'%')
                        ->orwhere('lao', 'LIKE', '%'.$searchTerm.'%')
                        ->orwhere('eng', 'LIKE', '%'.$searchTerm.'%')
                        ->select('*')
                        ->paginate(10);

        if($cus_sts->isNotEmpty()){
            return view('setting.cus_st_manage.index',compact('cus_sts'));
        }else{
            return redirect()->route('customerstatus')->with('notfound', $valid_mes['search-notfound']);
        }    
    }
}
