<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * 为指定用户显示详情
     *
     * @param int $id
     * @return Response
     * @author LaravelAcademy.org
     */

    //跳到主页展示
    public function show()
    {
        $value = session('user');
        return view('login', ['user' => $value]);
    }
    //跳到login登陆页面
    public function login()
    {
        return view('login.login');
    }
    //登陆页面的判断，如果成功存session
    public function index(Request $request)
    {
        $name = $request->input('name');
        $pass = $request->input('password');
        $user = DB::select("select * from admin where name='$name' and password='$pass'");
        if (empty($name)||empty($pass)) {
           $arr=['code'=>'1','status'=>'error','data'=>"用户名密码不能为空"];
            echo $json=json_encode($arr);
        }else{
            if (empty($user)) {
                $arr=['code'=>'1','status'=>'error','data'=>"用户名密码错误"];
                echo $json=json_encode($arr);
            }else{
                $request->session()->put('user', $name);
                $arr=['code'=>'0','status'=>'OK','data'=>"登陆成功"];
                echo $json=json_encode($arr);
            }
        }   
    }
    public function loginout(Request $request){
        $request->session()->forget('user');
        return redirect()->action('UserController@login');
    }
    public function showaction()
    {
        $users = DB::select('select * from country');
        $arr=['code'=>'0','status'=>'OK','data'=> $users];
        echo $json=json_encode($arr);
    }
    public function delete(Request $request)
    {
        $id = $request->input('id');
        $delete=DB::delete("delete from country where code='$id'");
        $arr=['code'=>'0','status'=>'OK','data'=>"删除成功"];
        echo $json=json_encode($arr);
    }
    public function add(Request $request)
    {
        $name = $request->input('name');
        $population = $request->input('ipone');
        $add=DB::select("select * from country where name='$name'");
        if (empty($add)) {
            DB::insert('insert into country (name,population) values (?, ?)', [$name, $population]);
            $arr=['code'=>'0','status'=>'OK','data'=> "添加成功"];
            echo $json=json_encode($arr);
        }else{
            $arr=['code'=>'1','status'=>'error','data'=> "已经拥有该国家"];
            echo $json=json_encode($arr);
        }
        
    }
    public function update(Request $request)
    {
        $id = $request->input('id');
        $show = DB::select("select * from country where code='$id'");
        $arr=['code'=>'0','status'=>'OK','data'=> $show];
        echo $json=json_encode($arr);
    }
    public function updateadd(Request $request)
    {
        $code = $request->input('code');
        $name = $request->input('name');
        $population = $request->input('population');
        $add=DB::select("select * from country where name='$name'");

        if (empty($add)) {
            DB::update("update country set name = '$name',population='$population' where code = '$code'");
            $arr=['code'=>'0','status'=>'OK','data'=> "修改成功"];
            echo $json=json_encode($arr);
        }else{
            $arr=['code'=>'1','status'=>'error','data'=> "已经拥有该国家"];
            echo $json=json_encode($arr);
        }
        
    }
}