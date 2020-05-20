<?php

namespace App\Http\Controllers;

use App\Redacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RedacaoController extends Controller
{

    
    public function __construct()
    {
        $this->middleware('auth:admin');    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $redacoes   = Redacao::where('status', '=', 1)->get();
        $mensagem   = $request->session()->get('mensagem');
        $alert_tipo = $request->session()->get('alert_tipo');

        return view('admin.redacao.index', compact('mensagem', 'alert_tipo', 'redacoes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.redacao.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        if($request->hasFile('tema_imagem')){
            $imagem = $request->file('tema_imagem');

            $name                     = $imagem->getClientOriginalName();
            $name_sem_extensao        = pathinfo($name, PATHINFO_FILENAME);
            $extension                = $imagem->getClientOriginalExtension();
            $fileNameToStore          = uniqid().'_'.time().'.'.$extension;
            $imagem->move(public_path().'/files/', $fileNameToStore);
        }


        DB::beginTransaction();
        $redacao = Redacao::create([
            'titulo_redacao' => $request->titulo,
            'descricao_redacao' => $request->descricao,
            'tema_imagem'   => $fileNameToStore,
            'status' => 1
        ]);
        DB::commit();

        $request->session()->flash('mensagem', "Redação <strong>{$redacao->titulo_redacao}</strong> cadastrada com sucesso.");
        $request->session()->flash('alert_tipo', "alert-success");

        return redirect()->route('listar_redacoes');
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $redacao = Redacao::find($id);
        return view('admin.redacao.edit', compact('redacao'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   

        if($request->hasFile('tema_imagem')){
            $imagem = $request->file('tema_imagem');

            $name                     = $imagem->getClientOriginalName();
            $name_sem_extensao        = pathinfo($name, PATHINFO_FILENAME);
            $extension                = $imagem->getClientOriginalExtension();
            $fileNameToStore          = uniqid().'_'.time().'.'.$extension;
            $imagem->move(public_path().'/files/', $fileNameToStore);
            $imagem                   = $fileNameToStore;
        }else{
            $imagem                   = $request->old_imagem;
        }

        DB::beginTransaction();
            $redacao = Redacao::find($id);
            $redacao->titulo_redacao    = $request->input('titulo');
            $redacao->descricao_redacao = $request->input('descricao');
            $redacao->tema_imagem       = $fileNameToStore;
            $redacao->save();
        DB::commit();


        $request->session()->flash('mensagem', "Redação <strong>{$redacao->titulo_redacao}</strong> editada com sucesso.");
        $request->session()->flash('alert_tipo', "alert-success");

        return redirect()->route('listar_redacoes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        $redacao = Redacao::find($id);
        $redacao->status = 0;
        $redacao->save();
        DB::commit();

        $request->session()->flash('mensagem', "Redação <strong>{$redacao->titulo_redacao}</strong> excluído com sucesso.");
        $request->session()->flash('alert_tipo', "alert-danger");

        return redirect()->route('listar_redacoes');
    }
}
