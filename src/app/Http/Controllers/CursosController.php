<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
Use App\Curso;
use Helper;

class CursosController extends Controller
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
        
        $cursos     = Curso::where('status', '=', 1)->get();
        $mensagem   = $request->session()->get('mensagem');
        $alert_tipo = $request->session()->get('alert_tipo');
       
        return view('admin.cursos.index', compact('mensagem', 'alert_tipo', 'cursos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cursos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        $slug = Helper::createSlug($request->curso);
       
        if($request->hasFile('curso_imagem')){
            $imagem = $request->file('curso_imagem');
            $name                     = $imagem->getClientOriginalName();
            $name_sem_extensao        = pathinfo($name, PATHINFO_FILENAME);
            $extension                = $imagem->getClientOriginalExtension();
            $fileNameToStore          = uniqid().'_'.time().'.'.$extension;
            $imagem->move(public_path().'/files/', $fileNameToStore);
        }

        DB::beginTransaction();
            $curso = Curso::create([
                'curso' => $request->curso, 
                'tipo_curso' => $request->modalidade,
                'imagem_curso' => $fileNameToStore, 
                'descricao' => $request->descricao,
                'slug'      => $slug
            ]);
        DB::commit();

        $request->session()->flash('mensagem', "Curso <strong>{$curso->curso}</strong> cadastrado com sucesso.");
        $request->session()->flash('alert_tipo', "alert-success");

        return redirect()->route('listar_cursos');
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
        $curso = Curso::find($id);
        return view('admin.cursos.edit', compact('curso'));
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

        $slug = Helper::createSlug($request->curso);

        if($request->hasFile('curso_imagem')){
            $imagem = $request->file('curso_imagem');

            $name                     = $imagem->getClientOriginalName();
            $name_sem_extensao        = pathinfo($name, PATHINFO_FILENAME);
            $extension                = $imagem->getClientOriginalExtension();
            $fileNameToStore          = uniqid().'_'.time().'.'.$extension;
            $imagem->move(public_path().'/files/', $fileNameToStore);

            $imagem_final = $fileNameToStore;
        }else{
            $imagem_final = $request->old_image;
        }

        if($request->hasFile('banner_curso')){
            $imagemBanner = $request->file('banner_curso');

            $name_banner              = $imagemBanner->getClientOriginalName();
            $name_sem_extensao        = pathinfo($name_banner, PATHINFO_FILENAME);
            $extension                = $imagemBanner->getClientOriginalExtension();
            $fileNameToStoreBanner    = md5(uniqid()).'_'.time().'.'.$extension;
            $imagemBanner->move(public_path().'/files/banner/', $fileNameToStoreBanner);

            $banner_final = $fileNameToStoreBanner;
        }else{
            $banner_final = $request->old_banner;
        }


        DB::beginTransaction();
            $curso = Curso::find($id);
            $curso->tipo_curso = $request->input('modalidade');
            $curso->curso = $request->input('curso');
            $curso->descricao = $request->input('descricao');
            $curso->banner_curso = $banner_final;
            $curso->link_curso = $request->input('link_curso');
            $curso->imagem_curso = $imagem_final;
            $curso->slug = $slug;
            $curso->save();
        DB::commit();


        $request->session()->flash('mensagem', "Curso <strong>{$curso->curso}</strong> editado com sucesso.");
        $request->session()->flash('alert_tipo', "alert-success");

        return redirect()->route('listar_cursos');

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
            $curso = Curso::find($id);
            $curso->status = 0;
            $curso->save();
        DB::commit();

        $request->session()->flash('mensagem', "Curso <strong>{$curso->curso}</strong> excluído com sucesso.");
        $request->session()->flash('alert_tipo', "alert-danger");

        return redirect()->route('listar_cursos');
    }
}
