<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bilhete extends Model
{
    protected $fillable = ['recibo_id', 'cliente_id', 'sessao_id', 'lugar_id', 'preco_sem_iva', 'estado'];

    public function recibo(): BelongsTo {
        return $this->belongsTo(Recibo::class);
    }

    public function cliente(): BelongsTo {
        return $this->belongsTo(Cliente::class);
    }

    public function sessao(): BelongsTo
    {
        return $this->belongsTo(Sessoes::class);
    }

    public function lugar(): BelongsTo
    {
        return $this->belongsTo(Lugares::class);
    }
}
