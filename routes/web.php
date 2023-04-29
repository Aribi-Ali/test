<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {


    
    return view('front.landing');
})->name("home");






Route::get("/dash",function(){
    echo "Hello, world!";


    return view("admin.dashboard");
});
//Route::post("/upload-image",[PostController::class,"upload"])->name("image.upload.media");

//Route::get("/image",[PostController::class,"store"]);
Route::get("/test",[PostController::class,"test"]);
Route::get("/delete",[PostController::class,"delete"]);




Route::get("/login",[AdminController::class,"loginPage"]);
Route::get("/register",[AdminController::class,"registerPage"]);
Route::get("/register",[AdminController::class,"registerPage"]);
Route::get("/logout",[AdminController::class,"logout"]);
Route::post("/login",[AdminController::class,"login"])->name("login");

Route::group(["prefix"=>"posts"],function(){
    Route::get("/show/{id}",[PostController::class,"show"])->name('post.show');
    Route::get("/create",[PostController::class,"create"])->name("post.create");
    Route::get("/",[PostController::class,"index"])->name("post.index");
    Route::get("/{id}",[PostController::class,"reverse"])->name("post.reverse");
    Route::get("/edit/{id}",[PostController::class,"edit"])->name("post.edit");
    Route::get("/delete/{id}",[PostController::class,"delete"])->name("post.delete");
    Route::post("/update/{id}",[PostController::class,"update"])->name("post.update");
    Route::post("/create",[PostController::class,"storePost"])->name("post.store");
});

Route::group(["prefix"=>"categories"],function(){
    Route::get("/create",[CategoryController::class,"create"])->name("category.create");
    Route::post("/create",[CategoryController::class,"store"])->name("category.store");
    Route::get("/",[CategoryController::class,"index"])->name("category.index");
    Route::get("/delete/{id}",[CategoryController::class,"destroy"])->name("category.delete");
    Route::get("/edit/{id}",[CategoryController::class,"edit"])->name("category.edit");

    /*Route::get("/show/{id}",[PostController::class,"show"])->name('post.show');
    Route::get("/{id}",[PostController::class,"reverse"])->name("post.reverse");
    Route::post("/update/{id}",[PostController::class,"update"])->name("post.update");
*/

});





Route::post("/image/store",[PostController::class,"uploadImage"])->name("image.upload");
Route::get("/mail",[PostController::class,"testMail"]);