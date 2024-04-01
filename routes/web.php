<?php

use App\CommandProcess\Admin\Administrator\CreateSalespersonCommissionPdf;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

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

require __DIR__.'/admin/auth.php';
require __DIR__.'/salesperson/auth.php';

Route::get('/', function () { return redirect()->to('/admin/login'); });
Route::get('login', function () { return redirect()->to('/admin/login'); });
Route::get('admin', function () { return redirect()->to('/admin/login'); });
Route::view('admin/{any}', 'spa')->where('any', '.*');
