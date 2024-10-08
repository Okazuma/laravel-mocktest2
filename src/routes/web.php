<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\QRCodeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\VerifyEmail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\User;



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


// ーーーーーーーーーー会員登録処理ーーーーーーーーーー

// 会員登録ページ表示のルート
Route::get('/register',[RegisterController::class,'showRegisterForm'])->name('register');

// 会員登録処理のルート
Route::post('/register', [RegisterController::class, 'register']);

// 認証成功ページ表示のルート
Route::get('/thanks', [RegisterController::class, 'thanks']);



// ーーーーーーーーーー認証機能処理ーーーーーーーーーー

// ログインページ表示のルート
Route::get('/login',[AuthController::class,'showLoginForm'])->name('login');

// ログイン処理のルート
Route::post('/login',[AuthController::class,'login']);



// ーーーーーーーーーーメール認証ーーーーーーーーーー

// メール認証を促すページを表示するルート
Route::get('/email/verify', [AuthController::class, 'notice'])->name('verification.notice');

// メール認証を行うルート
Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::findOrFail($id);
    $user->markEmailAsVerified();
        return view('auth.thanks');
})->middleware(['signed'])->name('verification.verify');

// 認証メール再送信のルート
Route::post('/email/verify/resend', [AuthController::class, 'resendVerificationEmail'])->name('verification.resend');



// ーーーーーーーーーー飲食店一覧ーーーーーーーーーー

// 飲食店一覧ページ(HOME)表示のルート
Route::get('/',[RestaurantController::class,'index'])->name('restaurants.index');

// 飲食店一覧ページで検索結果を表示するルート
Route::get('/restaurants.search',[RestaurantController::class,'search'])->name('restaurants.search');

// イイネボタンの処理をするルート
Route::post('/restaurants/{restaurant}/like', [RestaurantController::class, 'like'])->middleware(['auth'])->name('restaurants.like');

// カードの並び替え処理のルート
Route::get('/restaurants/sort', [RestaurantController::class, 'sort'])->name('restaurants.sort');



// ーーーーーーーーーーMenu画面ーーーーーーーーーー

// ログインユーザーメニュー表示のルート
Route::get('/user/menu',[RestaurantController::class,'menuUser'])->name('user-menu');

// ゲストユーザーメニュー表示のルート
Route::get('/guest/menu',[RestaurantController::class,'menuGuest'])->name('guest-menu');



// ーーーーーーーーーー飲食店詳細ーーーーーーーーーー

// 飲食店詳細を表示するルート
Route::get('/detail/{shop_id}', [RestaurantController::class,'detail'])->name('restaurants.detail');

// 飲食店詳細ページで予約を作成するルート
Route::post('/restaurants/{restaurant}/reserve', [ReservationController::class, 'store'])
    ->middleware(['auth','VerifyEmail'])->name('restaurants.reservation');

// 飲食店詳細ページで予約完了後にdoneページの表示のルート
Route::get('/done',[ReservationController::class,'done'])->name('done');



// ーーーーーーーーーーマイページーーーーーーーーーー

Route::middleware(['auth'])->group(function () {
    // マイページの表示ルート
    Route::get('/mypage', [MypageController::class, 'mypage'])->name('mypage');

    // 予約情報の更新ページ表示のルート
    Route::get('/mypage-edit/{id}',[MypageController::class,'edit'])->name('edit');

    // 予約情報を更新するルート
    Route::post('/mypage',[MypageController::class,'update'])->name('update');

    // 予約削除確認ページ表示のルート
    Route::get('/confirm/{id}', [MypageController::class, 'confirm'])->name('confirm');

    // 予約情報を削除するルート
    Route::delete('/delete/{id}',[MypageController::class,'destroy']);
});



// ーーーーー管理用ダッシュボード表示ーーーーー

Route::get('/dashboard',[DashboardController::class,'showDashboard'])->name('dashboard');



// ーーーーーーーーーー管理者関連ーーーーーーーーーー

Route::middleware(['admin'])->group(function(){
    // トップページ表示のルート（管理者用）
    Route::get('/admin/home',[AdminController::class,'showAdminHome'])->name('admin.admin-home');

    // 飲食店代表者の作成ページ表示のルート
    Route::get('/admin/create-manager',[AdminController::class,'showCreateManager'])->name('admin.create-manager');

    // 飲食店代表者を作成するルート
    Route::post('/admin/create-manager',[AdminController::class,'storeRestaurantManager'])->name('admin.store-manager');

    // インポートページ表示のルート
    Route::get('/admin/import-csv',[AdminController::class,'showAdminImport'])->name('admin.import-csv');

    // 画像ファイルをアップロードするルート
    Route::post('/upload', [AdminController::class, 'uploadImages'])->name('images.upload');

    // CSVをインポートするルート
    Route::post('/restaurants/import', [AdminController::class, 'import'])->name('restaurants.import');
});



// ーーーーーーーーーー店舗代表者関連ーーーーーーーーーー

Route::middleware(['store_manager'])->group(function(){
    // 店舗代表者ページ表示のルート
    Route::get('/management/home',[ManagementController::class,'showManagementHome'])->name('management-home');

    // 店舗情報の管理ページ表示のルート
    Route::get('/management/edit',[ManagementController::class,'showManagementEdit'])->name('management.edit');

    // 店舗情報の作成処理ルート
    Route::post('/management/edit',[ManagementController::class,'storeRestaurant'])->name('management-edit');

    // 店舗情報の更新ページ表示のルート
    Route::get('/management/update/{id}',[ManagementController::class,'showManagementUpdate'])->name('management.restaurants');

    // 店舗情報の更新処理ルート
    Route::patch('/management/update/{id}', [ManagementController::class, 'updateRestaurant'])->name('management.update');

    // 予約情報ページ表示のルート
    Route::get('/management/reservations',[ManagementController::class,'showManagementReservations'])->name('management.reservations');

    // お知らせメール送信ページを表示するルート
    Route::get('/management/send-email', [ManagementController::class, 'showEmailForm'])->name('management.email.form');

    // お知らせメールを送信するルート
    Route::post('/management/send-email', [ManagementController::class, 'sendEmail'])->name('management.email.send');
});



// ーーーーーーーーーーQRコードを表示するルートーーーーーーーーーー

Route::get('/qr-code/open', [QRCodeController::class, 'openQrCode'])->name('qr-code.open');



// ーーーーーーーーーーレビュー画面ーーーーーーーーーー

// レビューページを表示するルート
Route::get('/reviews/{restaurant_id}',[ReviewController::class,'reviews'])->middleware('check.store_manager')->middleware(['auth','VerifyEmail'])->name('reviews');

// レビューを記録するルート
Route::post('/reviews/{restaurant_id}',[ReviewController::class,'storeReview'])->name('reviews.store');

// レビューを削除するルート
Route::delete('/reviews/{id}', [ReviewController::class, 'deleteReview'])->name('reviews.destroy');

// レビュー一覧を表示するルートするルート
Route::get('/reviews-all/{restaurant_id}',[ReviewController::class,'reviewsAll'])->middleware(['auth','VerifyEmail'])->name('reviews.all');



// ーーーーーーーーーーStripe決済ーーーーーーーーーー

// 支払いページ表示のルート
Route::get('/checkout', function () {
    return view('payment.payment-checkout'); // ビュー名を更新
});

// 支払い成功ページ表示のルート
Route::get('/payment/success',function(){
    return view('payment.payment-success');
})->name('payment.success');

// 支払いキャンセルページ表示のルート
Route::get('payment/cancel',function(){
    return view('payment.payment-cancel');
})->name('payment.cancel');

// 支払い処理を行うルート
Route::post('/create-checkout-session', [PaymentController::class, 'createCheckoutSession']);


