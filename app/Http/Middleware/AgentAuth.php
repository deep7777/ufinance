<?php

namespace App\Http\Middleware;

use Closure;
use App\Agents;

class AgentAuth
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
      if ($request->session()->has('agent')) {
        $agent = $request->session()->get('agent');
        $result = Agents::where('username',$agent->username)
                    ->where('password',$agent->password)
                    ->where('agent_account_active','1')
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
