<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Restaurant;
use App\Http\Requests\AdminRequest;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use App\Http\Requests\UploadImagesRequest;
use App\Http\Requests\ImportCsvRequest;
use Illuminate\Support\Facades\Storage;

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
        if (!auth()->user()->can('import_store')) {
            return redirect()->back()->withErrors(['permission' => '店舗を追加する権限がありません。']);
        }
        if (($handle = fopen($request->file('csv_file')->getRealPath(), 'r')) !== FALSE) {
            fgetcsv($handle);
            $errors = [];

            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $rowErrors = [];
                // 店舗名バリデーション（50文字以内）
                if (empty($row[0]) || mb_strlen($row[0]) > 50) {
                    $rowErrors[] = "・店舗名は50文字以内で入力してください。<br>（行: " . implode(", ", $row) . "）";
                }
                // 店舗概要バリデーション（４００文字以内）
                if (empty($row[1]) || mb_strlen($row[1]) > 400) {
                    $rowErrors[] = "・店舗概要は400文字以内で入力してください。<br>（行: " . implode(", ", $row) . "）";
                }
                // 地域バリデーション（「東京都」「大阪府」「福岡県」）
                $validAreas = ['東京都', '大阪府', '福岡県'];
                if (empty($row[2]) || !in_array($row[2], $validAreas)) {
                    $rowErrors[] = "・地域は「東京都」「大阪府」「福岡県」から指定してください。<br>（行: " . implode(", ", $row) . "）";
                }
                // ジャンルバリデーション（「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」）
                $validGenres = ['寿司', '焼肉', 'イタリアン', '居酒屋', 'ラーメン'];
                if (empty($row[3]) || !in_array($row[3], $validGenres)) {
                    $rowErrors[] = "・ジャンルは「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」から指定してください。<br>（行: " . implode(", ", $row) . "）";
                }
                // 画像パスバリデーション
                $imagePath = $row[4];
                $extension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
                if (!in_array($extension, ['jpeg', 'png','jpg'])) {
                    $rowErrors[] = "・image_pathはjpeg,png形式のみアップロード可能です。";
                }
                // 画像パスが実際に存在するかどうか
                if (!file_exists(public_path($imagePath))) {
                    $rowErrors[] = "・画像 {$imagePath} が見つかりません。<br>（行: " . implode(", ", $row) . "）";
                }
                // エラーがある場合、その行の保存をスキップ
                if (count($rowErrors) > 0) {
                    $errors = array_merge($errors, $rowErrors);
                    continue;
                }

                Restaurant::create([
                    'name' => $row[0],
                    'description' => $row[1],
                    'area' => $row[2],
                    'genre' => $row[3],
                    'image_path' => $imagePath,
                ]);
            }
            fclose($handle);

            if (count($errors) > 0) {
                return redirect()->back()->withErrors(['csv_import' => $errors]);
            }
        }
        return redirect()->route('admin.import-csv')->with('success', '飲食店情報をインポートしました。');
    }




    // 画像アップロードの処理ーーーーーーーーーー
    public function uploadImages(UploadImagesRequest $request)
    {
        $disk = config('filesystems.default');

        if ($request->hasFile('images')) {
            try {
                foreach ($request->file('images') as $file) {
                    $originalName = $file->getClientOriginalName();

                    if (Storage::disk($disk)->exists('images/' . $originalName)) {
                        return redirect()->back()->withErrors(['images' => "$originalName はすでに存在します。\nファイル名を変更してください。"]);
                    }
                    $file->storeAs('images', $originalName, $disk);
                }

                return redirect()->back()->with('success', '画像がアップロードされました');
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['images' => '画像のアップロード中にエラーが発生しました。もう一度お試しください。']);
            }
        } else {
            return redirect()->back()->withErrors(['images' => '画像を選択してください。']);
        }
    }

}