<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sala extends Model
{
    public function sessoes()
    {
        return $this->hasMany(Sessao::class, 'sala_id');
    }
}