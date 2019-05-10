<?php

Route::get('login', 'Auth\LoginController@redirectToProvider')->name('login');
Route::get('callback', 'Auth\LoginController@handleProviderCallback');
Route::get('logout', 'Auth\LoginController@logout');

Route::get('/', 'HomeController@index')->name('home');

Route::get('certificado_conclusao', 'CertificadoConclusaoController@index')->name('certificado_conclusao.index');
Route::post('certificado_conclusao', 'CertificadoConclusaoController@show')->name('certificado_conclusao.show');