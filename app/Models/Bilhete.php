<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bilhete extends Model
{
    protected $fillable = ['sessao_id', 'lugar_id', 'estado'];

    public function sessao()
    {
        return $this->belongsTo(Sessoes::class);
    }

    public function lugar()
    {
        return $this->belongsTo(Lugares::class);
    }
}
