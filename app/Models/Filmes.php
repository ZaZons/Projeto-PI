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

    protected $table = 'filmes';
    public function genero()
    {
        return $this->belongsTo(Genero::class, 'genero_code', 'code');
    }

    public function sessoes()
    {
        return $this->hasMany(Sessoes::class, 'filme_id');
    }

    public function bilhetes()
    {
        return $this->hasManyThrough(Bilhete::class, Sessoes::class);
    }
}
