<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
  
    public function shopping()
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
    public function floor()
    {
        $arr = DB::select('select fs.id,floor.`name`,floor_show.`name` as fs_show,floor.id as f_id,floor_show.id as fs_id from fs JOIN floor ON fs.f_id=floor.id JOIN floor_show ON fs.fs_id=floor_show.id');
        $js=['code'=>'200','status'=>'success','data'=>$arr];
        echo json_encode($js);
    }
    public function floorshow()
    {
        $arr = DB::select('select * from floor');
        $js=['code'=>'200','status'=>'success','data'=>$arr];
        echo json_encode($js);
    }

}