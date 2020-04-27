<?php

Route::get('login', 'Auth\LoginController@redirectToProvider')->name('login');
Route::get('callback', 'Auth\LoginController@handleProviderCallback');
Route::get('logout', 'Auth\LoginController@logout');

Route::get('/', 'HomeController@index')->name('home');

Route::get('certificado_conclusao', 'CertificadoConclusaoController@index')->name('certificado_conclusao.index');
Route::post('certificado_conclusao', 'CertificadoConclusaoController@show')->name('certificado_conclusao.show');
Route::post('certificado_conclusao/pdf', 'CertificadoConclusaoController@showPDF')->name('certificado_conclusao.showPDF');

Route::prefix('admin')->group(function () {
    Route::get('formularios/solicitacao_documentos', 'Admin\SolicitacaoDocumentoController@index')->name('admin.formularios.documentos.index');
    Route::get('formularios/solicitacao_documentos/index', 'Admin\SolicitacaoDocumentoController@index')->name('admin.formularios.documentos.index');
    Route::get('formularios/solicitacao_documentos/{id}/edit', 'Admin\SolicitacaoDocumentoController@edit')->name('admin.formularios.documentos.edit');
    Route::post('formularios/solicitacao_documentos/{id}', 'Admin\SolicitacaoDocumentoController@update')->name('admin.formularios.documentos.update');
});
