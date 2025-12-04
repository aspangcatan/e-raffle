<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\RaffleController;

Route::get('/', [RaffleController::class, 'showEntries'])->name('raffle.entries');
Route::post('/import', [RaffleController::class, 'importCsv'])->name('raffle.import');
Route::get('/draw', [RaffleController::class, 'draw'])->name('raffle.draw');

Route::delete('/draw/winner', [RaffleController::class, 'deleteWinner'])->name('raffle.deleteWinner');
Route::post('/entries/clear', [RaffleController::class, 'clearEntries'])->name('raffle.entries.clear');
Route::delete('/entries/{id}', [RaffleController::class, 'deleteEntry'])->name('raffle.entries.delete');

Route::get('/raffle/winner/{id}', [RaffleController::class,'drawWinner']);
Route::get('/raffle/pick-random-winner', [RaffleController::class, 'pickRandomWinner'])->name('pickRandomWinner');
