<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Restaurant;
use App\Http\Requests\AdminRequest;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use App\Http\Requests\ImportCsvRequest;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }



    public function showAdminHome()
    {
        return view('admin.admin-home');
    }



    // 管理者ページの表示ーーーーーーーーーー
    public function showCreateManager()
    {
        $restaurants = Restaurant::all();

        return view('admin.create-manager',compact('restaurants'));
    }



    // 店舗代表者作成の処理ーーーーーーーーーー
    public function storeRestaurantManager(AdminRequest $request)
    {
        $storeManagerRole = Role::where('name','store_manager')->first();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => Carbon::now(),
        ]);
        $user -> assignRole('store_manager');

        return redirect()->route('admin.create-manager')->with('message','managerを作成しました');
    }



    // 管理者ページの表示ーーーーーーーーーー
    public function showAdminImport()
    {
        return view('admin.import-csv');
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
                if (!in_array($extension, ['jpeg', 'png'])) {
                    $errors[] = "image_pathはjpeg,png形式のみアップロード可能です。";
                    // "画像 {$imagePath} はjpegまたはpng形式のみアップロード可能です。"
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

        return redirect()->route('admin.import-csv')->with('success', '飲食店情報をインポートしました。');
    }

}