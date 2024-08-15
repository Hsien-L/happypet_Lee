<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class MyPetCardController extends Controller
{
    function mypet_card(Request $request){
        // echo $request->input('uid');
        $data = DB::select('select * from pet_info where uid=?', [$request->input('uid')]);

        return response()->json($data);

    }
}
