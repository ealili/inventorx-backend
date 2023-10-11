<?php

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
    // This worked for donwloading the file name stored by
    // $file = Storage::putFile('avatars', $request->avatar);
    // in the local disk

    $fileName = 'ERlNKDWosnRRwpEQ0akvc6rOnyxbaV4Fmhf7JJWV.jpg';
    $path = storage_path('app/public/avatars/' . $fileName);

    if (file_exists($path)) {
        return response()->download($path);
    } else {
        return response()->json(['error' => 'File not found.'], 404);
    }
});

//Route::get('/', function () {
//
//});
