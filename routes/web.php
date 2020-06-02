<?php

Route::get('login', 'Auth\LoginController@redirectToProvider')->name('login');
Route::get('callback', 'Auth\LoginController@handleProviderCallback');
Route::get('logout', 'Auth\LoginController@logout');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin/certificado_conclusao')->middleware('can:admin')->group(function () {
    Route::get('/', 'CertificadoConclusaoController@index')->name('certificado_conclusao.index');
    Route::post('/', 'CertificadoConclusaoController@show')->name('certificado_conclusao.show');
    Route::post('/pdf', 'CertificadoConclusaoController@showPDF')->name('certificado_conclusao.showPDF');
});

Route::prefix('admin/formularios')->middleware('can:admin')->group(function () {
    Route::get('solicitacao_documentos', 'Admin\SolicitacaoDocumentoController@index')->name('admin.formularios.documentos.index');
    Route::get('solicitacao_documentos/index', 'Admin\SolicitacaoDocumentoController@index')->name('admin.formularios.documentos.index');
    Route::get('solicitacao_documentos/{id}/edit', 'Admin\SolicitacaoDocumentoController@edit')->name('admin.formularios.documentos.edit');
    Route::post('solicitacao_documentos/{id}', 'Admin\SolicitacaoDocumentoController@update')->name('admin.formularios.documentos.update');
    Route::get('resposta_template/create/{formulario_id}', 'Admin\RespostaTemplateController@create')->name('admin.formularios.respostas.create');
    Route::post('resposta_template/store', 'Admin\RespostaTemplateController@store')->name('admin.formularios.respostas.store');
});

Route::prefix('admin/perfil_aluno')->middleware('can:admin')->group(function () {
    Route::get('/', 'FuncionarioPerfilAlunoController@index')->name('admin.perfil_aluno.index');
    Route::post('/', 'FuncionarioPerfilAlunoController@store')->name('admin.perfil_aluno.store');
});


Route::prefix('aluno/solicitacao_documentos')->group(function () {
    Route::get('create', 'Aluno\AlunoSolicitacaoDocumentoController@create')->name('aluno.solicitacao_documentos.create');
    Route::post('/', 'Aluno\AlunoSolicitacaoDocumentoController@store')->name('aluno.solicitacao_documentos.store');
});
