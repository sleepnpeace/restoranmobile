<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';

    protected $fillable = ['nama'];

    public function menu()
    {
        return $this->hasMany(Menu::class, 'id_kategori');
    }
}
