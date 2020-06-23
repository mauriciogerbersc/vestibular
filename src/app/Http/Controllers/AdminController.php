<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RedacaoAluno;
use App\Redacao;
use App\Inscrito;
use App\User;
use App\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {

        $redacoesAlunos = RedacaoAluno::where('enviou_redacao', '=', 1)->get();
        $inscritos      = Inscrito::where('firstName', '!=', 'mauricio')
                                ->where('lastName', '!=', 'gerber')
                                ->where('status', '<>', 2)
                             ->get();
        return view('admin.dashboard.index', compact('redacoesAlunos', 'inscritos'));
    }





    public function userList(Request $request){

        $mensagem   = $request->session()->get('mensagem');
        $alert_tipo = $request->session()->get('alert_tipo');
       

        $admins = Admin::all();
        return view('admin.user.index', compact('admins','mensagem','alert_tipo'));
    }

    public function userEdit(Request $request, $id){

        $user = Admin::find($id);

        if(!$user){
            $request->session()->flash('mensagem', "Usuário não encontrado.");
            $request->session()->flash('alert_tipo', "alert-danger");
        
            return redirect()->route('lista_usuarios');
        }
        
        return view('admin.user.edit', compact('user'));
    }

    public function userUpdate(Request $request, $id){

        $user = Admin::find($id);

        if(!$user){
            $request->session()->flash('mensagem', "Usuário não encontrado.");
            $request->session()->flash('alert_tipo', "alert-danger");
        
            return redirect()->route('lista_usuarios');
        }


        $password = trim($request->input('old_password'));

        if($request->input('password') != ''){
            $novaSenha = trim($request->password);
            $password = Hash::make($novaSenha);
            if($password != $request->input('old_password')){
                $password = $password;
            }
        }

        DB::beginTransaction();
            $user->name     = $request->input('name');
            $user->email    = $request->input('email');
            $user->password = $password;
            $user->save();
        DB::commit();

        $request->session()->flash('mensagem', "O usuário <strong>{$user->name}</strong> foi editado com sucesso.");
        $request->session()->flash('alert_tipo', "alert-success");

        return redirect()->route('lista_usuarios');
    }

    public function userCreate(){
        return view('admin.user.create');
    }

    public function userStore(Request $request){

        $rules = [
            'name' => 'required',
            'email' => 'required|unique:admins',
            'password' => 'required'
        ];

        $messages = [
            'name.required' => 'O campo nome é obrigatório',
            'email.required' => 'O campo Email é obrigatório',
            'email.unique'   => 'O email já está registrado na base de dados',
            'password.required' => 'O campo senha é obrigatório'
        ];

        $validator = $request->validate($rules, $messages);

        $password = Hash::make($request->password);
        DB::beginTransaction();
            $user = Admin::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => $password
            ]);
        DB::commit();

        $request->session()->flash('mensagem', "Usuário <strong>{$user->name}</strong> criado com sucesso.");
        $request->session()->flash('alert_tipo', "alert-success");

        return redirect()->route('lista_usuarios');
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

    public function correcaoRedacao($inscrito_id){

        $redacao = RedacaoAluno::where('inscrito_id', '=',$inscrito_id)->first();
        $redacao->corrigido = 1;
        $redacao->update();

        return $redacao;
    }
    
    public function listarInscritos(Request $request)
    {
        $inscritos = Inscrito::where('firstName', '!=', 'mauricio')
                            ->where('lastName', '!=', 'gerber')
                            ->leftJoin('redacao_alunos', 'redacao_alunos.inscrito_id', '=', 'inscritos.id')
                            ->select('inscritos.*', 'redacao_alunos.corrigido')
                            ->get();

        $mensagem   = $request->session()->get('mensagem');
        $alert_tipo = $request->session()->get('alert_tipo');
        return view('admin.inscritos.index', compact('inscritos', 'mensagem', 'alert_tipo'));
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
