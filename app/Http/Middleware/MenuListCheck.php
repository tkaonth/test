<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Userlevel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class MenuListCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $menuList = [];
        $user = Auth::user();
        $list = Userlevel::where('keyword',$user->user_level)->pluck('menulist');
        $menuList = explode(",", $list[0]); 
        $routeName = Route::currentRouteName();
        

        if (!in_array($routeName, $menuList)) {
            // ไม่มีข้อความในเมนูที่ตรงกับชื่อเส้นทาง
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
