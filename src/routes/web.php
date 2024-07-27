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
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\VerifyEmail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Log;
use App\models\User;
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

// ーーーーーーーーーー飲食店一覧ーーーーーーーーーー

// 飲食店一覧ページ(HOME)表示のルート
Route::get('/',[RestaurantController::class,'index'])->name('restaurants.index');

// 飲食店一覧ページで検索結果を表示するルート
Route::get('/restaurants.search',[RestaurantController::class,'search'])->name('restaurants.search');

// イイネボタンの処理をするルート
Route::post('/restaurants/{restaurant}/like', [RestaurantController::class, 'like'])->middleware(['auth'])->name('restaurants.like');






// ーーーーーーーーーーMenu画面ーーーーーーーーーー

// menu1ページ表示のルート
Route::get('/menu1',[RestaurantController::class,'menu1'])->name('restaurants.menu1');

// menu2ページ表示のルート
Route::get('/menu2',[RestaurantController::class,'menu2'])->name('restaurants.menu2');






// ーーーーーーーーーー飲食店詳細ーーーーーーーーーー

// 飲食店詳細を表示するルート
Route::get('/detail/{shop_id}', [RestaurantController::class,'detail'])->name('restaurants.detail');

// 飲食店詳細ページで予約を作成するルート
Route::post('/restaurants/{restaurant}/reserve', [ReservationController::class, 'store'])
    ->middleware(['auth','VerifyEmail'])
    ->name('restaurants.reservation');

// 飲食店詳細ページで予約完了後にdoneページの表示のルート
Route::get('/done',[ReservationController::class,'done'])->name('done');






// ーーーーーーーーーーマイページーーーーーーーーーー

Route::middleware(['auth'])->group(function () {
    // マイページの表示ルート
    Route::get('/mypage', [MypageController::class, 'mypage'])->name('mypage');

    // マイページで予約情報を削除するルート
    Route::delete('/delete/{id}',[MypageController::class,'destroy']);

    // マイページで予約情報の詳細を表示するルート
    Route::get('/reservation-edit/{id}',[MypageController::class,'edit'])->name('edit');

    // QRコードを表示するルート
    Route::get('/qrcode/{id}', [MypageController::class, 'showQRCode'])->name('show.qrcode');

    // マイページから予約情報の詳細を表示して予約情報を更新するルート
    Route::post('/mypage',[MypageController::class,'update'])->name('reservation-update');
});





// ーーーーーーーーーー会員登録処理ーーーーーーーーーー

// 会員登録ページ表示のルート
Route::get('/register',[RegisterController::class,'showRegisterForm']);

// 会員登録処理のルート
Route::post('/register', [RegisterController::class, 'register']);

// 認証成功ページ表示のルート
Route::get('/thanks', [RegisterController::class, 'thanks']);







// ーーーーーーーーーー認証機能処理ーーーーーーーーーー

// ログインページ表示のルート
Route::get('/login',[AuthController::class,'showLoginForm'])->name('login');

// ログイン処理のルート
Route::post('/login',[AuthController::class,'login']);

// ログアウト処理のルート
Route::post('/', [AuthController::class, 'logout'])->name('logout');






// ーーーーーーーーーーメール認証機能ーーーーーーーーーー

// メール認証通知ページを表示するルート
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');


// メール認証を実際に行うルート
Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::findOrFail($id);
    $user->markEmailAsVerified();
        return view('auth.thanks');
})->middleware(['signed'])->name('verification.verify');



// 認証メールを再送信するルート
Route::post('/email/verify/resend', function (Request $request) {
    // セッションからユーザーのメールアドレスを取得
    $email = session('email');
    // メールアドレスでユーザーを検索
    $user = User::where('email', $email)->first();
    if (!$user) {
        return redirect()->route('login')->withErrors(['message' => 'ユーザーが見つかりません。']);
    }
    // ユーザーがすでにメール認証されているか確認
    if ($user->hasVerifiedEmail()) {
        return redirect()->route('login')->withErrors(['message' => 'このメールアドレスは既に認証されています。']);
    }
    // 認証メールの再送信
    $user->sendEmailVerificationNotification();
    return redirect()->route('verification.notice')->with('message', '認証リンクを再送しました。');
})->name('verification.resend');






// ーーーーー管理用ダッシュボードを表示するルートーーーーー

Route::get('/dashboard',[DashboardController::class,'showDashboard'])->name('dashboard');


// ーーーーーーーーーー管理者関連ーーーーーーーーーー

Route::middleware(['admin'])->group(function(){
    // 管理者ページ表示のルート
    Route::get('/admin/edit',[AdminController::class,'showAdminEdit'])->name('admin.admin-edit');
    // 飲食店代表者を作成するルート
    // Route::post('/admin/success',[AdminController::class,'storeRestaurantManager'])->name('admin.admin-success');

    Route::post('/admin/edit',[AdminController::class,'storeRestaurantManager'])->name('admin.admin-edit');
    // 飲食店代表者の作成完了ページ表示のルート
    Route::get('/admin/success', [AdminController::class, 'adminSuccess'])->name('admin.admin-success');
});






// ーーーーーーーーーー店舗代表者用関連ーーーーーーーーーー

Route::middleware(['store_manager'])->group(function(){
    Route::get('/management/home',[ManagementController::class,'showManagementHome']);

    Route::get('/management/edit',[ManagementController::class,'showManagementEdit'])->name('management.edit');

    Route::post('/management/edit',[ManagementController::class,'storeRestaurant'])->name('management-edit');

    // Route::get('/management/success',[ManagementController::class,'showManagementSuccess']);

    Route::get('/management/update/{id}',[ManagementController::class,'showManagementUpdate'])->name('management.restaurants');

    Route::get('/management/reservations',[ManagementController::class,'showManagementReservations']);

// 店舗の編集ルート
Route::patch('/management/edit/{id}', [ManagementController::class, 'updateRestaurant'])->name('management.update');

});




