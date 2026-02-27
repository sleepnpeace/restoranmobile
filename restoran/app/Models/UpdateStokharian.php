<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UpdateStokharian extends Model
{
    protected $table = 'update_stokharians';
    protected $fillable = ['id_menu','jumlah_porsi','tanggal_update'];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }
}


