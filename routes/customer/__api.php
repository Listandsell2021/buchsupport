<?php

use App\Http\Controllers\API\Customer\DashboardController;
use App\Http\Controllers\API\Customer\ProfileController;
use Illuminate\Support\Facades\Route;



Route::prefix('customer')->middleware(['auth:sanctum'])->group( function () {

    // Dashboard Cards
    Route::post('dashboard/cards',              [DashboardController::class, 'getCardDetails'])->name('customer.dashboard.cards');

    Route::post('dashboard/product-categories', [DashboardController::class, 'getProductCategories'])->name('customer.dashboard.product_categories');
    Route::post('dashboard/search-products',    [DashboardController::class, 'searchProducts'])->name('customer.dashboard.search_products');
    Route::post('dashboard/reverse-product-view', [DashboardController::class, 'reverseProductView'])->name('customer.dashboard.reverse_product_view');
    Route::post('dashboard/create-comment',     [DashboardController::class, 'createUserComment'])->name('customer.dashboard.create_comment');
    Route::post('dashboard/comments',           [DashboardController::class, 'getUserComments'])->name('customer.dashboard.comments');
    Route::post('dashboard/book-inquiry',       [DashboardController::class, 'createUserBookInquiry'])->name('customer.book.inquiry');

    Route::get('profile/get-detail',        [ProfileController::class, 'getUserDetail'])->name('customer.profile.get_detail');
    Route::post('profile/update',           [ProfileController::class, 'updateUserDetail'])->name('customer.profile.update');
    Route::post('profile/password-update',  [ProfileController::class, 'updateUserPassword'])->name('customer.profile.update_password');
    Route::post('profile/upload-image',     [ProfileController::class, 'uploadProfileImage'])->name('customer.profile.upload_image');

});



