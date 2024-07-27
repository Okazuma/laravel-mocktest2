<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Reservation;
use App\Http\Requests\ManagementRequest;
use Illuminate\Support\Facades\Storage;

class ManagementController extends Controller
{
    public function showManagementHome()
    {
        return view('management.management-home');
    }



    public function showManagementEdit()
    {
        $restaurants = Restaurant::all();

        return view('management.management-edit',compact('restaurants'));
    }

    public function storeRestaurant(ManagementRequest $request)
    {
        $imagePath = $request->file('image')->store('public/images');
        $imagePath = str_replace('public/', 'storage/', $imagePath);

        $restaurant = Restaurant::create([
            'name' => $request->name,
            'description' => $request->description,
            'area' => $request->area,
            'genre' => $request->genre,
            'image_path' => $imagePath,
        ]);
        return redirect()->route('management-edit')->with('message','店舗が追加されました');
    }



    public function showManagementUpdate($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        return view('management.management-update', compact('restaurant'));
    }



    public function updateRestaurant(Request $request, $id)
    {
        
        $restaurant = Restaurant::findOrFail($id);

    // 更新するデータを取得
    $data = $request->only(['name', 'description', 'area', 'genre']);

    // 店舗情報の更新
    $restaurant->update($data);

    // 更新成功後のリダイレクト
    return redirect()->route('management.edit', ['id' => $id])
                     ->with('success', '店舗情報が更新されました。');
    }


    public function showManagementReservations()
    {
        // $reservations = Reservation::all();
        $reservations = Reservation::with('user')->get();
        return view('management.management-reservations',compact('reservations'));
    }
}
