<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Login;
use App\Goods;
use App\Cart;
//引入 Redis
use Illuminate\Support\Facades\Redis;
class LoginController extends Controller
{
     public function __construct()
    {
        app('debugbar')->disable();     //关闭调试
    }
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *展示登录
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.loginlist");
    }

    /**
     * Store a newly created resource in storage.
     *执行登录
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = $request->all();
      $Login = Login::where("uname")->count();

    }

    /**
     * Display the specified resource.
     *展示注册
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view("admin.loginreg");
    }

    /**
     * Show the form for editing the specified resource.
     *执行注册
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
      //$request = $request->all();
      // $upwd = request()->upwd;
      //dump($uname);
        $Login = new Login;
        $Login->uname = request()->uname;
        $Login->upwd = request()->upwd;
        $Login->upd = request()->upd;
       
        if(!$Login["uname"]){
             return redirect("reg")->with("msge","用户名必填");
        }   
        if(!$Login["upwd"]){
             return redirect("reg")->with("msg","密码必填");
        }   
        if(!$Login["upd"]){
             return redirect("reg")->with("msgs","职位必填");
        }  
         $Login["upwd"] = encrypt($Login['upwd']);
        //验证账号是否存在唯一性验证
            // $uname = request()->uname;
             // if($Login["uname"]==$uname){
             //     return redirect("reg")->with("msgs","名称已存在");
             // }
   
        $res = $Login->save();
        return redirect("/");
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    // public function userinfo(){
    //     $goods = [
    //         "name"=>"张三",
    //         "pwd" =>123456,
    //         "price" =>12321,
    //         ];
    //         echo json_encode(["data"=>$goods]);
    // }
    public function login(){
        $code = request()->code;
        // echo $code;
        $userinfo = request()->userInfo;
        $userinfos = json_decode($userinfo,true);
        // dd($userinfo);
        // $openid = "o1DRs6WeoAZR19_br4mZZa6BPJm0";
        // $session_key = "7NqcSFWazrkqWQH+xsp//g==";
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=wx6f8656bcb78675c0&secret=6078635c1bdad895e23ad8d295677baf&js_code=$code&grant_type=authorization_code";
        $data = file_get_contents($url);
        $data = json_decode($data,true);
        // dd($data);
        $openid = $data["openid"];
        //自定义登录态
        $token = sha1($openid.$data["session_key"].mt_rand(0,999999));
        //存哈希
        $userinfo = [
                "user_id" => 123,
                "user_name" =>"张三",
                "login_time" =>time(),
                "login_ip" =>request()->getClientIp(),
                "access_token" => $token,
            ];
        $key = "h:xcx:token";
        $hass = Redis::hMset($key,$userinfo);
        $times = Redis::expire($hass,7200);
        $opens = Login::where("openid",$openid)->first();
        if(empty($opens)){
        $data = [
                "avatarUrl" =>$userinfos["avatarUrl"],
                "city"=>$userinfos["city"],
                "country" =>$userinfos["country"],
                "gender" =>$userinfos["gender"],
                "language"=>$userinfos["language"],
                "nickName"=>$userinfos["nickName"],
                "province"=>$userinfos["province"],
                "openid" =>$openid
                ];
        Login::insert($data); 
        }
            echo  json_encode(["code"=>0000,"msg"=>"登录成功","token"=>$token,"openid"=>$openid]);
    }
    public function actionWxLogin(){
        $user = request()->userInfo;
        $token = request()->token;
        $openid = request()->openid;
        $opens = Login::where("openid",$openid)->first();
        // dd($opens);
        if(empty($opens)){
            $user = json_decode($user,true);
        $data = [
                "avatarUrl"=>$user["avatarUrl"],
                "city"=>$user["city"],
                "nickName"=>$user["nickName"],
                "gender"=>$user["gender"],
                "province"=>$user["province"],
                "country"=>$user["country"],
                "openid"=>$openid
                
                ];
          // print_r($data);die;      
        Login::insert($data); 
        }else{
              echo "欢迎回来";
        }
       $xcx_token =  Redis::get("xcx_token");
       if($token == $xcx_token){
            echo "";
       }else{
            echo json_encode(["code"=>3333,"msg"=>"请重新登录"]);
       }
    }
    //查询首页商品数据
    public function goods(){
        $size = request()->size;
        $goods = Goods::select("goods_id","goods_name","goods_img","shop_price")->paginate($size);
        // $repose = [
        //     "errmsg" => "ok",
        //     "code"  =>"0",
        //     "data" =>[
        //         "list"=>$goods->items()
        //         ]


        //     ];
        echo json_encode(["code"=>"0000","msg"=>"success","data"=>$goods->items()]);
        // return $repose;

    }
    //详情
    public function detail(){
        $goods_id = request()->goods_id;
        $token = request()->token;
        
        $data = Goods::where("goods_id",$goods_id)->first();
        // dd($data);
        $data["goods_imgs"] = explode("|",$data["goods_imgs"]);
        //取哈希的token
         $xcx_token =  Redis::hget("h:xcx:token","access_token");
         if($token!=$xcx_token){
            return json_encode(["msg"=>"请重新登录","code"=>"1111"]);
         }else{
            return $data;
         }
    }
    //购物车
    public function cart(){
        $goods = request()->all();
        // if(){

        // }
        $uid = $_SERVER["uid"];
        $where = [
                ["goods_id",$goods["goods_id"]],
                ["uid",$uid],
            ];
         $cart = Cart::where($where)->first();
        if($cart){
            Cart::where($where)->update(["goods_num"=>$goods["goods_num"]+$cart["goods_num"]-1]);
        }else{
            $goods_id = $goods["goods_id"];
            $cart = Goods::where("goods_id",$goods_id)->first();
            $data = [
                "goods_id" => $goods_id,
                "uid" => $uid,
                "goods_num" =>$goods["goods_num"],
                "add_time" => time(),
                "goods_name" =>$cart->goods_name,
                "goods_img" =>$cart->goods_img,
                "shop_price" =>$cart->shop_price
            ];
            Cart::insert($data);
        }
         $cart_list = Cart::where("uid",$uid)->get();
        return  $cart_list;
    }
    //加减号
    public function carts(){
        $goods =request()->all();
        Cart::where("goods_id",$goods["goods_id"])->update(["goods_num"=>$goods["goods_num"]]);

    }
    //收藏
    public function coll(){
        $uid = $_SERVER["uid"];
        $token = request()->token;
        // echo $uid;
        $goods_id = request()->goods_id;
        // echo $goods_id;
        $key = "xcx_coll_".$goods_id."________".$uid;
        $dif  = Redis::zcard($key);
        if($dif==1){
            return json_encode(["code"=>"0000","msg"=>"该商品已经收藏"]);
        }else{
         //取哈希的token
         $xcx_token =  Redis::hget("h:xcx:token","access_token");
         if($token!=$xcx_token){
            return json_encode(["msg"=>"请重新登录","code"=>"1111"]);
         }else{
            $goods= Goods::where("goods_id",$goods_id)->get();
            $goods = json_encode($goods);
            if($uid){
                $key = "xcx_coll_".$goods_id."________".$uid;
                Redis::ZAdd($key,$goods);
            }
            return json_encode(["code"=>"00000","msg"=>"收藏成功"]);
         }
      }
    }

    // vue接口测试调用
    public function vue_g_list(){
        $goods = Goods::limit(10)->get();
        return json_encode(["code"=>"000","msg"=>"success","data"=>$goods]);
    }
    public function ee(){
        //  // $goods_id = request()->goods_id;
        //  $goods_id = "217,218,220";
        //  // $goods_id = request()->goods_id;
        //  // $uid = $_SERVER["uid"];
        //  $uid = 123;
        //  $goods_id = explode(",",$goods_id);
        // // $goods_id = substr($goods_id,0,strpos($goods_id,","));
        // //  $order = [];
        // // foreach ($goods_id as $key => $value) {
        // //     $where = [
        // //         ["goods_id","=",$value],
        // //         ["uid","=",$uid]
        // //         ];
        // // }
        // $order = Cart::whereIn("goods_id",$goods_id)->get();
        // dd($order);
        // return json_encode(["code"=>"9999","msg"=>"success","data"=>$order]);

    }
    //订单
    public function order(){
            $goods_id = request()->goods_id;
            $uid = $_SERVER["uid"];
            $goods_id = explode(",",$goods_id);
            $order = Cart::whereIn("goods_id",$goods_id)->get();
          return json_encode(["code"=>"9999","msg"=>"success","data"=>$order]);
    }
    //总数
    public function zongshu(){
      $uid = $_SERVER["uid"];  
      // $uid = 123;
      $where = [
        "is_delete",=>0,
        "uid"=>$uid
        ];
      $count = Cart::where($where)->get();
      return json_encode(["code"=>"111111","msg"=>"success","data"=>$count]);
    }


}