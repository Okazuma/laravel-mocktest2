<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ImportCsvRequest;

class RestaurantController extends Controller
{
    // 飲食店一覧ページの表示ーーーーーーーーーー
    public function index()
    {
        $restaurants = Restaurant::all();

        return view('index',compact('restaurants'));
    }



    // ログインユーザーメニューの表示ーーーーーーーーーー
    public function menuUser()
    {
        return view('user-menu');
    }



    // ゲストユーザーメニューの表示ーーーーーーーーーー
    public function menuGuest()
    {
        return view('guest-menu');
    }



    // 検索フォームの処理ーーーーーーーーーー
    public function search(Request $request)
    {
        $query = Restaurant::query();

            if ($request->filled('area')) {
                $query->where('area', $request->input('area'));
            }
            if ($request->filled('genre')) {
                $query->where('genre', $request->input('genre'));
            }
            if ($request->filled('keyword')) {
                $keyword = $request->input('keyword');
                $query->where('name', 'like', '%' . $keyword . '%');
            }
        $restaurants = $query->get();

        return view('index', compact('restaurants'));
    }



    // 飲食店詳細ページの表示ーーーーーーーーーー
    public function detail(Request $request)
    {
        $shop_id = $request->route('shop_id');
        $restaurant = Restaurant::findOrFail($shop_id);
        $userId = Auth::id();
        $userReview = null;  // 未ログインユーザーに対しては null を設定
        // ユーザーの口コミを取得
        if ($userId) {
        $userReview = Review::where('restaurant_id', $shop_id)
                            ->where('user_id', $userId)
                            ->first();
        }

        return view('restaurant-detail', compact('restaurant','userReview'));
    }



    // いいね機能の処理ーーーーーーーーーー
    public function like(Restaurant $restaurant)
    {
        $user = Auth::user();
        if ($user->likedRestaurants->contains($restaurant->id)) {
            $user->likedRestaurants()->detach($restaurant->id);
            $liked = false;
        } else {
            $user->likedRestaurants()->attach($restaurant->id);
            $liked = true;
        }
        return response()->json(['success' => true, 'liked' => $liked]);
    }



    // ソート機能の処理ーーーーーーーーーー
    public function sort(Request $request)
    {
        $sortOrder = $request->input('sort', 'desc');
        $query = Restaurant::with('reviews');

        if ($sortOrder === 'random') {
            $query->inRandomOrder();
        } else {
            $query->withAvg('reviews', 'rating')
                ->orderBy('reviews_avg_rating', $sortOrder);
        }

        $restaurants = $query->get();

        return view('index', compact('restaurants'));
    }






    // CSVインポート処理ーーーーーーーーーー
    public function import(ImportCsvRequest $request)
    {

        // ユーザーに 'create_store' 権限があるかチェック
            if (!auth()->user()->can('import_store')) {
                return redirect()->back()->withErrors(['permission' => '店舗を追加する権限がありません。']);
            }

        // CSVファイルを開く
        if (($handle = fopen($request->file('csv_file')->getRealPath(), 'r')) !== FALSE) {
            // 1行目（ヘッダー）をスキップ
            fgetcsv($handle);

            // エラーがあった場合のためにフラグを追加
            $errors = [];

            // ファイルの各行を読み込んで処理
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $imagePath = $row[4]; // 5番目のカラムが画像パスだと仮定
                $extension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION)); // 拡張子を取得

                // JPEGまたはPNGかどうかを確認
                if (!in_array($extension, ['jpeg', 'jpg', 'png'])) {
                    $errors[] = "画像 {$imagePath} はjpegまたはpng形式のみアップロード可能です。";
                    continue; // この行の処理をスキップ
                }

                // 画像パスが実際に存在するかも確認する (任意)
                if (!file_exists(public_path($imagePath))) {
                    $errors[] = "画像 {$imagePath} が見つかりません。";
                    continue;
                }

                // エラーがなければCSVの各行をデータベースに保存
                Restaurant::create([
                    'name' => $row[0],
                    'description' => $row[1],
                    'area' => $row[2],
                    'genre' => $row[3],
                    'image_path' => $imagePath,
                ]);
            }

            fclose($handle);

            // エラーがあった場合は、エラーメッセージを表示してリダイレクト
            if (count($errors) > 0) {
                return redirect()->back()->withErrors(['csv_file' => $errors]);
            }
        }

        return redirect()->route('restaurants.index')->with('success', '飲食店情報をインポートしました。');
    }
}
