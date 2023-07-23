<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreDetailsController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/api-data',[StoreDetailsController::class,'store']);
Route::get('/api-get-data',[StoreDetailsController::class,'index']);
Route::get('api-data/{id}',[StoreDetailsController::class,'show']);
Route::get('api-data/image/{file}', 'StoreDetailsController@getImage')->name('api.data.image');
Route::get('/temporary-url/{imagePath}', 'YourController@getTemporaryImageUrl');
// Route::get('api-data/image/{filename}', 'StoreDetailsController@getImage')->name('api.data.image');
