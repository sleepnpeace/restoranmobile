<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawans';

    protected $fillable = [
        'nama', 'notelp', 'alamat', 'jenkel', 'jabatan'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id_karyawan');
    }
}
