<?php

namespace App\Http\Controllers;

use App\Models\Bill_st;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BillStController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['bill_sts'] = Bill_st::orderBy('id','ASC')->paginate(10);
        return view('setting.bill_st_manage.index',$data);
    }

    public function newform()
    {
        //
        return view('setting.bill_st_manage.newbill_st');
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
                'name-string' => 'กรุณาระบุชื่อสถานะบิล',
                'name-unique' => 'กรุณาตรวจสอบชื่อสถานะบิล',
                'added-bill-st' => 'เพิ่มสถานะบิลใหม่สำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'name-string' => 'Please enter the name of the bill status.',
                'name-unique' => 'Please check bill status name.',
                'added-bill-st' => 'Successfully added a new bill status.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'name-string' => 'ກະລຸນາລະບຸຊື່ຂອງສະຖານະໃບເກັບເງິນ.',
                'name-unique' => 'ກະລຸນາກວດເບິ່ງຊື່ຂອງສະຖານະໃບເກັບເງິນ.',
                'added-bill-st' => 'ເພີ່ມສະຖານະໃບເກັບເງິນໃໝ່ສຳເລັດແລ້ວ.',
            ];
        }

        $data = Bill_st::create([
            'keyword' => $request->keyword,
            'thai' => $request->thai,
            'lao' => $request->lao,
            'eng' => $request->eng,
            'create by' => auth()->user()->username,
            'create at' => Carbon::now()->format('d-m-Y H:i:s'),
        ]);
        if($data){
            return redirect()->route('billstatus')->with('success', $valid_mes['added-bill-st']);
        }else{
            return redirect()->route('billstatus')->with('error', "ERROR");
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bill_st  $bill_st
     * @return \Illuminate\Http\Response
     */
    public function show(Bill_st $bill_st)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bill_st  $bill_st
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $bill_st =  Bill_st::find($id);
        if($bill_st){
            return view('setting.bill_st_manage.editbill_st',compact('bill_st'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bill_st  $bill_st
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if(session()->get('locale') == 'th'){
            $this->valid_mes = [
                'name-string' => 'กรุณาตรวจสอบชื่อสถานะบิล',
                'success-mes' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $this->valid_mes = [
                'name-string' => 'Please check bill status name.',
                'success-mes' => 'Save data successfully.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $this->valid_mes = [
                'name-string' => 'ກະລຸນາກວດສອບຊື່ສະຖານະລົດ.',
                'success-mes' => 'ບັນທຶກຂໍ້ມູນສຳເລັດແລ້ວ.',
            ];
        }

        $bill_st =  Bill_st::find($id);
        $bill_st->keyword = $request->keyword;
        $bill_st->thai = $request->thai;
        $bill_st->lao = $request->lao;
        $bill_st->eng = $request->eng;
        $bill_st->save();
        return redirect()->route('editbill-st', ['id' => $id])->with('success', $this->valid_mes['success-mes']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bill_st  $bill_st
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

        $cus_st =  Bill_st::find($id);
        
        $cus_st->delete();
        return redirect()->route('billstatus')->with('success', $this->valid_mes['deleted']);
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
            return redirect()->route('billstatus');
        }
        
        $bill_sts =  Bill_st::where('keyword', 'LIKE', '%'.$searchTerm.'%')
                        ->orwhere('thai', 'LIKE', '%'.$searchTerm.'%')
                        ->orwhere('lao', 'LIKE', '%'.$searchTerm.'%')
                        ->orwhere('eng', 'LIKE', '%'.$searchTerm.'%')
                        ->select('*')
                        ->paginate(10);

        if($bill_sts->isNotEmpty()){
            return view('setting.bill_st_manage.index',compact('bill_sts'));
        }else{
            return redirect()->route('billstatus')->with('notfound', $valid_mes['search-notfound']);
        }    
    }
}
