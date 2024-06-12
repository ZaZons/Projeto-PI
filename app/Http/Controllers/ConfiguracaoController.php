<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use Illuminate\Http\Request;

class ConfiguracaoController extends Controller
{
    public static function config() {
        $config = Configuracao::query()->limit(1)->first();
        return $config;
    }
}
