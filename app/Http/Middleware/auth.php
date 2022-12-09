<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use DB;

class auth
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
        $id=$request->session()->get('id');
        if($id=='') {
            $url=url()->current();
            $request->session()->put('next', $url);
            return redirect('login');
        }
            
        $type=$request->session()->get('type');
        
        $user=DB::select("SELECT * FROM contacts WHERE id='$id' LIMIT 1");
        $user=collect($user)->first();
        view()->share(['id'=>$id, 'type'=>$type, 'user'=>$user]);
        
        return $next($request);
    }
}
