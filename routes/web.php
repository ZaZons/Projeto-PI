<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\exibicao;

Route::get(
    '/exibicao',
    [exibicao::class, 'exibicao']
);
