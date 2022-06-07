<?php

use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\ConnectionInCommonController;
use App\Http\Controllers\ConnectionRequestController;
use App\Http\Controllers\ReceivedRequestController;
use App\Http\Controllers\SentRequestController;
use App\Http\Controllers\SuggestionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Network Connection Routes
|--------------------------------------------------------------------------
*/


Route::get('/suggestions/{lastId}/{takeAmount}', [SuggestionController::class, 'index'])->name('suggestions');
Route::get('/sent_requests/{lastId}/{takeAmount}', [SentRequestController::class, 'index'])->name('sent_requests');
Route::get('/received_requests/{lastId}/{takeAmount}', [ReceivedRequestController::class, 'index'])->name('received_requests');
Route::get('/connections/{lastId}/{takeAmount}', [ConnectionController::class, 'index'])->name('connections');
Route::get('/connections_in_common/{lastId}/{takeAmount}/{suggestionId}', [ConnectionInCommonController::class, 'index'])->name('connections');

Route::post('/connection_request/store', [ConnectionRequestController::class, 'store'])->name('connection_request.store');
Route::post('/connection_request/update', [ConnectionRequestController::class, 'update'])->name('connection_request.update');
Route::post('/connection_request/destroy', [ConnectionRequestController::class, 'destroy'])->name('connection_request.destroy');
Route::post('/connection/destroy', [ConnectionController::class, 'destroy'])->name('connection.destroy');
