<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
}