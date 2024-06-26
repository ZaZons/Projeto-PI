<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['id', 'nif', 'tipo_pagamento', 'ref_pagamento'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
