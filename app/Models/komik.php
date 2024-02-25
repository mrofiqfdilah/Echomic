<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\gambar_komik;

class Komik extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'judul_komik', 'tgl_rilis', 'genre' ,'sinopsis','cover_komik'];
    protected $table = 'komik';

    // Define the One-to-Many relationship with Volume
    public function volumes()
    {
        return $this->hasMany(Volume::class);
    }

    // Define the One-to-Many relationship with GambarKomik
    public function gambarKomik()
    {
        return $this->hasMany(gambar_komik::class);
    }

  

    // Define the relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
}

