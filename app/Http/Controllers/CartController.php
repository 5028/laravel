<?php

namespace App\Http\Controllers;

use App\User;
use function FastRoute\TestFixtures\empty_options_cached;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['']]);
    }
    //POST 购物车展示
    public function buycar_show()
    {
        $arr = DB::select("select shop.id as shop_id,goods_product.attr_name,shop.goods_id,goods_product.price,goods.`name`,shop.newber FROM goods_product JOIN shopping_cart as shop on goods_product.id=shop.goods_id JOIN goods on goods.id = goods_product.goods_id");
        $js=['code'=>'200','status'=>'success','data'=>$arr];
        return response()->json(['data' => $js]);
    }
    public function goods(Request $request)
    {
        $id=$request->input('id');
        $arr = DB::select("select gp.id,gp.goods_attr_id as gp_gaid,gp.price,gp.sn_number,goods.id as g_id, goods.`name` from goods_product as gp JOIN goods on gp.goods_id = goods.id WHERE gp.goods_id=$id");

        $show=DB::select("select * from goods_product where goods_id=$id");
        for ($i=0; $i <count($show) ; $i++) {
            $abb='';
            $arr1=$show[$i]->goods_attr_id;
            $new_attr=explode('-', $arr1);
            for ($j=0; $j <count($new_attr) ; $j++) {
                $new_de=DB::select("select * from attr_details where id='$new_attr[$j]'");
                $abb=$abb.' '.$new_de[0]->name;
            }
            $show[$i]->key=$abb;
        }
        $js=['code'=>'200','status'=>'success','data'=>$arr,'data1'=>$show];
        echo json_encode($js);
    }
    //post 从详情页添加到购物车
    public function add(Request $request)
    {
        $use=auth()->user();
        $u_id=$use->id;
        $g_id=$request->get('g_id');
        $s_id=$request->get('s_id');
        $arr = DB::select("select * from shopping_cart where user_id=$u_id and goods_id=$s_id");
        if (empty($arr)){
            DB::insert("insert into shopping_cart (`user_id`,`goods_id`,`newber`)  values ( '$u_id', '$s_id','$g_id')");
            $js=['code'=>'200','status'=>'success','data'=>"添加一条新数据"];
        }else{
            $arr1 = DB::select("select newber from shopping_cart where user_id=$u_id and goods_id=$s_id");
            $arr2 = $arr1[0]->newber+$g_id;
            //$new=$arr1[0]['newber']+$g_id;
            DB::update("update shopping_cart set newber=$arr2 where user_id=$u_id and goods_id=$s_id");
            $js=['code'=>'200','status'=>'success','data'=>"修改一条数据"];
        }
        return response()->json([
            'data' => $js,
        ]);
    }
    function Update(Request $request){
        $id=$request->get('arr');
        $id1=$request->get('arr1');
        if ($id1 <=0){
            $id1=1;
            DB::update("update shopping_cart set newber=$id1 where id=$id ");
            $js=['code'=>'200','status'=>'success','data'=>"数量最小为1",'id'=>$id];
        }else{
            DB::update("update shopping_cart set newber=$id1 where id=$id ");
            $js=['code'=>'200','status'=>'success','data'=>"数量已经更新",'id'=>$id];
        }
        return response()->json([
            'data' => $js,
        ]);
    }
    //复选框方法
    function province(){
        $new_de=DB::select("select * from area where area_type='1'");
        $js=['code'=>'200','status'=>'success','data'=>$new_de];
        return response()->json(['data' => $js,]);
    }

    //个人中心-地址添加
    function area_show(Request $request){
        $id=$request->post('area_id');
        $new_de=DB::select("select * from area where parent_id=$id");
        $js=['code'=>'200','status'=>'success','data'=>$new_de];
        return response()->json(['data' => $js,]);
    }
    function addarea(Request $request){
        $use=auth()->user();
        $u_id=$use->id;
        $province=$request->post('province');
        $city=$request->post('city');
        $area=$request->post('area');
        $name=$request->post('name');
        $phone=$request->post('phone');
        $address=$request->post('address');
        $postal_code=$request->post('postal_code');
        //是否是默认地址 是1 否0
        $default=0;
        //查询出 省 市 县
        $arrrr=$province.'-'.$city.'-'.$area;
        DB::insert("insert into address (`u_id`,`address`,`name`,`phone`,`Postal_Code`,`de_address`,`default`)  values ( '$u_id', '$arrrr','$name','$phone','$postal_code','$address','$default')");
        $js=['code'=>'200','status'=>'success','data'=>'添加成功'];
        return response()->json(['data' => $js,]);
    }
    function address_show(){
        //$new_de=DB::select("select * from address");

            $show=DB::select("select * from address");
            for ($i=0; $i <count($show) ; $i++) {
                $abb='';
                $arr1=$show[$i]->address;
                $new_attr=explode('-', $arr1);
                for ($j=0; $j <count($new_attr) ; $j++) {
                    $new_de=DB::select("select * from area where area_id='$new_attr[$j]'");
                    $abb=$abb.' '.$new_de[0]->area_name;
                }
                $show[$i]->key=$abb;
            }
        return response()->json(['data' =>$show,]);
    }

    //订单two
    function buycar_two(Request $request){
        $id=$request->post('id');
        $new_attr = explode('-',  substr($id,'1'));
        $arr1=[];
        foreach ($new_attr as $key=>$value){
            $arr=DB::select("select * from goods_product join goods on goods_product.goods_id=goods.id join shopping_cart on shopping_cart.goods_id=goods_product.id where goods_product.id='$value'");
            $arr1['key'][]=$arr;
        }
        return response()->json(['data' =>$arr1,]);
    }
    function buycar_two1(){
        $show=DB::select("select * from address where default_area='1'");
        for ($i=0; $i <count($show) ; $i++) {
            $abb='';
            $arr1=$show[$i]->address;
            $new_attr=explode('-', $arr1);
            for ($j=0; $j <count($new_attr) ; $j++) {
                $new_de=DB::select("select * from area where area_id='$new_attr[$j]'");
                $abb=$abb.' '.$new_de[0]->area_name;
            }
            $show[$i]->key=$abb;
        }
        return response()->json(['data' =>$show,]);
    }
    function addorder(Request $request){
        $cade=$request->post('cade');//货品
        $address=$request->post('address');//地址
        $totalp=$request->post('totalp');//价格
        $use=auth()->user();
        $u_id=$use->id;
        $time=date("Y-m-d h:i:s");//日期
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        foreach ($address as $key=>$value) {
            $address1=$value['key'];
            $address2=$value['de_address'];
            $name=$value['name'];
            $phone=$value['phone'];
            $address11=$address1.$address2;
            DB::insert("insert into Suborder (`order_id`,`address`,`time`,`u_id`,`stutas`)  values ( '$orderSn','$address11','$time','$u_id','0');");
        }
        foreach ($cade as $key=>$value) {
            $name1=$value[0]['name'];
            $attr_name=$value[0]['attr_name'];
            $price=$value[0]['price'];
            $newber=$value[0]['newber'];
            $id=$value[0]['goods_id'];
            DB::insert("insert into order1 (`h_goods`,`h_type`,`price`,`num`,`h_id`,`suborder_id`)  values ( '$name1','$attr_name','$price','$newber','$id','$orderSn');");
        }
       return response()->json(['data' =>$orderSn,'price' =>$totalp,]);
    }

}