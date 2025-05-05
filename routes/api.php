<?php

use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\ResponseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/questionnaire', [QuestionnaireController::class, 'show']);

Route::post('/save-response', [ResponseController::class, 'store']);
