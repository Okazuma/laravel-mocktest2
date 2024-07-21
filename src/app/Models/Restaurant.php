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
}
