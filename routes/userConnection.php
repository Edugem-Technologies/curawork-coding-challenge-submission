<?php

use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\ConnectionInCommonController;
use App\Http\Controllers\ConnectionRequestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReceivedRequestController;
use App\Http\Controllers\SentRequestController;
use App\Http\Controllers\SuggestionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Network Connection Routes
|--------------------------------------------------------------------------
*/


Route::get('/suggestions/{lastId}/{limit}', [SuggestionController::class, 'index'])->name('suggestions');
Route::get('/sent-requests/{lastId}/{limit}', [SentRequestController::class, 'index'])->name('sent-requests');
Route::get('/received-requests/{lastId}/{limit}', [ReceivedRequestController::class, 'index'])->name('received-requests');
Route::get('/connections/{lastId}/{limit}', [ConnectionController::class, 'index'])->name('connections');
Route::get('/connections-in-common/{lastId}/{limit}/{suggestionId}', [ConnectionInCommonController::class, 'index'])->name('connections');
Route::get('/navigation-counts', [HomeController::class, 'show'])->name('connections');

Route::post('/connection-request/store', [ConnectionRequestController::class, 'store'])->name('connection-request.store');
Route::post('/connection-request/update', [ConnectionRequestController::class, 'update'])->name('connection-request.update');
Route::post('/connection-request/destroy', [ConnectionRequestController::class, 'destroy'])->name('connection-request.destroy');
Route::post('/connection/destroy', [ConnectionController::class, 'destroy'])->name('connection.destroy');
