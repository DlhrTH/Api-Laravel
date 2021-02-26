<?php

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('books', 'BookController', ['only' => ['index', 'show']]);
Route::apiResource('borrows', 'BorrowController', ['only' => ['index']]);

Route::post('createbook', 'BookController@store');
Route::post('newborrow', 'BorrowController@store');
Route::post('newuser', 'UserController@store');
Route::delete('deletebook/{book}', 'BookController@destroy');
Route::delete('deleteuser/{user}', 'UserController@destroy');
Route::put('updatebook/{book}', 'BookController@update');
Route::put('updateuser/{user}', 'UserController@update');

