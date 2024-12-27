<?php

use App\Core\Route;

Route::get('api/tickets', 'TicketController@index');
Route::post('api/tickets', 'TicketController@store');
Route::put('api/tickets/{id}', 'TicketController@update');
Route::delete('api/tickets/{id}', 'TicketController@delete');