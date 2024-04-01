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

Route::group(['middleware' => ['web', 'visitor']], function () {
    Route::get('/',                         [FrontendController::class, 'getHomePage'])->name('frontend.home');
    Route::get('/developer-login',          [FrontendController::class, 'getDeveloperLogin'])->name('frontend.developer.login');
    Route::post('/developer-login',         [FrontendController::class, 'setDeveloperLogin'])->name('frontend.developer.set_login');
    Route::get('/datenschutz',              [FrontendController::class, 'getDataProtectionPage'])->name('frontend.page.data_protection');
    Route::get('/impressum',                [FrontendController::class, 'getImprintPage'])->name('frontend.page.imprint');
    Route::get('/rueckruf',                 [FrontendController::class, 'getContactPage'])->name('frontend.page.contact');
    Route::get('/team',                     [FrontendController::class, 'getTeamPage'])->name('frontend.page.team');
    Route::get('/download/product-csv',     [FrontendController::class, 'downloadProductCsv'])->name('frontend.download_product_csv');
    Route::get('/register',                 [FrontendController::class, 'getShowRoomPage'])->name('frontend.get_show_room');
    Route::get('search/customer',           [FrontendController::class, 'searchByCustomerId'])->name('frontend.search_customer');
    Route::get('libraries/{customer_id}',   [FrontendController::class, 'getCustomerLibraries'])->name('frontend.get_customer_libraries');
    Route::get('books/{id}',                [FrontendController::class, 'getBookDescription'])->name('frontend.get_book');
    Route::post('/contact-form',            [FrontendController::class, 'registerContactForm'])->name('frontend.contact_form');
    Route::post('/guest/message-to-user',   [FrontendController::class, 'sendGuestMessageToUser'])->name('frontend.guest.message_to_user');
    Route::post('/guest/send-message-from-book', [FrontendController::class, 'sendMessageFromBook'])->name('frontend.guest.message_from_book');
    Route::get('download/libraries/{id}',   [FrontendController::class, 'downloadUserProductDetail'])->name('frontend.user.download_product_detail');
    Route::post('user/forgot-password-query', [FrontendController::class, 'forgotPasswordQuery'])->name('frontend.user.forgot_password_query');
    Route::post('guest/inquiry',            [FrontendController::class, 'createSignalForGuestBookSelling'])->name('guest.inquiry');
    Route::post('book/inquiry',             [FrontendController::class, 'createInquiryForBookSelling'])->name('book.inquiry');
    Route::post('password-forgot-request',  [FrontendController::class, 'requestForgotPassword'])->name('request.forgot_password');
});

Route::group(['middleware' => ['web']], function () {
    Route::get('filter/customers',          [FrontendController::class, 'getFilteredCustomers'])->name('frontend.filter_customers');
    Route::get('filter/products',           [FrontendController::class, 'getFilteredProducts'])->name('frontend.filter_products');
});



require __DIR__.'/admin/auth.php';
require __DIR__.'/customer/auth.php';
require __DIR__.'/salesperson/auth.php';

Route::get('admin', function () { return redirect()->to('/admin/login'); });
Route::view('admin/{any}', 'spa')->where('any', '.*');
Route::view('login', 'spa');
Route::view('customer/{any}', 'spa')->where('any', '.*');
