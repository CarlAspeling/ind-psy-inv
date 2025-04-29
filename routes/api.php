<?php

use App\Http\Controllers\QuestionnaireController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('questionnaire', [QuestionnaireController::class, 'show']);
