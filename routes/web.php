<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopgridController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerDashboardController;

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

Route::get('/', [ShopgridController::class, 'index'])->name('home');
Route::get('/product-category/{id}', [ShopgridController::class, 'category'])->name('product-category');
Route::get('/product-sub-category/{id}', [ShopgridController::class, 'subCategory'])->name('product-sub-category');
Route::get('/product-details/{id}', [ShopgridController::class, 'details'])->name('product-details');

Route::post('/add-to-cart/{id}', [CartController::class, 'index'])->name('cart.add');
Route::get('/my-shopping-cart', [CartController::class, 'show'])->name('cart.show');
Route::post('/update-shopping-cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::get('/delete-shopping-cart/{id}', [CartController::class, 'delete'])->name('cart.delete');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/new-order', [CheckoutController::class, 'newOrder'])->name('order.new');
Route::get('/customer-order-password/{id}', [CheckoutController::class, 'orderPassword'])->name('customer-order-password');
Route::get('/complete-order', [CheckoutController::class, 'orderComplete'])->name('order.complete');

Route::get('/all-product', [ShopgridController::class, 'product'])->name('all-product');
Route::get('/customer-registration', [CustomerController::class, 'registration'])->name('customer.registration');
Route::get('/customer-login', [CustomerDashboardController::class, 'login'])->name('customer.login');


Route::get('/my-dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
Route::get('/my-profile', [CustomerDashboardController::class, 'profile'])->name('customer.profile');
Route::get('/my-order', [CustomerDashboardController::class, 'order'])->name('customer.order');
Route::get('/my-order-detail', [CustomerDashboardController::class, 'orderDetail'])->name('customer.order-detail');
Route::get('/my-change-password', [CustomerDashboardController::class, 'changePassword'])->name('customer.change-password');
Route::get('/customer-logout', [CustomerDashboardController::class, 'logout'])->name('customer.logout');



Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    Route::get('/category/add', [CategoryController::class,'index'])->name('category.add');
    Route::post('/category/new', [CategoryController::class,'create'])->name('category.new');
    Route::get('/category/manage', [CategoryController::class,'manage'])->name('category.manage');
    Route::get('/category/edit{id}', [CategoryController::class,'edit'])->name('category.edit');
    Route::post('/category/update{id}', [CategoryController::class,'update'])->name('category.update');
    Route::get('/category/delete{id}', [CategoryController::class,'delete'])->name('category.delete');

    Route::get('/sub-category/add', [SubCategoryController::class,'index'])->name('sub-category.add');
    Route::post('/sub-category/new', [SubCategoryController::class,'create'])->name('sub-category.new');
    Route::get('/sub-category/manage', [SubCategoryController::class,'manage'])->name('sub-category.manage');
    Route::get('/sub-category/edit{id}', [SubCategoryController::class,'edit'])->name('sub-category.edit');
    Route::post('/sub-category/update{id}', [SubCategoryController::class,'update'])->name('sub-category.update');
    Route::get('/sub-category/delete{id}', [SubCategoryController::class,'delete'])->name('sub-category.delete');

    Route::get('/brand/add', [BrandController::class,'index'])->name('brand.add');
    Route::post('/brand/new', [BrandController::class,'create'])->name('brand.new');
    Route::get('/brand/manage', [BrandController::class,'manage'])->name('brand.manage');
    Route::get('/brand/edit{id}', [BrandController::class,'edit'])->name('brand.edit');
    Route::post('/brand/update{id}', [BrandController::class,'update'])->name('brand.update');
    Route::get('/brand/delete{id}', [BrandController::class,'delete'])->name('brand.delete');

    Route::resource('unit', UnitController::class);
    Route::resource('product', ProductController::class);
    Route::get('/product.update-status/{id}',[ProductController::class, 'updateStatus'])->name('product.update-status');
    Route::get('get-subcategory-by-category',[ProductController::class, 'getSubCategoryByCategory'])->name('get-subcategory-by-category');

});
