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
        $arr = DB::select("select goods_product.attr_name,shop.goods_id,goods_product.price,goods.`name`,shop.newber FROM goods_product JOIN shopping_cart as shop on goods_product.id=shop.goods_id JOIN goods on goods.id = goods_product.goods_id");
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

}