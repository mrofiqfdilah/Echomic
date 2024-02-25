<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simpankomik extends Model
{
    use HasFactory;

    protected $table = 'penyimpanan_komik';

    protected $fillable = ['user_id', 'komik_id', 'volume_id'];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the Komik model
    public function komik()
    {
        return $this->belongsTo(Komik::class);
    }

    // Define the relationship with the Volume model
    public function volume()
    {
        return $this->belongsTo(Volume::class);
    }
}
