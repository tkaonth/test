<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;

class LangController extends Controller
{
    //create function change lang
    public function change(Request $request)
    {
        App::setLocale($request->locale);
        session()->put('locale', $request->locale);  
        return back()->withInput();
    }
}
