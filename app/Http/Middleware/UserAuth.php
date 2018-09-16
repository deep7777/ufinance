<?php

namespace App\Http\Middleware;

use Closure;
use App\Staff;
use App\Admin;

class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      //check if staff user logged in
      if ($request->session()->has('staff')) {
        $staff = $request->session()->get('staff');
        $result = Staff::where('username',$staff->username)
                    ->where('password',$staff->password)
                    ->where('status_id','1')
                    ->first();
        if(!$result){
          return redirect('/');
        }else{
          return $next($request);
        }
      }else if ($request->session()->has('admin')) {
        $admin = $request->session()->get('admin');
        $result = Admin::where('username',$admin->username)
                    ->where('password',$admin->password)
                    ->where('status_id','1')
                    ->first();
        if(!$result){
          return redirect('/');
        }else{
          return $next($request);
        }
      }else{
        return redirect('/');
      }
    }
}
