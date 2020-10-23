<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

*/

Auth::routes();

/** Rotas Públicas */
Route::get('/', 'InscricaoController@index')->name('pagina_inicial');

Route::get('/admin/login', 'Auth\AdminLoginController@index')->name('admin.login');
Route::post('/admin/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');

Route::get('/inscricao/{curso}', 'InscricaoController@inscricao');
Route::get('/inscricao/formulario/{slug}', 'InscricaoController@create');
Route::post('/pagamento', 'InscricaoController@payment')->name('inscricaoPayment');
Route::post('/checkCadastro', 'InscricaoController@checkCadastro')->name('temCadastro');


Route::post('/inscricao/pagamento', 'InscricaoController@store')->name('inscricao_pagamento');
Route::get('/hash', 'InscricaoController@generateHash');
Route::get('/confirmacao', 'InscricaoController@confirmacao')->name('pagina_confirmacao');

/* Rotas Admin */

Route::get('/admin', 'AdminController@index')->name('admin.dashboard')->middleware('autenticadorAdmin');
Route::get('/admin/cursos', 'CursosController@index')->name('listar_cursos')->middleware('autenticadorAdmin');
Route::get('/admin/cursos/criar', 'CursosController@create')->name('criar_curso')->middleware('autenticadorAdmin');
Route::get('/admin/cursos/{id}/editar', 'CursosController@edit')->middleware('autenticadorAdmin');
Route::post('/admin/cursos/{id}/editar', 'CursosController@update')->middleware('autenticadorAdmin');
Route::post('/admin/cursos/criar', 'CursosController@store')->middleware('autenticadorAdmin');
Route::delete('/admin/cursos/{id}/desativar', 'CursosController@destroy')->middleware('autenticadorAdmin');
Route::get('/admin/redacao-temas', 'RedacaoController@index')->name('listar_redacoes')->middleware('autenticadorAdmin');
Route::get('/admin/redacao-temas/{id}/editar', 'RedacaoController@edit')->middleware('autenticadorAdmin');
Route::post('/admin/redacao-temas/{id}/editar', 'RedacaoController@update')->name('visualizar_redacao')->middleware('autenticadorAdmin');
Route::delete('/admin/redacao-temas/{id}/desativar', 'RedacaoController@destroy')->middleware('autenticadorAdmin');
Route::get('/admin/redacao-temas-criar', 'RedacaoController@create')->name('criar_tema')->middleware('autenticadorAdmin');
Route::post('/admin/redacao-temas-criar', 'RedacaoController@store')->middleware('autenticadorAdmin');

Route::get('/admin/usuarios/create', 'AdminController@userCreate')->middleware('autenticadorAdmin')->name('novo_usuario');
Route::post('/admin/usuarios/create', 'AdminController@userStore')->middleware('autenticadorAdmin');
Route::get('/admin/usuarios', 'AdminController@userList')->middleware('autenticadorAdmin')->name('lista_usuarios');
Route::get('/admin/usuarios/{id}/edit', 'AdminController@userEdit')->middleware('autenticadorAdmin');
Route::post('/admin/usuarios/{id}/edit', 'AdminController@userUpdate')->middleware('autenticadorAdmin');


Route::get('/baixar-arquivo/{arquivo}', 'FileDownloadController@down');

Route::get('/admin/redacoes', 'AdminController@redacaoInscritos')->middleware('autenticadorAdmin');
Route::get('/admin/redacoes/download/{id}', 'AdminController@redacaoDownload')->name('force_download')->middleware('autenticadorAdmin');
Route::get('/admin/redacoes/{status_id}/{inscrito_id}/statusCandidato', 'AdminController@alterarStatusCandidato')->middleware('autenticadorAdmin');
Route::get('/admin/inscritos', 'AdminController@listarInscritos')->name('lista_inscritos')->middleware('autenticadorAdmin');
Route::get('/admin/inscritos/lista', 'AdminController@listarInscritosPost')->name('listar_inscritos_json')->middleware('autenticadorAdmin');
Route::get('/admin/inscrito/{id}', 'AdminController@show')->name('visualizar_inscrito')->middleware('autenticadorAdmin');
Route::get('/admin/enviarEmail/{id}', 'AdminController@enviarEmail');

/* Rotas Vestibular privadas*/
//Route::get('/vestibular/redacao', 'VestibularController@index')->name('acesso_inscrito');
Route::get('/vestibular/redacao', 'VestibularController@index')->name('acesso_inscrito');
Route::post('/vestibular/redacao', 'VestibularController@check')->name('acessar_redacao');


Route::get('/vestibular/redacao/prova/{id}', 'VestibularController@prova')->middleware('autenticadorAluno');
Route::post('/vestibular/redacao/prova', 'VestibularController@provaSave')->name('salvar_prova')->middleware('autenticadorAluno');
Route::get('/vestibular/redacao/tema', 'VestibularController@tema')->name('selecionar_tema')->middleware('autenticadorAluno');

Route::get('/email/inscricao', 'InscricaoController@emailInscricao');

/** Rodas do Indica amigo */
Route::get('/indicacao', 'IndicaAmigoController@index')->name('indicaAmigo');
Route::post('/indicacao', 'IndicaAmigoController@check')->name('checkStudent');
Route::get('/indicacao/painel', 'IndicaAmigoController@show')->name('painel_amigo');
Route::post('/indicacao/envia', 'IndicaAmigoController@store')->name('envia_convite');

/** Rotas para pagamento */
Route::get('/boleto', 'PagSeguroController@payment');
Route::get('/pagseguro/credenciais', 'PagSeguroController@getCredentials')->name('credenciais');
Route::get('/pagseguro/statusTransacao', 'PagSeguroController@verificarStatusTransacao');
Route::get('/pagseguro/transacoesPorData', 'PagSeguroController@verificarTransacaoPorData');
Route::post('/pagseguro/paymentMethod', 'PagSeguroController@paymentMethod')->name('payment');


Route::get('/testaemail', 'PagSeguroController@email');

Route::get('/testaSenha', 'InscricaoController@testa');

Route::post('/saveTime', 'VestibularController@saveTime')->name('save_time')->middleware('autenticadorAluno');



/**  rest time **/
Route::get('/admin/inscritoxcurso', 'AdminController@inscritoXcurso')->name('chartInscritosCursos');
Route::get('/admin/situacaocandidatos', 'AdminController@situacoesCandidatos')->name('chartSituacoesCandidatos');
Route::get('/admin/inscricoesmeses', 'AdminController@inscricoesPorMeses');
Route::get('/admin/inscricoesufs', 'AdminController@inscritosUfs');