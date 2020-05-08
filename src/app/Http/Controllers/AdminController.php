<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RedacaoAluno;
use App\Redacao;
use App\Inscrito;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {

        $redacoesAlunos = RedacaoAluno::where('enviou_redacao', '=', 1)->get();
        $inscritos = Inscrito::all();
        return view('admin.dashboard.index', compact('redacoesAlunos', 'inscritos'));
    }

    public function redacaoInscritos()
    {
        $redacoesAlunos = RedacaoAluno::where('enviou_redacao', '=', 1)->get();
        return view('admin.redacao.redacoes', compact('redacoesAlunos'));
    }

    public function redacaoDownload($id)
    {

        $redacaoAluno = RedacaoAluno::find($id);

        $titulo = $redacaoAluno->inscrito->firstName . ' ' . $redacaoAluno->inscrito->lastName;
        $titulo = str_replace(" ", "_", $titulo);
        
        return response($redacaoAluno->redacao_aluno)
                ->withHeaders([
                    'Content-Type' => 'text/plain',
                    'Cache-Control' => 'no-store, no-cache',
                    'Content-Disposition' => 'attachment; filename='.$titulo.'.txt',
                ]);
    }


    
    public function listarInscritos()
    {
        $inscritos = Inscrito::all();
        return view('admin.inscritos.index', compact('inscritos'));
    }


    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inscrito = Inscrito::find($id);
        return view('admin.inscritos.inscrito', compact('inscrito'));
    }
    
}
