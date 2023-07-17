<?php

namespace App\Http\Controllers;

use App\Models\Userlevel;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class UserlevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['userlevels'] = Userlevel::orderBy('id','ASC')->paginate(10);
        return view('setting.userlevel.index',$data);
    }


    public function newform()
    {
        //
        return view('setting.userlevel.newuserlevel');
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
        //dd($request->all());
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'name-string' => 'กรุณาระบุชื่อระดับผู้ใช้',
                'name-unique' => 'กรุณาตรวจสอบชื่อระดับผู้ใช้',
                'selectedmenulist-require' => 'กรุณาเลือกสิทธิ์การใช้งาน',
                'added-userlevel' => 'เพิ่มระดับผู้ใช้ใหม่สำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'name-string' => 'Please specify a user level name.',
                'name-unique' => 'Please check the user level name.',
                'selectedmenulist-require' => 'Please select a license.',
                'added-userlevel' => 'Successfully added a new user level.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'name-string' => 'ກະລຸນາລະບຸຊື່ລະດັບຜູ້ໃຊ້.',
                'name-unique' => 'ກະລຸນາກວດເບິ່ງຊື່ລະດັບຜູ້ໃຊ້.',
                'selectedmenulist-require' => 'ກະລຸນາເລືອກໃບອະນຸຍາດ.',
                'added-userlevel' => 'ເພີ່ມລະດັບຜູ້ໃຊ້ໃໝ່ສຳເລັດແລ້ວ.',
            ];
        }
        $menulist = implode(',',$request->selectedmenulist);

        $data = Userlevel::create([
            'keyword' => $request->keyword,
            'menulist' => $menulist,
            'thai' => $request->thai,
            'lao' => $request->lao,
            'eng' => $request->eng,
            'create by' => auth()->user()->username,
            'create at' => Carbon::now()->format('d-m-Y H:i:s'),
        ]);
        if($data){
            return redirect()->route('userlevelmanage')->with('success', $valid_mes['added-userlevel']);
        }else{
            return redirect()->route('userlevelmanage')->with('error', "ERROR");
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\userlevel  $userlevel
     * @return \Illuminate\Http\Response
     */
    public function show(Userlevel $userlevel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Userlevel  $userlevel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $userleveldata =  Userlevel::find($id);
        //dd($userlevel);
        $userleveldata->menulist = explode(',', $userleveldata->menulist);;
        if($userleveldata){
            return view('setting.userlevel.edituserlevel',compact('userleveldata'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\userlevel  $userlevel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'name-string' => 'กรุณาระบุชื่อระดับผู้ใช้',
                'name-unique' => 'กรุณาตรวจสอบชื่อระดับผู้ใช้',
                'selectedmenulist-require' => 'กรุณาเลือกสิทธิ์การใช้งาน',
                'added-userlevel' => 'เพิ่มระดับผู้ใช้ใหม่สำเร็จ',
                'success-mes' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'name-string' => 'Please specify a user level name.',
                'name-unique' => 'Please check the user level name.',
                'selectedmenulist-require' => 'Please select a license.',
                'added-userlevel' => 'Successfully added a new user level.',
                'success-mes' => 'Save data successfully.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'name-string' => 'ກະລຸນາລະບຸຊື່ລະດັບຜູ້ໃຊ້.',
                'name-unique' => 'ກະລຸນາກວດເບິ່ງຊື່ລະດັບຜູ້ໃຊ້.',
                'selectedmenulist-require' => 'ກະລຸນາເລືອກໃບອະນຸຍາດ.',
                'added-userlevel' => 'ເພີ່ມລະດັບຜູ້ໃຊ້ໃໝ່ສຳເລັດແລ້ວ.',
                'success-mes' => 'ບັນທຶກຂໍ້ມູນສໍາເລັດ.',
            ];
        }
        

        $menulist = implode(',',$request->selectedmenulist);
        $userleveldata =  Userlevel::find($id);
        $userleveldata->keyword = $request->keyword;
        $userleveldata->menulist = $menulist;
        $userleveldata->thai = $request->thai;
        $userleveldata->lao = $request->lao;
        $userleveldata->eng = $request->eng;
        $userleveldata->save();
        return redirect()->route('edituserlevel', ['id' => $id])->with('success', $valid_mes['success-mes']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\userlevel  $userlevel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'deleted' => 'ลบข้อมูลเรียบร้อยแล้ว',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'deleted' => 'Data has been deleted.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'deleted' => 'ຂໍ້ມູນຖືກລຶບແລ້ວ.',
            ];
        }

        $userleveldata =  Userlevel::find($id);
        
        $userleveldata->delete();
        return redirect()->route('userlevelmanage')->with('success', $valid_mes['deleted']);
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
            return redirect()->route('userlevelmanage');
        }
        
        $userlevels =  Userlevel::where('keyword', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere('menulist', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere('thai', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere('lao', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere('eng', 'LIKE', '%'.$searchTerm.'%')
                        ->select('*')
                        ->paginate(10);

        if($userlevels->isNotEmpty()){
            return view('setting.userlevel.index',compact('userlevels'));
        }else{
            return redirect()->route('userlevelmanage')->with('notfound', $valid_mes['search-notfound']);
        }    
    }
}
