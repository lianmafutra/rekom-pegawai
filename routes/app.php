<?php


use Illuminate\Support\Facades\Route;


Route::get('testing/', function () {
   return view('welcome');
})->name('index');