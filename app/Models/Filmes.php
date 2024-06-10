<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Filmes extends Model
{
    protected $fillable = ['titulo', 'genero_code', 'ano'];

    protected function fullCartazUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->cartaz_url ? asset('storage/cartazes/' . $this->cartaz_url) : asset('/img/avatar_unknown.png');
            },
        );
    }
    public function genero()
    {
        return $this->belongsTo(Genero::class, 'genero_code', 'code');
    }
}
