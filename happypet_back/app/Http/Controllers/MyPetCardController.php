<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use finfo;

use Illuminate\Http\Request;

class MyPetCardController extends Controller
{
    function mypet_card(Request $request){
        // echo $request->input('uid');
        $data = DB::select('select * from pet_info where uid=?', [$request->input('uid')]);
        $result = collect($data)->map(function($row) {
            if($row->pet_headphoto) {
                $mimetype = (new finfo(FILEINFO_MIME_TYPE))->buffer($row->pet_headphoto);

                $base64 = base64_encode($row->pet_headphoto);
                $row->pet_headphoto = "data:${mimetype};base64,${base64}";
            }
            return $row;
        });
        return response()->json($result);

    }
}
