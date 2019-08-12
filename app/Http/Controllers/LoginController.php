<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    /**
     * 展示应用的用户列表.
     *
     * @return Response
     */
    public function index()
    {
        $users = DB::select('select * from admin where id = ?', [1]);
        var_dump($users);
        return view('login.login', ['users' => $users]);
    }

    public function login_action()
    {
        //$users = DB::select('select * from admin where id = ?', [1]);
    }
    public function boot(Request $request)
    {
        // 验证新密码长度...

        $request->users()->fill([
            'password' => Hash::make($request->newPassword)
        ])->save();
    }

}