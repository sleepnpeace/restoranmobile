<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksis';

    protected $fillable = [
        'nama_konsumen', 'total_bayar', 'tanggal',
        'status', 'id_user', 'id_meja'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function meja()
    {
        return $this->belongsTo(Meja::class, 'id_meja');
    }

    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
}
