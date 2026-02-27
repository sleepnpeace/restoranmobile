<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    protected $fillable = [
        'nama', 'harga', 'id_kategori', 'status', 'stok', 'gambar', 'deskripsi'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

     public function getHargaFormatAttribute()
    {
        return 'Rp ' . number_format($this->harga, 2, ',', '.');
    }
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_menu');
    }

    public function updateStok()
    {
        return $this->hasMany(UpdateStokHarian::class, 'id_menu');
    }
}

