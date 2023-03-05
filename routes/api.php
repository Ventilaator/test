<?php

use App\Http\Controllers\StopController;
use Illuminate\Support\Facades\Route;

Route::get('stops/{stop?}', [StopController::class, 'stops'])->name('api.stops');
