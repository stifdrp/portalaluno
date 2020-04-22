<?php

Route::get('login', 'Auth\LoginController@redirectToProvider')->name('login');
Route::get('callback', 'Auth\LoginController@handleProviderCallback');
Route::get('logout', 'Auth\LoginController@logout');

Route::get('/', 'HomeController@index')->name('home');

Route::get('certificado_conclusao', 'CertificadoConclusaoController@index')->name('certificado_conclusao.index');
Route::post('certificado_conclusao', 'CertificadoConclusaoController@show')->name('certificado_conclusao.show');
Route::post('certificado_conclusao/pdf', 'CertificadoConclusaoController@showPDF')->name('certificado_conclusao.showPDF');

Route::prefix('admin')->group(function () {
    Route::get('formularios/solicitacao_documentos', 'Admin\SolicitacaoDocumentoController@index')->name('admin.formularios.documentos');
    Route::post('formularios/solicitacao_documentos', 'Admin\SolicitacaoDocumentoController@store')->name('admin.formularios.documentos.store');
});
