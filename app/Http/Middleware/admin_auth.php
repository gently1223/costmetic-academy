<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class admin_auth
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
        $id=$request->session()->get('admin_id');
        if($id=='') return redirect('admin/login');
        $type=$request->session()->get('admin_type');
        
        $admin=DB::select("SELECT * FROM users WHERE id='$id' LIMIT 1");
        $admin=collect($admin)->first();
        
        setlocale(LC_MONETARY,"de_DE");
        
        view()->share(['admin_id'=>$id, 'admin_type'=>$type, 'admin'=>$admin]);
        
        return $next($request);
    }
}
