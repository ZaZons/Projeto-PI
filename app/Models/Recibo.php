<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recibo extends Model
{
    use HasFactory;

    protected $fillable = ['cliente_id', 'data', 'preco_total_sem_iva', 'iva', 'preco_total_com_iva', 'nif', 'nome_cliente',
        'tipo_pagamento', 'ref_pagamento', 'recibo_pdf_url'];

    public function cliente(): BelongsTo {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
