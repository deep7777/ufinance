<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Requests;
use App\Staff;
class StaffAuth
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
      if ($request->session()->has('staff')) {
        $staff = $request->session()->get('staff');
        $result = Staff::where('username',$staff->username)
                    ->where('password',$staff->password)
                    ->where('status_id','1')
                    ->first();
        if(!$result){
          return redirect('/');
        }
      }else{
        return redirect('/');
      }
      return $next($request);
    }
}
