<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductManageController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', function () {
    return view('login');
});

Route::get('/admin/productos', [ProductManageController::class, 'index'])->name('productos.index');
Route::get('/admin/subir-producto', [ProductManageController::class, 'newproduct'])->name('crear.producto');
Route::post('/subir-producto', [ProductManageController::class, 'store'])->name('subir.producto');

Route::get('/productos/{id}/edit', [ProductManageController::class, 'edit'])->name('productos.edit');
Route::put('/productos/{id}', [ProductManageController::class, 'update'])->name('productos.update');

Route::get('/admin/productos/{id}/show', [ProductManageController::class, 'show'])->name('productos.show');

Route::delete('/admin/productos/{id}', [ProductManageController::class, 'destroy'])->name('productos.destroy');



