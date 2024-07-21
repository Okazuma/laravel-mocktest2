<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Auth;
use App\models\User;
use App\Http\Middleware\VerifyEmail;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Log;
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

// 飲食店一覧ページ(HOME)表示のルートーーーーーーーーーー
Route::get('/',[RestaurantController::class,'index'])->name('restaurants.index');


// menu1ページ表示のルートーーーーーーーーーー
Route::get('/menu1',[RestaurantController::class,'menu1'])->name('restaurants.menu1');

// menu2ページ表示のルートーーーーーーーーーー
Route::get('/menu2',[RestaurantController::class,'menu2'])->name('restaurants.menu2');

// 飲食店一覧ページで検索結果を表示するルート
Route::get('/restaurants.search',[RestaurantController::class,'search'])->name('restaurants.search');

// イイネボタンの処理をするルート
Route::post('/restaurants/{restaurant}/like', [RestaurantController::class, 'like'])->middleware(['auth'])->name('restaurants.like');




// 飲食店詳細を表示するルート
Route::get('/detail/{shop_id}', [RestaurantController::class,'detail'])->name('restaurants.detail');

// 飲食店詳細ページで予約を作成するルート
Route::post('/restaurants/{restaurant}/reserve', [ReservationController::class, 'store'])
    ->middleware(['auth','VerifyEmail']) // authミドルウェアを適用
    ->name('restaurants.reservation');

// 飲食店詳細ページで予約完了後にdoneページの表示のルート
Route::get('/done', function () {
    return view('done');
})->name('done');




// マイページの表示ルート
Route::middleware(['auth'])->group(function () {
    Route::get('/mypage', [ReservationController::class, 'mypage'])->name('mypage');
    Route::get('/mypage/reservations', [ReservationController::class, 'myReservations'])->name('mypage.reservations');
});

// マイページに予約情報を表示するルート
Route::get('/mypage/reservations', [ReservationController::class, 'myReservations'])->name('mypage.reservations');

// マイページで予約情報を削除するルート
Route::delete('/delete/{id}',[ReservationController::class,'destroy']);

// マイページで予約情報の詳細を表示するルート
Route::get('/reservation-edit/{id}',[ReservationController::class,'edit'])->name('reservation-edit');

// マイページから予約情報の詳細を表示して予約情報を更新するルート
Route::post('/mypage',[ReservationController::class,'update'])->name('reservation-update');





// ーーーーー会員登録処理ルートーーーーー

// 会員登録ページ表示のルート
Route::get('/register',[RegisterController::class,'showRegisterForm']);

// 会員登録処理のルート
Route::post('/register', [RegisterController::class, 'register']);



// ーーーーー認証機能処理ルートーーーーー

// ログインページ表示のルート
Route::get('/login',[AuthController::class,'showLoginForm'])->name('login');

// ログイン処理のルート
Route::post('/login',[AuthController::class,'login']);

// ログアウト処理のルート
Route::post('/', [AuthController::class, 'logout'])->name('logout');




// メール認証を行うルート
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


// メール認証を行うルートーーーーーーーーーー
Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::findOrFail($id);
    $user->markEmailAsVerified();
        return view('thanks');
})->middleware(['signed'])->name('verification.verify');


// 認証要求ページを表示するルートーーーーーーーーーー
// Route::get('/verify-email', [RegisterController::class, 'show'])
//     ->middleware('auth')
//     ->name('verification.notice');



// 認証メールの再送信ルートーーーーーーーーーーフォームから送信されたデータを処理し、入力されたメールアドレスに対して認証メールを再送信
// Route::post('/verify-email/resend', function (Request $request) {
//     $email = $request->input('email'); // フォームからのemailデータを取得
//     $user = User::where('email', $email)->first();
//     // ユーザーが存在しない場合はエラーメッセージを返す
//         if (!$user) {
//             return back()->withErrors(['email' => '登録ユーザーが見つかりませんでした。']);
//         }
//         if ($user->hasVerifiedEmail()) {
//         return back()->withErrors(['email' => 'このメールアドレスは既に認証されています。']);
//     }
//     // 再送信処理を行う
//     $user->sendEmailVerificationNotification();
//         return back()->with('message', 'Verification link sent!');
// })->name('verification.resend');




// 再送信処理のルート
Route::post('/email/verify/resend', function (Request $request) {
    $user = Auth::user(); // 認証されたユーザーを取得
        if (!$user) {
            return redirect()->route('login')->withErrors(['message' => '再送信するにはログインが必要です。']);
        }
        if ($user->hasVerifiedEmail()) {
            return back()->withErrors(['message' => 'このメールアドレスは既に認証されています。']);
        }
    // 認証メールの再送信
    $user->sendEmailVerificationNotification();
        return back()->with('message', '認証リンクを再送しました。');
})->middleware('auth')->name('verification.resend');



// 認証メールの再送信ルートーーーーーーーーーーユーザーがリンクをクリックすることで、認証メールを再送信
// Route::get('/verify-email/resend', [RegisterController::class, 'resendVerificationEmail'])
//     ->name('verification.resend');