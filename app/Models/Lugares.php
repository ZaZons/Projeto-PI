<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lugares extends Model
{
    use HasFactory;

    // Campos do modelo Lugar
    protected $fillable = ['sessao_id', 'estado'];

    // Relacionamento com a sessão
    public function sessao()
    {
        return $this->belongsTo(Sessoes::class, 'sala_id','sala_id');
    }
    public function bilhetes()
    {
        return $this->hasMany(Bilhete::class);
    }
}
