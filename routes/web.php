<?php

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
Route::get('verify/{email}/{key}', 'CustomerController@actionVerify');

Route::get('/', 'HomeController@index');
Route::get('apps-version', 'HomeController@indexAppsVersion');
Route::get('error/404', 'HomeController@indexError404');
Route::get('home', 'HomeController@indexHome');
Route::get('products', 'ProductController@indexList');
Route::get('getproducts', 'ProductController@indexGetProducts');
Route::get('search', 'ProductController@indexSearchProducts');
Route::get('product/{product_id}', 'ProductController@indexDetail');
Route::get('post/{post_id}', 'PostController@indexDetail');
Route::get('media/product/{tanggal}/{name_file}', 'ProductImageController@getProductImage');

Route::get('subscribe/{email}', 'CustomerController@actionSubscribe');
Route::get('signin', 'CustomerController@indexSignIn');
Route::post('signin', 'CustomerController@actionSignIn');
Route::get('signup', 'CustomerController@indexSignUp');
Route::post('signup', 'CustomerController@actionSignUp');
Route::get('forgot-password', 'CustomerController@indexForgotPassword');
Route::post('forgot-password', 'CustomerController@actionRequestForgotPassword');
Route::get('forgot-password/{email}/{key}', 'CustomerController@indexChangeForgotPassword');
Route::post('forgot-password/{email}/{key}', 'CustomerController@actionChangeForgotPassword');
Route::post('transaction/inquiry', 'TransactionController@actionInquiry');
Route::post('transaction/payment', 'TransactionController@actionPayment');
Route::post('transaction/payment/kredivo', 'TransactionController@actionPaymentKredivo');
Route::post('transaction/payment/akulaku', 'TransactionController@actionPaymentAkulaku');

Route::get('service/f70e1db90117780c51b32ea030a45a88/email-invoice', 'ServiceController@sendEmailInvoice');
Route::get('service/f70e1db90117780c51b32ea030a45a88/email-paid', 'ServiceController@sendEmailPaidInvoice');
Route::get('service/f70e1db90117780c51b32ea030a45a88/expired-invoice', 'ServiceController@checkExpiredInvoice');
Route::get('service/f70e1db90117780c51b32ea030a45a88/review-transaction', 'ServiceController@sendEmailReview');

Route::group(['middleware' => ['auth']], function () {
    Route::post('account/register', 'CustomerController@actionRegister');
    Route::post('account/resend-activation', 'CustomerController@actionResendActivation');
});

Route::group(['middleware' => ['auth', 'status']], function () {
    Route::group(['prefix' => 'account'], function(){
        Route::get('/', 'CustomerController@indexAccount');
        Route::get('edit', 'CustomerController@indexEditProfile');
        Route::post('edit', 'CustomerController@actionEditProfile');
        Route::get('password/change', 'CustomerController@indexChangePassword');
        Route::get('gift', 'CustomerController@indexGift');
        Route::post('password/change', 'CustomerController@actionChangePassword');
        Route::post('signout', 'CustomerController@actionSignOut');

        Route::group(['prefix' => 'address'], function(){
            Route::get('/', 'AddressController@indexList');
            Route::get('new', 'AddressController@indexManage');
            Route::get('edit/{shipping_address_id}', 'AddressController@indexManage');
            Route::post('change/province', 'AddressController@actionChangeProvince');
            Route::post('change/city', 'AddressController@actionChangeCity');
            Route::post('save', 'AddressController@actionSave');
        });
    });

    Route::group(['prefix' => 'order'], function(){
        Route::group(['prefix' => 'cart'], function(){
            Route::get('/', 'CartController@indexList');
            Route::post('quantity/add', 'CartController@actionEditCartQty');
            Route::post('detail/delete', 'CartController@actionDeleteCartDetail');
            Route::post('voucher/use', 'CartController@actionUseVoucher');
            Route::post('voucher/delete', 'CartController@actionDeleteVoucher');
        });

        Route::group(['prefix' => 'shipping-address'], function(){
            Route::get('/', 'AddressController@indexSelectShippingAddress');
            Route::post('select', 'AddressController@actionSelectShippingAddress');
        });

        Route::group(['prefix' => 'shipping-service'], function(){
            Route::get('/', 'AddressController@indexSelectShippingService');
            Route::post('select', 'AddressController@actionSelectShippingService');
        });
        
        Route::get('payment', 'CartController@indexSelectPayment');
        Route::post('payment/select', 'CartController@actionSelectPayment');
        Route::get('review', 'CartController@indexReview');
        Route::post('checkout', 'CartController@actionCheckout');
    });

    Route::group(['prefix' => 'product'], function(){
        Route::post('addtocart', 'CartController@actionAddToCart');
        Route::get('/', 'ProductController@indexList');
        Route::get('new', 'ProductController@indexManage');
        Route::get('update/{product_id}', 'ProductController@indexManage');
    });

    Route::group(['prefix' => 'wishlist'], function(){
        Route::get('/', 'WishlistController@indexList');
        Route::post('/', 'WishlistController@actionSaveDelete');
    });

    Route::group(['prefix' => 'transaction'], function(){
        Route::get('/', 'TransactionController@indexList');
        Route::get('detail/{invoice_number}', 'TransactionController@indexDetail');
        Route::get('kredivo/checkout/{invoice_number}', 'TransactionController@actionKredivoCheckout');
        Route::get('akulaku/checkout/{invoice_number}', 'TransactionController@actionAkulakuCheckout');
    });

    Route::group(['prefix' => 'api'], function(){
        Route::group(['prefix' => 'get'], function(){
            Route::post('product/list', 'ProductController@commonList');
            Route::post('image-product', 'ProductImageController@detailList');
        });

        Route::group(['prefix' => 'image-product'], function(){
            Route::post('save', 'ProductImageController@actionSave');
            Route::post('order', 'ProductImageController@actionOrder');
        });

        Route::group(['prefix' => 'product'], function(){
            Route::post('save', 'ProductController@actionSave');
        });

    });

    Route::group(['prefix' => 'posts'], function(){
        Route::get('/', 'PostController@indexList');
    });

});