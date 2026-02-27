<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    protected $table = 'mejas';

    protected $fillable = [
        'nomor_meja', 'status', 'kapasitas'
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_meja');
    }
}
