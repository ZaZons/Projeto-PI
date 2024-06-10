<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    public function filmes()
    {
        return $this->hasMany(Filmes::class, 'genero_code', 'code');
    }
}
