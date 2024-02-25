<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class gambar_komik extends Model
{
    use HasFactory;
    protected $fillable = ['komik_id','volume_id','judul_gambar'];
    protected $table = 'gambar_komik';

    // Relationship with the Komik model
    public function komik()
    {
        return $this->belongsTo(Komik::class);
    }

    // Relationship with the Volume model
    public function volume()
    {
        return $this->belongsTo(Volume::class);
    }
}
