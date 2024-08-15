<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddPetController extends Controller
{
    public function add_pet(Request $request)
    {
        try {
             // 確保 pet_headphoto 是一個上傳文件
            if ($request->hasFile('pet_headphoto')) {
                $pet_headphoto = $request->file('pet_headphoto');
                // 儲存文件並獲取路徑
                $pet_headphoto_path = $pet_headphoto->store('pet_photos', 'public');
            } else {
                $pet_headphoto_path = null; // 如果沒有上傳圖片，可以設定為 null 或空值
            }

        // 插入數據到數據庫
            $add_pet = DB::table('pet_info')->insert([
                'pet_name' => $request->input('pet_name'),
                'pet_species' => $request->input('pet_species'),
                'pet_weight' => $request->input('pet_weight'),
                'pet_variety' => $request->input('pet_variety'),
                'pet_fur' => $request->input('pet_fur'),
                'pet_gender' => $request->input('pet_gender'),
                'pet_birthday' => $request->input('pet_birthday'),
                'neutered' => $request->input('neutered'),
                'pet_headphoto' => $pet_headphoto_path,  // 確保這裡是字符串
                'others' => $request->input('others')
                ]);


            if ($add_pet) {
                // 如果插入成功，返回成功消息
                return response()->json(["message" => "新增成功！"]);
            } else {
                // 如果插入失敗，返回錯誤消息
                return response()->json(["error" => "新增失敗，再試一次"]);
            }
        } catch (\Exception $e) {
            // 捕獲異常，返回錯誤消息
            Log::error($e->getMessage());
            return response()->json(["error" => "過程中發生錯誤"]);
        }
    }

}
