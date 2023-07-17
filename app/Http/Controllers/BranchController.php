<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Support\Carbon;

class BranchController extends Controller
{
    //
    public function index(){
        $data['branches'] = Branch::orderBy('id','ASC')->paginate(10);
        return view('branchmanage.showallbranch',$data);
    }

    public function create(){
        return view('branchmanage.newbranch');
    }

    public function store(Request $request){
        //dd($request->all());
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'name-string' => 'กรุณาระบุชื่อสาขา',
                'name-unique' => 'กรุณาตรวจสอบชื่อสาขา',
                'selectedzone-require' => 'กรุณาเลือกเขตรับผิดชอบ',
                'added-branch' => 'เพิ่มสาขาใหม่สำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'name-string' => 'Please specify branch name.',
                'name-unique' => 'Please check the branch name.',
                'selectedzone-require' => 'Please Select The Area Of Responsibility.',
                'added-branch' => 'Successfully added a new branch.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'name-string' => 'ກະລຸນາລະບຸຊື່ສາຂາ.',
                'name-unique' => 'ກະລຸນາກວດເບິ່ງຊື່ສາຂາ.',
                'selectedzone-require' => 'ກະລຸນາເລືອກພື້ນທີ່ຮັບຜິດຊອບ.',
                'added-branch' => 'ເພີ່ມສາຂາໃໝ່ສຳເລັດແລ້ວ.',
            ];
        }

        
        $zone = implode(',',$request->selectedzone);
        Branch::create([
            'keyword' => $request->keyword,
            'thai' => $request->thai,
            'lao' => $request->lao,
            'eng' => $request->eng,
            'zone' => $zone,
            'create by' => auth()->user()->username,
            'create at' => Carbon::now()->format('d-m-Y H:i:s'),
        ]);
        return redirect()->route('branchmanage')->with('success', $valid_mes['added-branch']);
    }

    public function editform($id){
        $branchdata =  Branch::find($id);
        $branchdata->zone = explode(',', $branchdata->zone);
        if($branchdata){
            return view('branchmanage.editbranch',compact('branchdata'));
        }
        
    }

    public function delete($id){
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

        $branchdata =  Branch::find($id);
        
        $branchdata->delete();
        return redirect()->route('branchmanage')->with('success', $valid_mes['deleted']);
    }

    public function searchbranch(Request $request){
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
            return redirect()->route('showallbranch');
        }
        
        $branches =  Branch::where('keyword', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere('thai', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere('lao', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere('eng', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere('zone', 'LIKE', '%'.$searchTerm.'%')
                        ->select('*')
                        ->paginate(10);

        if($branches->isNotEmpty()){
            return view('branchmanage.showallbranch',compact('branches'));
        }else{
            return redirect()->route('branchmanage')->with('notfound', $valid_mes['search-notfound']);
        }    
    }

    public function update(Request $request,$id){
        
        if(session()->get('locale') == 'th'){
            $valid_mes = [
                'name-string' => 'กรุณาระบุชื่อสาขา',
                'name-unique' => 'กรุณาตรวจสอบชื่อสาขา',
                'selectedzone-require' => 'กรุณาเลือกเขตรับผิดชอบ',
                'added-branch' => 'เพิ่มสาขาใหม่สำเร็จ',
                'success-mes' => 'บันทึกข้อมูลสำเร็จ',
            ];
        }else if(session()->get('locale') == 'en'){
            $valid_mes = [
                'name-string' => 'Please specify branch name.',
                'name-unique' => 'Please check the branch name.',
                'selectedzone-require' => 'Please Select The Area Of Responsibility.',
                'added-branch' => 'Successfully added a new branch.',
                'success-mes' => 'Save data successfully.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $valid_mes = [
                'name-string' => 'ກະລຸນາລະບຸຊື່ສາຂາ.',
                'name-unique' => 'ກະລຸນາກວດເບິ່ງຊື່ສາຂາ.',
                'added-branch' => 'ເພີ່ມສາຂາໃໝ່ສຳເລັດແລ້ວ.',
                'selectedzone-require' => 'ກະລຸນາເລືອກພື້ນທີ່ຮັບຜິດຊອບ.',
                'success-mes' => 'ບັນທຶກຂໍ້ມູນສໍາເລັດ.',
                
            ];
        }
        $zone = implode(',',$request->selectedzone);
        $branchdata =  Branch::find($id);
        $branchdata->keyword = $request->keyword;
        $branchdata->thai = $request->thai;
        $branchdata->lao = $request->lao;
        $branchdata->eng = $request->eng;
        $branchdata->zone = $zone;
        $branchdata->save();
        return redirect()->route('editbranchform', ['id' => $id])->with('success', $valid_mes['success-mes']);
    }
}
