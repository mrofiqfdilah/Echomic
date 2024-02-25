<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volume extends Model
{
    use HasFactory;

    protected $fillable = ['komik_id', 'judul_volume', 'jumlah_halaman'];
    protected $table = 'volume';

    // belongsto artinya dimiliki oleh komik
    public function komik()
    {
        return $this->belongsTo(Komik::class);
    }

    // Satu volume bisa memiliki banyak gambarKomik
    public function gambarKomik()
    {
        return $this->hasMany(gambar_komik::class);
    }

    public function simpankomiks()
    {
        return $this->hasMany(Simpankomik::class);
    }
}

