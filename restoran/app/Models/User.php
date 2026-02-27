<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Pesanan;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'modify_users';

    protected $fillable = [
            'username', 'email', 'password', 'role', 'status', 'id_karyawan'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

      public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_user');
    }

}
