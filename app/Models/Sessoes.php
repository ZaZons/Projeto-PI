<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessoes extends Model
{
    protected $fillable = ['filme_id', 'sala_id', 'data', 'horario_inicio'];

    public function filme()
    {
        return $this->belongsTo(Filmes::class);
    }

    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }

    public function bilhetes()
    {
        return $this->hasMany(Bilhete::class);
    }

    protected function lugaresDisponiveis(): Attribute
    {
        return Attribute::make(
            get: function () {
                $nLugares = Lugares::where('sala_id', $this->sala_id)->count();
                $lugaresUsados = Bilhete::where('sessao_id', $this->id)->count();

                return $nLugares - $lugaresUsados;
            },
        );
    }
}
