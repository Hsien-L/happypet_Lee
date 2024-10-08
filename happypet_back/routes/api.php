<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MyPetController;
use App\Http\Controllers\UserinfoController;

use App\Http\Controllers\SeriesProductInsertController; 
use App\Http\Controllers\DetailProductInsertController; 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// main_info區 查詢產品系列號是否已有、類別下拉選單
Route::get('/product_back/info/select/{seriesID?}',function($seriesID = null){
    $seriesIDCount = DB::scalar("SELECT count(*) FROM product_series WHERE series_id = ?",[$seriesID]);
    $categories = DB::select('SELECT category_id,description FROM product_category');
    // $categories->toArray();
    // Cannot use object of type stdClass as array ，解決↓ (編碼在解碼為Array)
    $categories = json_decode(json_encode($categories), true);

    // 預設message為null
    $message = null;
    if ($seriesID !== null && $seriesIDCount > 0) {
        // return response()->json(["message" => "此產品系列編號已使用"]);
        $message = (["message" => "此產品系列編號已使用"]);
        // echo json_encode($row['id']);
    } 
    $categoryArr = [];
    foreach($categories as $category){
        $categoryArr[] = $category['category_id']."-".$category['description'];    
    }
    // print_r($categories);

    return response()->json([
        'message'=>$message,
        'categories'=>$categoryArr,
    ]);
 
});
// 產品主要資訊插入(系列產品)
Route::post('/product_back/info/create',[SeriesProductInsertController::class,'store']);
// 產品詳細資訊：查詢系列編號

Route::post('/product_back/detail/show',function(Request $request) {
    $pdSeries = $request->input('pdSeries');
    Log::info('查詢產品系列ID:', ['pdSeries' => $pdSeries]); // 日誌查詢的ID
    $existPdSeries = DB::table('product_series')
    ->select('series_id','series_name')
    ->where('series_id',$pdSeries)
    ->first(); // 使用 first() 取得單一結果
    if($existPdSeries){

        return response()->json($existPdSeries);
    }else{
        return response()->json(["error" => "查無此系列產品"]);
    }
});
// php artisan make:controller DetailProductInsertController
Route::post('/product_back/detail/create',[DetailProductInsertController::class,'store']);

//會員註冊
Route::post('/member_register', RegisterController::class);

//會員登入
Route::post('/member_login', [LoginController::class, 'login']);

//會員新增寵物
Route::post('/member_add_pet', [MyPetController::class, 'add_pet']);

//查看我的寵物資料
Route::post('/member_mypet', [MyPetController::class, 'mypet_card']);

//編輯我的寵物資料
Route::post('/member_edit_pet', [MyPetController::class, 'edit_petinfo']);

//查看會員資料
Route::post('/member_userinfo', [UserinfoController::class, 'show_userinfo']);

//編輯會員資料
Route::post('/member_userinfo_update', [UserinfoController::class, 'edit_userinfo']);

//重設密碼
Route::post('/member_reset_password', [UserinfoController::class, 'reset_password']);