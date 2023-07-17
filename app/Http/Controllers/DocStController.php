<?php

namespace App\Http\Controllers;

use App\Models\Doc_st;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DocStController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['doc_sts'] = Doc_st::orderBy('id','ASC')->paginate(5);
        return view('setting.doc_st_manage.index',$data);
    }


    public function newform()
    {
        //
        return view('setting.doc_st_manage.newdoc_st');
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
                'name-string' => 'กรุณาระบุชื่อสถานะเอกสาร',
                'name-unique' => 'กรุณาตรวจสอบชื่อสถานะเอกสาร',
                'added-doc-st' => 'เพิ่มสถานะเอกสารใหม่สำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'name-string' => 'Please enter the name of the document status.',
                'name-unique' => 'Please check document status name.',
                'added-doc-st' => 'Successfully added a new document status.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'name-string' => 'ກະລຸນາລະບຸຊື່ຂອງສະຖານະເອກະສານ.',
                'name-unique' => 'ກະລຸນາກວດເບິ່ງຊື່ຂອງສະຖານະເອກະສານ.',
                'added-doc-st' => 'ເພີ່ມສະຖານະເອກະສານໃໝ່ສຳເລັດແລ້ວ.',
            ];
        }
        Doc_st::create([
            'keyword' => $request->keyword,
            'thai' => $request->thai,
            'lao' => $request->lao,
            'eng' => $request->eng,
            'create by' => auth()->user()->username,
            'create at' => Carbon::now()->format('d-m-Y H:i:s'),
        ]);
        return redirect()->route('docstatus')->with('success', $valid_mes['added-doc-st']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Doc_st  $doc_st
     * @return \Illuminate\Http\Response
     */
    public function show(Doc_st $doc_st)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Doc_st  $doc_st
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $doc_st =  Doc_st::find($id);
        if($doc_st){
            return view('setting.doc_st_manage.editdoc_st',compact('doc_st'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Doc_st  $doc_st
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if(session()->get('locale') == 'th'){
            $this->valid_mes = [
                'name-string' => 'กรุณาตรวจสอบชื่อสถานะเอกสาร',
                'success-mes' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $this->valid_mes = [
                'name-string' => 'Please check document status name.',
                'success-mes' => 'Save data successfully.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $this->valid_mes = [
                'name-string' => 'ກະລຸນາກວດສອບຊື່ສະຖານະເອກະສານ.',
                'success-mes' => 'ບັນທຶກຂໍ້ມູນສຳເລັດແລ້ວ.',
            ];
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ],
        [
            'name.requred' => $this->valid_mes['name-string'],
        ]);
        $doc_st =  Doc_st::find($id);
        $doc_st->keyword = $request->keyword;
        $doc_st->thai = $request->thai;
        $doc_st->lao = $request->lao;
        $doc_st->eng = $request->eng;
        $doc_st->save();
        return redirect()->route('editdoc-st', ['id' => $id])->with('success', $this->valid_mes['success-mes']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Doc_st  $doc_st
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

        $cus_st =  Doc_st::find($id);
        
        $cus_st->delete();
        return redirect()->route('docstatus')->with('success', $this->valid_mes['deleted']);
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
            return redirect()->route('docstatus');
        }
        
        $doc_sts =  Doc_st::where('keyword', 'LIKE', '%'.$searchTerm.'%')
                        ->orwhere('thai', 'LIKE', '%'.$searchTerm.'%')
                        ->orwhere('lao', 'LIKE', '%'.$searchTerm.'%')
                        ->orwhere('eng', 'LIKE', '%'.$searchTerm.'%')
                        ->select('*')
                        ->paginate(10);

        if($doc_sts->isNotEmpty()){
            return view('setting.doc_st_manage.index',compact('doc_sts'));
        }else{
            return redirect()->route('docstatus')->with('notfound', $valid_mes['search-notfound']);
        }    
    }
}
