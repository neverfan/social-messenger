<?php

use App\Http\Controllers\DialogController;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => '/dialog',
    'controller' => DialogController::class,
    'as' => 'dialog',
    'middleware' => 'auth'
], static function () {

    //Список диалогов пользователя
    Route::get('/', 'list')->name('.list');

    //Создать диалог
    Route::post('/', 'create')->name('.create');

    //Получить сообщения диалога
    Route::get('/{dialog}', 'get')->name('.get');

    //Отправить сообщение в диалог
    Route::post('/{dialog}/send', 'send')->name('.send');
});









