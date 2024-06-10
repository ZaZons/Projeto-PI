<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessoes extends Model
{
    protected $dates = ['filme_id', 'sala_id', 'data', 'horario_inicio'];

    public function filme()
    {
        return $this->belongsTo(Filmes::class, 'filme_id');
    }

    public function sala()
    {
        return $this->belongsTo(Sala::class, 'sala_id');
    }

    public function lugaresDisponiveis()
    {
        // Se você não tiver um modelo Lugar, ajuste esta relação de acordo com a estrutura do seu banco de dados
        return $this->hasMany(Lugares::class, 'sala_id', 'sala_id');
    }
}
