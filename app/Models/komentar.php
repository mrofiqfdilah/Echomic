<?php

// app/Models/Komentar.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'komik_id',
        'volume_id',
        'rating',
        'komentar',
    ];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan model Komik
    public function komik()
    {
        return $this->belongsTo(Komik::class);
    }

    // Relasi dengan model Volume
    public function volume()
    {
        return $this->belongsTo(Volume::class);
    }
}
