<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','description','area','genre','image_path',
    ];

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function managers()
    {
        return $this->belongsToMany(User::class,'restaurant_user','restaurant_id','user_id');
    }
}
