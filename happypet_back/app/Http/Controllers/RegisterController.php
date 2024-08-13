<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    function __invoke(Request $request){
        try{
            $cname = $request->input('cname');
            $myemail = $request->input('myemail');
            $mypassword = bcrypt($request->input('mypassword'));
            $mypassword_conf = $request->input('mypassword_conf');
            $sex = $request->input('sex');
            $cellphone = $request->input('cellphone');
            // $address = $request->input('address');
            // $headphoto = $request->file('headphoto');

            $sign_in = DB::insert('insert into user_info(cname, email, password, sex, cellphone) values (?, ?, ?, ?, ?)',
            [$cname, $myemail, $mypassword, $sex, $cellphone]);

            if ($sign_in){

                return response()->json(["message"=>"註冊成功"]);
            }
            // else{
            //     return response()->json(["error"=>"註冊失敗"]);
            // }
            // $aa = DB::select('select * from user_info');
            Log::info('userinfo',["info",$aa]);
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(["error"=>"註冊失敗"]);
        }
    }
    function edit(){
        
    }

}
