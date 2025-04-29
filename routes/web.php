<?php

use App\Http\Controllers\QuestionnaireController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
