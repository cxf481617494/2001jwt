<?php

namespace App\Http\Middleware;

use Closure;
//引入 Redis
use Illuminate\Support\Facades\Redis;
class CheckLogin
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
        $key = "h:xcx:token";
        //取出哈希中的值
        $data = Redis::hgetAll($key);
        $_SERVER["uid"] = $data["user_id"];
        return $next($request);
    }
}
