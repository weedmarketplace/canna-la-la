<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;

use Illuminate\Http\Request;

// use App\Http\Controllers\DocumentController;
// use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
// use Illuminate\Http\Request;
use App\Helpers\Helper;
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
// Route::get('/age-confirmation', function () {
//     return view('app.age-confirmation');
// })->name('age.confirmation');

// Route::post('/confirm-age', function () {
//     session(['age_verified' => true]);
//     return response()->json(['message' => 'Age confirmed']);
// });

Route::get('/', [WelcomeController::class, 'homepage'])->name('homepage');
Route::paginate('shop/{slug?}',function ($slug = false){
    if($slug){
        $id = Helper::checkCollectionSlug($slug);
        if($id){
            $app = app();
            $controllerPath = 'App\Http\Controllers\ShopController';
            $controller = $app->make($controllerPath);
            return $controller->callAction('shop', ['id'=>$id]);
        }else{
            return redirect('/404');
        }
    }else{
        $app = app();
        $controllerPath = 'App\Http\Controllers\ShopController';
        $controller = $app->make($controllerPath);
        return $controller->callAction('shop', ['id'=>false]);
    }
})->name('shop');

Route::get('/get-product', [ShopController::class, 'getProduct'])->name('getProduct');

Route::get('product/{slug}', function ($slug) {
    $id = Helper::checkProductSlug($slug);

    if(!$id){
        return redirect('/404');
    }

    $app = app();
    $controllerPath = 'App\Http\Controllers\ShopController';
    $controller = $app->make($controllerPath);

    return $controller->callAction('product', ['id'=>$id]);
})->name('product');


Route::get('/about-us', [WelcomeController::class, 'about'])->name('about');
Route::get('/coming-soon', [WelcomeController::class, 'coming'])->name('coming');
Route::get('/sign-in', [WelcomeController::class, 'signin'])->name('sign-in')->middleware('guest');
Route::get('/sign-up', [WelcomeController::class, 'signup'])->name('sign-up')->middleware('guest');
Route::post('/sign-up-submit', [AuthController::class, 'signupSubmit'])->name('sign-up-submit')->middleware('guest');
Route::post('/sign-in-submit', [AuthController::class, 'signinSubmit'])->name('sign-in-submit')->middleware('guest');


Route::get('/terms-and-conditions', [WelcomeController::class, 'terms'])->name('terms');
Route::get('/privacy-policy', [WelcomeController::class, 'privacy'])->name('privacy');

Route::get('/forget-password', [AuthController::class, 'forgetPass'])->name('forget-password');
Route::post('/sendPasswordRecover', [AuthController::class, 'sendPasswordRecover'])->name('sendPasswordRecover');
Route::get('/checkRecoveryHash', [AuthController::class, 'checkRecoveryHash'])->name('checkRecoveryHash');
Route::post('/recoveryPassword', [AuthController::class, 'recoveryPassword'])->name('recoveryPassword');


Route::post('/add-to-wishlist', [WelcomeController::class, 'addToWishlist'])->name('add-to-wishlist');
Route::post('/remove-from-wishlist', [WelcomeController::class, 'removeFromWishlist'])->name('remove-from-wishlist');
Route::get('/wishlist', [WelcomeController::class, 'wishlist'])->name('wishlist');

Route::post('/add-to-cart', [OrderController::class, 'addToCart'])->name('add-to-cart');
Route::post('/remove-cart', [OrderController::class, 'removeCart'])->name('remove-cart');
Route::get('/cart', [OrderController::class, 'cart'])->name('cart');
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/submit-order', [OrderController::class, 'create'])->name('submitOrder');
Route::get('/success/{hash}', [OrderController::class, 'checkoutSuccess'])->name('checkout_success');
Route::get('/order/{hash}', [OrderController::class, 'checkoutSuccess'])->name('order');
Route::post('/applyCoupon', [OrderController::class, 'applyCoupon'])->name('applyCoupon');
Route::get('/clearCart', [OrderController::class, 'clearCart'])->name('clearCart');

Route::get('/cart-empty', [WelcomeController::class, 'emptyCart'])->name('emptyCart');
Route::get('/contact-us', [WelcomeController::class, 'contact'])->name('contact');


Route::get('product/{slug}', function ($slug) {
    $id = Helper::checkProductSlug($slug);

    if(!$id){
        return redirect('/404');
    }

    $app = app();
    $controllerPath = 'App\Http\Controllers\ShopController';
    $controller = $app->make($controllerPath);

    return $controller->callAction('product', ['id'=>$id]);
})->name('product');

Route::get('blog/{slug}',function ($slug){
    if($slug){
        $id = Helper::checkBlogSlug($slug);
        if($id){
            $app = app();
            $controllerPath = 'App\Http\Controllers\WelcomeController';
            $controller = $app->make($controllerPath);
            return $controller->callAction('blogPage', ['id'=>$id]);
        }else{
            return redirect('/404');
        }
    }
    return redirect('/404');
})->name('blogItem');
Route::paginate('/blog', [WelcomeController::class, 'blog'])->name('blog');

Route::get('search', [ShopController::class, 'search'])->name('search');
Route::post('feedback', [WelcomeController::class, 'feedback'])->name('feedback');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/edit-account', [UserController::class, 'editAccount'])->name('editAccount');
    Route::get('/edit-address', [UserController::class, 'editAddress'])->name('editAddress');
    Route::post('/save-account', [AuthController::class, 'saveProfile'])->name('saveAccount');
    Route::post('/save-address', [AuthController::class, 'saveAddress'])->name('saveAddress');
    Route::post('/save-address-checkout', [AuthController::class, 'saveAddressCheckout'])->name('saveAddressCheckout');
    Route::get('/remove-address', [AuthController::class, 'removeAddress'])->name('removeAddress');
    Route::post('/set-main-address', [AuthController::class, 'setMainAddress'])->name('setMainAddress');

    Route::paginate('/orders', [UserController::class, 'orders'])->name('orders');
    
    Route::get('/account', [UserController::class, 'account'])->name('account');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/save-password', [AuthController::class, 'savePassword'])->name('changePasswordSubmit');
    // Route::get('/change-password', [AuthController::class, 'changePassword'])->name('changePassword');
});

Route::get('/clear', function() {
    \Session::forget('cart');
    \Session::forget('age_verified');
    return redirect('/');
});