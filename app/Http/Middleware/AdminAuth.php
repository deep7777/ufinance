<?php

namespace App\Http\Middleware;

use Closure;
use App\Admin;

class AdminAuth
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
      if ($request->session()->has('admin')) {
        $admin = $request->session()->get('admin');
        $result = Admin::where('username',$admin->username)
                    ->where('password',$admin->password)
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
