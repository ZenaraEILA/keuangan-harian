<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;

Route::get('/transaksi',[TransaksiController::class,'index']);
Route::get('/transaksi/create',[TransaksiController::class,'create']);
Route::post('/transaksi',[TransaksiController::class,'store']);
Route::get('/transaksi/edit/{id}',[TransaksiController::class,'edit']);
Route::post('/transaksi/update/{id}',[TransaksiController::class,'update']);
Route::get('/transaksi/delete/{id}',[TransaksiController::class,'destroy']);
Route::post('/transaksi/bulk-delete',[TransaksiController::class,'bulkDelete']);