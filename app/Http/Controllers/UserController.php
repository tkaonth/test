<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Userlevel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Http\Request;
use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    //
        
    

    public function index(){
        $data['users'] = User::orderBy('id','ASC')->paginate(10);
        return view('usermanage.showallusers',$data);
    }

    public function create(){
        $data['user_levels'] = Userlevel::query()->get();
        return view('usermanage.newuser',$data);
    }

    public function store(Request $request){
        if(session()->get('locale') == 'th'){
            $this->valid_mes = [
                'name-string' => 'กรุณาตรวจสอบ ชื่อ-นามสกุลอีกครั้ง',
                'username-string' => 'กรุณาตรวจสอบชื่อผู้ใช้งานอีกครั้ง',
                'username-unique' => 'ชื่อผู้ใช้งานนี้มีในระบบแล้ว',
                'password-confirmed' => 'รหัสผ่านไม่ตรงกัน',
                'success-mes' => 'บันทึกข้อมูลสำเร็จ',
                'search-notfound' => 'ไม่พบข้อมูลที่กำลังค้นหา',
                'deleted' => 'ลบข้อมูลเรียบร้อยแล้ว',
            ];
        }else if(session()->get('locale') == 'en'){
            $this->valid_mes = [
                'name-string' => 'Please check your first and last name again.',
                'username-string' => 'Please check your username again.',
                'username-unique' => 'This username is already in the system.',
                'password-confirmed' => 'passwords do not match',
                'success-mes' => 'Save data successfully.',
                'search-notfound' => 'The information you are looking for is not found.',
                'deleted' => 'Data has been deleted.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $this->valid_mes = [
                'name-string' => 'ກະລຸນາກວດເບິ່ງຊື່ ແລະນາມສະກຸນຂອງເຈົ້າອີກຄັ້ງ.',
                'username-string' => 'ກະລຸນາກວດເບິ່ງຊື່ຜູ້ໃຊ້ຂອງທ່ານອີກຄັ້ງ.',
                'username-unique' => 'ຊື່ຜູ້ໃຊ້ນີ້ມີຢູ່ໃນລະບົບແລ້ວ.',
                'password-confirmed' => 'ລະຫັດຜ່ານບໍ່ກົງກັນ',
                'success-mes' => 'ບັນທຶກຂໍ້ມູນສໍາເລັດ.',
                'search-notfound' => 'ຂໍ້ມູນທີ່ທ່ານກໍາລັງຊອກຫາແມ່ນບໍ່ພົບ.',
                'deleted' => 'ຂໍ້ມູນຖືກລຶບແລ້ວ.',
            ];
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
            'user_level' => ['required', 'string', 'max:255'],
        ],
        [
            'name.requred' => $this->valid_mes['name-string'],
            'username.unique' => $this->valid_mes['username-unique'],  
            'password.confirmed' => $this->valid_mes['password-confirmed'],  
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'user_level' => $request->user_level,
        ]);
        
        return redirect()->route('newuserform')->with('success', $this->valid_mes['success-mes']);
    }

    public function update(Request $request,$id){
        if(session()->get('locale') == 'th'){
            $this->valid_mes = [
                'name-string' => 'กรุณาตรวจสอบ ชื่อ-นามสกุลอีกครั้ง',
                'username-string' => 'กรุณาตรวจสอบชื่อผู้ใช้งานอีกครั้ง',
                'username-unique' => 'ชื่อผู้ใช้งานนี้มีในระบบแล้ว',
                'password-confirmed' => 'รหัสผ่านไม่ตรงกัน',
                'success-mes' => 'บันทึกข้อมูลสำเร็จ',
                'search-notfound' => 'ไม่พบข้อมูลที่กำลังค้นหา',
                'deleted' => 'ลบข้อมูลเรียบร้อยแล้ว',
            ];
        }else if(session()->get('locale') == 'en'){
            $this->valid_mes = [
                'name-string' => 'Please check your first and last name again.',
                'username-string' => 'Please check your username again.',
                'username-unique' => 'This username is already in the system.',
                'password-confirmed' => 'passwords do not match',
                'success-mes' => 'Save data successfully.',
                'search-notfound' => 'The information you are looking for is not found.',
                'deleted' => 'Data has been deleted.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $this->valid_mes = [
                'name-string' => 'ກະລຸນາກວດເບິ່ງຊື່ ແລະນາມສະກຸນຂອງເຈົ້າອີກຄັ້ງ.',
                'username-string' => 'ກະລຸນາກວດເບິ່ງຊື່ຜູ້ໃຊ້ຂອງທ່ານອີກຄັ້ງ.',
                'username-unique' => 'ຊື່ຜູ້ໃຊ້ນີ້ມີຢູ່ໃນລະບົບແລ້ວ.',
                'password-confirmed' => 'ລະຫັດຜ່ານບໍ່ກົງກັນ',
                'success-mes' => 'ບັນທຶກຂໍ້ມູນສໍາເລັດ.',
                'search-notfound' => 'ຂໍ້ມູນທີ່ທ່ານກໍາລັງຊອກຫາແມ່ນບໍ່ພົບ.',
                'deleted' => 'ຂໍ້ມູນຖືກລຶບແລ້ວ.',
            ];
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'confirmed'],
            'user_level' => ['required', 'string', 'max:255'],
        ],
        [
            'name.requred' => $this->valid_mes['name-string'],
            'username.unique' => $this->valid_mes['username-unique'],  
            'password.confirmed' => $this->valid_mes['password-confirmed'],  
        ]);
        $userdata =  User::find($id);
        $userdata->name = $request->name;
        $userdata->username = $request->username;
        if($request->password){
            $userdata->password = Hash::make($request->password);
        }else{
            $userdata->password = $userdata->password;
        }
        
        $userdata->user_level = $request->user_level;
        
        $userdata->save();
        return redirect()->route('edituserform', ['id' => $id])->with('success', $this->valid_mes['success-mes']);
    }

    public function editform($id){
        $userdata =  User::find($id);
        $user_levels = Userlevel::query()->get();
        if($userdata){
            return view('usermanage.edituser',compact('userdata','user_levels'));
        }
        
    }

    public function delete($id){
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

        $userdata =  User::find($id);
        
        $userdata->delete();
        return redirect()->route('usermanage')->with('success', $this->valid_mes['deleted']);
    }

    public function searchuser(Request $request){
        if(session()->get('locale') == 'th'){
            $this->valid_mes = [
                'search-notfound' => 'ไม่พบข้อมูลที่กำลังค้นหา',
            ];
        }else if(session()->get('locale') == 'en'){
            $this->valid_mes = [
                'search-notfound' => 'The information you are looking for is not found.',
            ];
        }else if(session()->get('locale') == 'lo'){
            $this->valid_mes = [
                'search-notfound' => 'ຂໍ້ມູນທີ່ທ່ານກໍາລັງຊອກຫາແມ່ນບໍ່ພົບ.',
            ];
        }
        if($request->searchTerm !=""){
            $searchTerm= $request->searchTerm;
        }else{
            return redirect()->route('usermanage');
        }
        
        $users =  User::where('name', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere('username', 'LIKE', '%'.$searchTerm.'%')
                        ->orWhere('user_level', 'LIKE', '%'.$searchTerm.'%')
                        ->select('*')
                        ->paginate(10);

        if($users->isNotEmpty()){
            return view('usermanage.showallusers',compact('users'));
        }else{
            return redirect()->route('usermanage')->with('notfound', $this->valid_mes['search-notfound']);
        }    
    }
}
