<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

// Controller
// Route::get('home', [HomeController::class, 'index'])->name('home');

Route::get('profile', ProfileController::class)->name('profile');

Route::resource('employees', EmployeeController::class);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Meletakkan File pada Public Disk
Route::get('/local-disk', function() {
    Storage::disk('local')->put('local-example.txt', 'This is local example content');
    return asset('storage/local-example.txt');
    });


Route::get('/public-disk', function() {
    Storage::disk('public')->put('public-example.txt', 'This is public example
    content');
    return asset('storage/public-example.txt');
    });


    //MENAMPILKAN ISI FILE LOCAL
Route::get('/retrieve-local-file', function() {
    if (Storage::disk('local')->exists('local-example.txt')) {
    $contents = Storage::disk('local')->get('local-example.txt');
    } else {
    $contents = 'File does not exist';
    }
    return $contents;
    });

    // ISI FILE PUBLIC
Route::get('/retrieve-public-file', function() {
    if (Storage::disk('public')->exists('public-example.txt')) {
    $contents = Storage::disk('public')->get('public-example.txt');
    } else {
    $contents = 'File does not exist';
    }
    return $contents;
    });

    //DOWNLOAD FILE
Route::get('/download-local-file', function() {
    return Storage::download('local-example.txt', 'local file');
    });

Route::get('/download-public-file', function() {
    return Storage::download('public/public-example.txt', 'public file');
    });


//Menampilkan URL, Path dan Size dari File
Route::get('/file-url', function() {
    // Just prepend "/storage" to the given path and return a relative URL
    $url = Storage::url('local-example.txt');
    return $url;
    });

Route::get('/file-size', function() {
    $size = Storage::size('local-example.txt');
    return $size;
    });

Route::get('/file-path', function() {
    $path = Storage::path('local-example.txt');
    return $path;
    });


//Menyimpan File via Form
Route::get('/upload-example', function() {
    return view('upload_example');
    });
Route::post('/upload-example', function(Request $request) {
    $path = $request->file('avatar')->store('public');
    return $path;
    })->name('upload-example');


    //Menghapus File pada Storage
Route::get('/delete-local-file', function(Request $request) {
    Storage::disk('local')->delete('local-example.txt');
    return 'Deleted';
    });
Route::get('/delete-public-file', function(Request $request) {
    Storage::disk('public')->delete('public-example.txt');
    return 'Deleted';
    });


Route::get('download-file/{employeeId}', [EmployeeController::class,
'downloadFile'])->name('employees.downloadFile');
