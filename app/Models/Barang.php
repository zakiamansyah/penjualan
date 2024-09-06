<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
