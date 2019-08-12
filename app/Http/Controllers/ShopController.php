<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['shop','floor','floorshow','goods','price']]);
    }
  //商品展示index页面
    public function shop()
    {
        $arr = DB::select('select * from goods_category');
        $ayy=$this->cate_gory($arr,0,0);
        $js=['code'=>'200','status'=>'success','data'=>$ayy];
        echo json_encode($js);
    }
    function cate_gory($arr,$id,$level){
        $list =array();
        foreach ($arr as $k=>$v){
            if ($v->pid == $id){
                $v->level =$level;
                $v->son = $this->cate_gory($arr,$v->id,$level+1);
                $list[] = $v;
            }
        }
        return $list;
    }
    //POST
    public function floor()
    {
        $arr = DB::select('select fs.id,floor.`name`,goods.`name` as fs_show,floor.id as f_id,goods.id as fs_id from fs JOIN floor ON fs.f_id=floor.id JOIN goods ON fs.fs_id=goods.id');
        $js=['code'=>'200','status'=>'success','data'=>$arr];
        echo json_encode($js);
    }
    //POST
    public function floorshow()
    {
        $arr = DB::select('select * from floor');
        $js=['code'=>'200','status'=>'success','data'=>$arr];
        echo json_encode($js);
    }
    //GET 属性拆分 - 及货品信息
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
    //GET 点击查询价格
    public function price(Request $request)
    {
        $id=$request->input('price_id');
        $arr = DB::select("select * from goods_product where id=$id");
        $js=['code'=>'200','status'=>'success','data'=>$arr];
        echo json_encode($js);
    }


}