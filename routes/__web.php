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

/*
Route::get('/testing', function (\Rosamarsky\CommandBus\CommandBus $commandBus) {
    $adminId = 22;
    $dateFrom = '2023-11-01';
    $dateTo = '2023-11-30';
    return $commandBus->execute(new CreateSalespersonCommissionPdf($adminId, $dateFrom, $dateTo));
});
*/
Route::get('/', function () { return redirect()->to('/admin/login'); });
Route::get('/rueckruf',                 [FrontendController::class, 'getContactPage'])->name('frontend.page.contact');

require __DIR__.'/admin/auth.php';
require __DIR__.'/customer/auth.php';
require __DIR__.'/salesperson/auth.php';

Route::get('admin', function () { return redirect()->to('/admin/login'); });
Route::view('admin/{any}', 'spa')->where('any', '.*');
Route::view('login', 'spa');
Route::view('customer/{any}', 'spa')->where('any', '.*');
