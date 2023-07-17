<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\UserlevelController;
use App\Http\Controllers\CusStController;
use App\Http\Controllers\CarStController;
use App\Http\Controllers\BillStController;
use App\Http\Controllers\DocStController;
use App\Http\Controllers\CarManageController;
use App\Http\Controllers\CusManageController;
use App\Http\Controllers\BillsystemController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });
    Route::get('/dashboard', function () {
     return view('dashboard');
    })->name('dashboard');
    Route::get('/logout',[LoginController::class,'logout'])->name('logout');
    Route::get('/usermanage',[UserController::class,'index'])->name('usermanage');
    Route::get('/newuser', [UserController::class, 'create'])->name('newuserform');
    Route::post('/addnewuser', [UserController::class, 'store'])->name('addnewuser');
    Route::get('/edituserform/{id}', [UserController::class, 'editform'])->name('edituserform');
    Route::put('/updateuser/{id}', [UserController::class, 'update'])->name('updateuser');
    Route::delete('/deleteuser/{id}', [UserController::class, 'delete'])->name('deleteuser');
    Route::post('/searchuser', [UserController::class, 'searchuser'])->name('searchuser');
    
    Route::get('/branchmanage', [BranchController::class, 'index'])->name('branchmanage');
    Route::get('/newbranch', [BranchController::class, 'create'])->name('newbranchform');
    Route::post('/searchbranch', [BranchController::class, 'searchbranch'])->name('searchbranch');
    Route::post('/addnewbranch', [BranchController::class, 'store'])->name('addnewbranch');
    Route::get('/editbranchform/{id}', [BranchController::class, 'editform'])->name('editbranchform');
    Route::put('/updatebranch/{id}', [BranchController::class, 'update'])->name('updatebranch');
    Route::delete('/deletebranch/{id}', [BranchController::class, 'delete'])->name('deletebranch');

    Route::get('/userlevel', [UserlevelController::class, 'index'])->name('userlevelmanage');
    Route::get('/newuserlevel', [UserlevelController::class, 'newform'])->name('newuserlevel');
    Route::post('/searchuserlevel', [UserlevelController::class, 'search'])->name('searchuserlevel');
    Route::post('/addnewuserlevel', [UserlevelController::class, 'store'])->name('addnewuserlevel');
    Route::get('/edituserlevel/{id}', [UserlevelController::class, 'edit'])->name('edituserlevel');
    Route::put('/updateuserlevel/{id}', [UserlevelController::class, 'update'])->name('updateuserlevel');
    Route::delete('/deleteuserlevel/{id}', [UserlevelController::class, 'destroy'])->name('deleteuserlevel');

    Route::get('/customerstatus', [CusStController::class, 'index'])->name('customerstatus');
    Route::get('/newcus-st', [CusStController::class, 'newform'])->name('newcus-st');
    Route::post('/searchcus-st', [CusStController::class, 'search'])->name('searchcus-st');
    Route::post('/addnewcus-st', [CusStController::class, 'store'])->name('addnewcus-st');
    Route::get('/editcus-st/{id}', [CusStController::class, 'edit'])->name('editcus-st');
    Route::put('/updatecus-st/{id}', [CusStController::class, 'update'])->name('updatecus-st');
    Route::delete('/deletecus-st/{id}', [CusStController::class, 'destroy'])->name('deletecus-st');

    Route::get('/carstatus', [CarStController::class, 'index'])->name('carstatus');
    Route::get('/newcar-st', [CarStController::class, 'newform'])->name('newcar-st');
    Route::post('/searchcar-st', [CarStController::class, 'search'])->name('searchcar-st');
    Route::post('/addnewcar-st', [CarStController::class, 'store'])->name('addnewcar-st');
    Route::get('/editcar-st/{id}', [CarStController::class, 'edit'])->name('editcar-st');
    Route::put('/updatecar-st/{id}', [CarStController::class, 'update'])->name('updatecar-st');
    Route::delete('/deletecar-st/{id}', [CarStController::class, 'destroy'])->name('deletecar-st');

    Route::get('/billstatus', [BillStController::class, 'index'])->name('billstatus');
    Route::get('/newbill-st', [BillStController::class, 'newform'])->name('newbill-st');
    Route::post('/searchbill-st', [BillStController::class, 'search'])->name('searchbill-st');
    Route::post('/addnewbill-st', [BillStController::class, 'store'])->name('addnewbill-st');
    Route::get('/editbill-st/{id}', [BillStController::class, 'edit'])->name('editbill-st');
    Route::put('/updatebill-st/{id}', [BillStController::class, 'update'])->name('updatebill-st');
    Route::delete('/deletebill-st/{id}', [BillStController::class, 'destroy'])->name('deletebill-st');

    Route::get('/docstatus', [DocStController::class, 'index'])->name('docstatus');
    Route::get('/newdoc-st', [DocStController::class, 'newform'])->name('newdoc-st');
    Route::post('/searchdoc-st', [DocStController::class, 'search'])->name('searchdoc-st');
    Route::post('/addnewdoc-st', [DocStController::class, 'store'])->name('addnewdoc-st');
    Route::get('/editdoc-st/{id}', [DocStController::class, 'edit'])->name('editdoc-st');
    Route::put('/updatedoc-st/{id}', [DocStController::class, 'update'])->name('updatedoc-st');
    Route::delete('/deletedoc-st/{id}', [DocStController::class, 'destroy'])->name('deletedoc-st');

    Route::get('/carsmanage', [CarManageController::class, 'index'])->name('carsmanage');
    Route::get('/newcar', [CarManageController::class, 'create'])->name('newcar');
    Route::post('/searchcar', [CarManageController::class, 'searchcar'])->name('searchcar');
    Route::post('/addnewcar', [CarManageController::class, 'store'])->name('addnewcar');
    Route::get('/detailcar/{id}', [CarManageController::class, 'detail'])->name('detailcar');
    Route::get('/editcar/{id}', [CarManageController::class, 'edit'])->name('editcar');
    Route::get('/uploadcarform/{id}', [CarManageController::class, 'uploadform'])->name('uploadform_car');
    Route::post('/uploadcarfile/{id}', [CarManageController::class, 'uploadfile'])->name('uploadfile_car');
    Route::put('/updatecar/{id}', [CarManageController::class, 'update'])->name('updatecar');
    Route::delete('/deletecar/{id}', [CarManageController::class, 'destroy'])->name('deletecar');
    Route::get('/newcarhistory/{id}', [CarManageController::class, 'newhistory'])->name('newcarhistory');
    Route::post('/addcarhistory/{id}', [CarManageController::class, 'addhistory'])->name('addcarhistory');
    Route::get('/detailcarhistory/{id}', [CarManageController::class, 'detailhistory'])->name('detailcarhistory');
    Route::put('/updatecarhistory/{id}', [CarManageController::class, 'updatehistory'])->name('updatecarhistory');
    Route::get('/deletecarhistory/{id}', [CarManageController::class, 'deletecarhistory'])->name('deletecarhistory');
    Route::get('/removecarfile/{id}', [CarManageController::class, 'removefile'])->name('removefile_car');
    Route::get('/getcarfile/uploads/{filepath}/{filename}', [CarManageController::class, 'getcarfile'])->name('getfile_car');
    Route::get('/detailcardata/{id}', [CarManageController::class, 'detaildata'])->name('detailcardata');

    Route::get('/getuploadicon/{filename}', [CarManageController::class, 'getuploadicon'])->name('getuploadicon');


    Route::get('/cusmanage', [CusManageController::class, 'index'])->name('cusmanage');
    Route::get('/newcustomer', [CusManageController::class, 'create'])->name('newcus');
    Route::post('/addnewcus', [CusManageController::class, 'store'])->name('addnewcus');
    Route::get('/cuscard/{id}', [CusManageController::class, 'cuscard'])->name('cuscard');
    Route::get('/editcuscard/{id}', [CusManageController::class, 'edit'])->name('editcuscard');
    Route::get('/printcuscard/{id}', [CusManageController::class, 'printcard'])->name('printcuscard');
    Route::put('/update/{id}', [CusManageController::class, 'update'])->name('updatecuscard');
    Route::get('/uploadcusform/{id}', [CusManageController::class, 'uploadform'])->name('uploadform_cus');
    Route::post('/uploadcusfile/{id}', [CusManageController::class, 'uploadfile'])->name('uploadfile_cus');
    Route::get('/viewcusdoc/{id}', [CusManageController::class, 'viewcusdoc'])->name('viewcusdoc');
    Route::get('/removecusfile/{id}', [CusManageController::class, 'removefile'])->name('removefile_cus');
    Route::get('/getcarfile/uploads/{filepath}/{filename}', [CusManageController::class, 'getcarfile'])->name('getfile_car');
    Route::get('/getuploadicon/{filename}', [CusManageController::class, 'getuploadicon'])->name('getuploadicon');
    Route::post('/searchcus', [CusManageController::class, 'searchcus'])->name('searchcus');
    Route::post('/addinsinsdown', [CusManageController::class, 'store_ins_insdown'])->name('addinsinsdown');
    Route::post('/addinsins', [CusManageController::class, 'store_ins_ins'])->name('addinsins');
    Route::post('/addsubins', [CusManageController::class, 'store_subins'])->name('addsubins');
    Route::post('/discountdown', [CusManageController::class, 'store_discountdown'])->name('discountdown');
    Route::post('/discountins', [CusManageController::class, 'store_discountins'])->name('discountins');
    Route::post('/discountsubins', [CusManageController::class, 'store_discountsubins'])->name('discountsubins');
    Route::get('/subcuscardform/{id}', [CusManageController::class, 'subcuscardform'])->name('subcuscardform');
    Route::post('/addsubcuscard', [CusManageController::class, 'addsubcuscard'])->name('addsubcuscard');
    Route::get('/deletediscount/{id}', [CusManageController::class, 'deletediscount'])->name('deletediscount');
    Route::get('/deleteinsins/{id}', [CusManageController::class, 'deleteinsins'])->name('deleteinsins');
    Route::get('/deleteinsinsdown/{id}', [CusManageController::class, 'deleteinsinsdown'])->name('deleteinsinsdown');
    Route::get('/deletesubdividins/{id}', [CusManageController::class, 'deletesubdividins'])->name('deletesubdividins');
    Route::get('/editcusdata/{id}', [CusManageController::class, 'editcusdata'])->name('editcusdata');
    Route::post('/updatecusdata', [CusManageController::class, 'updatecusdata'])->name('updatecusdata');
    Route::get('/removeadddown/{id}', [CusManageController::class, 'removeadddown'])->name('removeadddown');
    Route::get('/removeguarantor/{id}', [CusManageController::class, 'removeguarantor'])->name('removeguarantor');
    

    Route::get('/billsystem/{id}', [BillsystemController::class, 'index'])->name('billsystem');
    Route::post('/createbill', [BillsystemController::class, 'createbill'])->name('createbill');
    Route::post('/savebill', [BillsystemController::class, 'store'])->name('savebill');
    Route::post('/printbill', [BillsystemController::class, 'printbillform'])->name('printbill');
    Route::post('/uploadform', [BillsystemController::class, 'uploadform'])->name('uploadform');
    Route::post('/uploadfile', [BillsystemController::class, 'uploadfile'])->name('uploadfile');
    Route::post('/getbillfile', [BillsystemController::class, 'getbillfile'])->name('getbillfile');
    Route::get('/removecusbill/{id}', [BillsystemController::class, 'removebill'])->name('removebill');
    Route::get('/otherbill', [BillsystemController::class, 'otherbill'])->name('otherbill');
    Route::get('/createotherbill', [BillsystemController::class, 'createotherbill'])->name('createotherbill');
    Route::get('/getbilldetail/{id}', [BillsystemController::class, 'getbilldetail'])->name('getbilldetail');
    Route::get('/getbilldata/{id}', [BillsystemController::class, 'getbilldata'])->name('getbilldata');
    Route::post('/storeotherbill', [BillsystemController::class, 'storeotherbill'])->name('storeotherbill');
    Route::post('/cancelbill', [BillsystemController::class, 'cancelbill'])->name('cancelbill');
    Route::get('/getdiscountbill', [BillsystemController::class, 'getdiscountbill'])->name('getdiscountbill')->middleware('menu.check');
    Route::post('/getotherbilldetail', [BillsystemController::class, 'getotherbilldetail'])->name('getotherbilldetail');
    Route::post('/updatediscountbill', [BillsystemController::class, 'updatediscountbill'])->name('updatediscountbill');
    Route::get('/discountbilldetail/{id}', [BillsystemController::class, 'discountbilldetail'])->name('discountbilldetail');
    Route::post('/searchdiscount', [BillsystemController::class, 'searchdiscount'])->name('searchdiscount');
    Route::post('/searchotherbill', [BillsystemController::class, 'searchotherbill'])->name('searchotherbill');
    
});
Route::post('/language', [LangController::class, 'change'])->name('language.change');

