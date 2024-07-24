<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Reservation;
use App\Http\Requests\ManagementRequest;

class ManagementController extends Controller
{
    public function showManagementHome()
    {
        return view('management.management-home');
    }



    public function showManagementEdit()
    {
        return view('management.management-edit');
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
        return redirect()->route('management.success');

    }

    public function showManagementSuccess(Request $request)
    {
        return view('management.management-success');
    }

    public function update(ManagementRequest $request)
    {

    }

    public function showManagementReservations()
    {
        $reservations = Reservation::all();
        return view('management.management-reservations',compact('reservations'));
    }

    
}
