<?php

namespace App\Http\Controllers;

use Yansongda\Pay\Pay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth:api', ['except' => ['notify']]);
//    }
    protected $config = [
        'alipay' => [
            'app_id' => '2016101000654987',  //APPID
            'notify_url' => 'http://localhost/blog/public/api/notify', //异步跳转
            'return_url' => 'http://localhost/blog/public/api/return',   //同步调整

            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAkeVML5GowR4FGKyV2Hh3x7RsruAYS0Jqcb1n2Z9oFhmjKqyBfIBP+TOGtojZq5e+ApNKwv4bKq9391TWd+PFpvTtzgOg1N3s7XPC1aJel1UTd5vtjpqpzBagK7m+UDdfToGuJhCKUXb4vapY4/MK8Fh87JEdgFUssNOmhZCLZojchA7gFHU6I6A9cdNGUH0r6zTBaLR9x+F1sakiWjRJ3QVcDQ8Y/oKDJaPg+zrQ5d4EdOOpV/+pxQ20y8gtWrNa/Mdr4P3N6uiwCOOWGoTZ9BK9hVC3DpizX3U5SwZ9gI5kvsJEZkAVZ6hHcEvpNmdPjqfi1ey5Y/jicdWxaJNBKwIDAQAB',

            'private_key' => 'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCR5UwvkajBHgUYrJXYeHfHtGyu4BhLQmpxvWfZn2gWGaMqrIF8gE/5M4a2iNmrl74Ck0rC/hsqr3f3VNZ348Wm9O3OA6DU3eztc8LVol6XVRN3m+2OmqnMFqArub5QN19Oga4mEIpRdvi9qljj8wrwWHzskR2AVSyw06aFkItmiNyEDuAUdTojoD1x00ZQfSvrNMFotH3H4XWxqSJaNEndBVwNDxj+goMlo+D7OtDl3gR046lX/6nFDbTLyC1as1r8x2vg/c3q6LAI45YahNn0Er2FULcOmLNfdTlLBn2AjmS+wkRmQBVnqEdwS+k2Z0+Op+LV7Llj+OJx1bFok0ErAgMBAAECggEAT0FzO7wzIoW+WwMWe/wlhbV7/Rv71paD4Ln1+oDgOHFA9GO2C/5gc44MNojtRowuSpPdX0RPWcbsss3BnGt96g7QSMQr0Lemh/AE/a0xGaC77JQmXvuiFh6McHR88HLEMY+9HSyLF2o8AjzSATL81EgdxR2oGxkqJ/0yTwiQ0efhBASImUJ/nlk2uFi9gmEu4vHHKdl+hN+dT8w2EAdrlcUp7JHnWUdx0MuxNEx0JuLh4qN60QxDGuDP+O9naXUQX1oMtQlGsZRrLoX2D6AHmH61T7dxaQ65SAwG9KMsQ7+bpuqWYaP6o/bYciOBHWuYdrYu9qaFmUZSJyIMW3HJkQKBgQDOfk09w+f9i+KyBR374JzOkk0PFHTMteRbRyozXh8sMOXtFO5uLyHvO+5nHpPM8x0CUHWuH5K+/kecAO3sX8vm6eH9xrj9EhVEn9hBWoPt8IuABHS354B1IzEPsMU24eb5eyAi7eYXpf/wOwoC0xBDIb3uHQB50Ol2E53JFajU1wKBgQC038OzVEERRTq5tOCB4gePCJEbRYDZrh/j1/C3/TyYWZVnn1MpBoYEwrXoT0mbL5Q77fGaJLcm3gsQIv/fYgryjbkfAzOTHdywon0u1GjutrOfP9nRKHIQ1BCgneDM2O11ty9F5WbU5ly092smkJQGlZ9ZOgbWYJjeYuBfaxqXzQKBgGZtB+tnTZ/az2v2VdUmqSFeOJMOVpFkeA0+05P/T/8fki1zgIFvJ6n/VFYaOL4kqXMIbhcc2jGa9/JOE7Z4HjBAOzUiaYg+fAY6M47XUzGna8roauz+DB4OgruBt5FtpKCDjoFE+Ckq0jVbU6/q+doS1p9SC3ZhRiyntlCUSdapAoGAc/vdOVx40QNMshLruD3hzPWYXx2Fj5DZwDgTk1gfCC7B4I3JPNCDFgBpt4tITuwGqRtexxJuI81U2McovuzWykzY/asG4nrOrrGzhlkM5K5hpmfCXB4MbwAdnXE/2vvr4YVTGgYNl84UerMBkdw6H7LIWOYdxlBxFoHfETDT/60CgYEAs9nOjOfUN6jVtjc0p8p0xE+EFHod34FoFmn3S93hi6RsJrKzCFU+l2nKmv6sCnc9OV2IAVQvKcPbUjSW3w0WCJ02dCk/cVHlGkzW/MtIqs0vztmiq+4/kFylgPDnwOplpSmpZuDc24ceu/l59mDzhHxsmdGxkz7tllvSkfJRbtw=',
        ],
    ];

    public function index(Request $request)
    {
        $id=$request->input('id');
        $price=$request->input('price');
        $config_biz = [
            'out_trade_no' => $id, //订单号
            'total_amount' => $price,     //价格
            'subject'      => 'test subject',
        ];
        $pay = new Pay($this->config);
        return $pay->driver('alipay')->gateway()->pay($config_biz);
    }

    public function return(Request $request)
    {
        //$pay = new Pay($this->config);
        $arr=$request->all();
        $order_id=$arr['out_trade_no'];
        $price=$arr['total_amount'];
        //var_dump($arr);
        header("http://localhost:8080/?#/buyCar_three");
        //return $pay->driver('alipay')->gateway()->verify($request->all());
    }

    public function notify(Request $request)
    {

        $pay = new Pay($this->config);
        //DB::update("update shopping_cart set stutas=0 where id=15");
        if ($pay->driver('alipay')->gateway()->verify($request->all())) {
            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况
            file_put_contents(storage_path('notify.txt'), "收到来自支付宝的异步通知\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单号：' . $request->out_trade_no . "\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单金额：' . $request->total_amount . "\r\n\r\n", FILE_APPEND);
        } else {
            file_put_contents(storage_path('notify.txt'), "收到异步通知\r\n", FILE_APPEND);
        }
        $arr=$request->all();
        $order_id=$arr['out_trade_no'];
        DB::update("update shopping_cart set stutas=1 where order_id=$order_id");
        echo "success";
    }
}