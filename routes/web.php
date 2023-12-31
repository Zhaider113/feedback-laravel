<?php

use Illuminate\Support\Facades\Route;
use App\Events\AssignTask;

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

Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/login_page', function () {
    return view('login_page');
})->name('login_page');

Route::get('verify-account/{email}', [App\Http\Controllers\Api\AuthController::class, 'verify_account'])->name('verify_account');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::controller(App\Http\Controllers\Home\MainController::class)->group(function(){
    Route::get('/', 'welcome')->name('welcome');    
});  
Route::get('action', function(){
    return view('action');
})->name('action');
Route::get('logged_out', function(){
	\Auth::logout();
	return redirect()->route('welcome');
})->name('logged_out');	

Route::get('event', function(){
    event(new AssignTask());
});

Route::match(['GET', 'POST'], 'filters', [App\Http\Controllers\Users\MainController::class, 'filters'])->name('filters');

Route::post('contact_message', [App\Http\Controllers\Users\MainController::class, 'contact_message'])->name('contact_message');

Route::group([ 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'CheckUserRole']], function() {
    Route::controller(App\Http\Controllers\Admin\MainController::class)->group(function(){
        //define routes here for admin
        Route::get('/', 'dashboard')->name('dashboard');
    });
    Route::resource('users',App\Http\Controllers\Admin\UserController::class);     
    Route::resource('products',App\Http\Controllers\Admin\ProductController::class);      
    Route::resource('reviews',App\Http\Controllers\Admin\ProductReviewController::class); 
});

Route::group([ 'prefix' => 'user', 'as' => 'user.', 'middleware' => ['auth', 'CheckUserRole']], function() {
    Route::controller(App\Http\Controllers\Users\MainController::class)->group(function(){
        //define routes here for users
        Route::get('/', 'dashboard')->name('dashboard');
        Route::get('contact_us_message','contact_us_message')->name('contact_us_message');
        Route::get('get_notifications', 'get_notifications')->name('get_notifications');
        
    });
    Route::controller(App\Http\Controllers\Users\SettingController::class)->group(function(){
        Route::get('settings','view_setting')->name('settings');
        Route::post('update_information','update_information')->name('update_information');
        Route::get('delete_auth_account','delete_auth_account')->name('delete_auth_account');
    });

    Route::resource('reviews',App\Http\Controllers\Users\ProductReviewController::class);
});
Route::get('product_details/{id}',[App\Http\Controllers\Users\ProductController::class,'show'])->name('product_details');

 

Route::post('reset_password_without_token', [App\Http\Controllers\Api\AuthController::class,'validatePasswordRequest'])->name('validatePasswordRequest');
Route::post('reset_password_with_token', [App\Http\Controllers\Api\AuthController::class,'resetPassword'])->name('resetPassword');


Route::prefix('dev')->group(function(){
	Route::get('config-clear', function(){
		try{
			\Artisan::call('config:clear');
			echo "Configuration cache cleared!";
		} catch( \Exception $e) {
			dd($e->getMessage());
		}
	});
});

Route::prefix('dev')->group(function(){
	Route::get('optimize-clear', function(){
		try{
			\Artisan::call('optimize:clear');
			echo "Optimization Clear!";
		} catch( \Exception $e) {
			dd($e->getMessage());
		}
	});
});

Route::prefix('dev')->group(function(){
	Route::get('route-clear', function(){
		try{
			\Artisan::call('route:clear');
			echo "Route cache cleared!";
		} catch( \Exception $e) {
			dd($e->getMessage());
		}
	});
});

Route::prefix('dev')->group(function(){
	Route::get('view-clear', function(){
		try{
			\Artisan::call('view:clear');
			echo "View cache cleared!";
		} catch( \Exception $e) {
			dd($e->getMessage());
		}
	});
});

Route::prefix('dev')->group(function(){
	Route::get('config-cache', function(){
		try{
			\Artisan::call('config:cache');
			echo "Configuration cache cleared!";
			echo "Configuration cached successfully!";
		} catch( \Exception $e) {
			dd($e->getMessage());
		}
	});
});

Route::prefix('dev')->group(function(){
	Route::get('route-cache', function(){
		try{
			\Artisan::call('route:cache');
			echo "Route cache cleared!";
			echo "Route cached successfully!";
		} catch( \Exception $e) {
			dd($e->getMessage());
		}
	});
});

Route::prefix('dev')->group(function(){
	Route::get('view-cache', function(){
		try{
			\Artisan::call('view:cache');
			echo "View cache cleared!";
			echo "View cached successfully!";
		} catch( \Exception $e) {
			dd($e->getMessage());
		}
	});
});





