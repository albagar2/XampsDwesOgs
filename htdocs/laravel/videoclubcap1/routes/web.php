<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {

    Route::get('/catalog', function (){
        return view('catalog.index');
    })->name('catalog');



    Route::get('/catalog/show/{id}', function ($id) {
        return view('catalog.show', ['id' =>$id]);
    })->name('show');



    Route::get('/catalog/create', function (){
        return view('catalog.create');
    })->name('create');



    Route::get('/catalog/edit/{id}', function ($id){
        return view('catalog.edit',['id' => $id]);
    })->name('edit');


});

Route::view('/catalog', 'catalog')
    ->middleware(['auth', 'verified'])
    ->name('/catalog');




    require __DIR__.'/settings.php';
