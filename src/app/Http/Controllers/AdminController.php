<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RedacaoAluno;
use App\Redacao;
use App\Inscrito;
use App\User;
use App\Admin;
use Gate;
use App\Curso;
use App\Payment;
use App\Role;
use App\StatusCandidato;
use App\Helpers\Helper;
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
        $redacoesAlunos = RedacaoAluno::where('enviou_redacao', '=', 1)
            ->orderBy('created_at', 'asc')
            ->take(10)
            ->get();

        $inscritosSemRedacao      = Inscrito::where('firstName', '!=', 'mauricio')
            ->where('lastName', '!=', 'gerber')
            ->where('status', '=', 1)
            ->orderBy('created_at', 'asc')
            ->take(10)
            ->get();

        $aguardandoCorrecao      = Inscrito::where('firstName', '!=', 'mauricio')
            ->join('redacao_alunos as re', 're.inscrito_id', '=', 'inscritos.id')
            ->where('lastName', '!=', 'gerber')
            ->where('status', '=', 2)
            ->where('re.corrigido', 0)
            ->orderBy('inscritos.created_at', 'asc')
            ->take(10)
            ->get();
        return view('admin.dashboard.index', compact('redacoesAlunos', 'inscritosSemRedacao', 'aguardandoCorrecao'));
    }


    public function userList(Request $request)
    {
        
        if(Gate::denies('manage-admin')){
            return redirect(route('admin.dashboard'));
        }

        $mensagem   = $request->session()->get('mensagem');
        $alert_tipo = $request->session()->get('alert_tipo');


        $admins = Admin::all();
        return view('admin.user.index', compact('admins', 'mensagem', 'alert_tipo'));
    }

    public function userEdit(Request $request, $id)
    {   

        if(Gate::denies('edit-admin')){
            return redirect(route('lista_usuarios'));
        }

        $roles = Role::all();
        $user = Admin::find($id);

        if (!$user) {
            $request->session()->flash('mensagem', "Usuário não encontrado.");
            $request->session()->flash('alert_tipo', "alert-danger");

            return redirect()->route('lista_usuarios');
        }

        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function userUpdate(Request $request, $id)
    {

        $user = Admin::find($id);

        if (!$user) {
            $request->session()->flash('mensagem', "Usuário não encontrado.");
            $request->session()->flash('alert_tipo', "alert-danger");

            return redirect()->route('lista_usuarios');
        }

        $password = trim($request->input('old_password'));

        if ($request->input('password') != '') {
            $novaSenha = trim($request->password);
            $password = Hash::make($novaSenha);
            if ($password != $request->input('old_password')) {
                $password = $password;
            }
        }

        DB::beginTransaction();
        $user->name     = $request->input('name');
        $user->email    = $request->input('email');
        $user->password = $password;
        $user->save();
        DB::commit();


        $user->roles()->sync($request->roles);

        $request->session()->flash('mensagem', "O usuário <strong>{$user->name}</strong> foi editado com sucesso.");
        $request->session()->flash('alert_tipo', "alert-success");

        return redirect()->route('lista_usuarios');
    }

    public function userCreate()
    {   

        if(Gate::denies('create-admin')){
            return redirect(route('lista_usuarios'));
        }

        $roles = Role::all();

        return view('admin.user.create', compact('roles'));
    }

    public function userStore(Request $request)
    {

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

        $user->roles()->sync($request->roles);

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
                'Content-Disposition' => 'attachment; filename=' . $titulo . '.txt',
            ]);
    }

    public function alterarStatusCandidato($status_id, $inscrito_id)
    {
        $candidato = Inscrito::where('id', '=', $inscrito_id)->first();
        $candidato->status = $status_id;
        $candidato->update();

        if($status_id == 4){
            $redacao = RedacaoAluno::where('inscrito_id', '=', $inscrito_id)->first();
            $redacao->corrigido = 1;
            $redacao->update();
        }
     
        return $candidato;
    }

    public function listarInscritos(Request $request)
    {

        if(Gate::denies('manage-students')){
            return redirect(route('admin.dashboard'));
        }

        $cursos = Curso::where('status', '=', 1)->get();
        $status_candidatos = StatusCandidato::all();
        $mensagem   = $request->session()->get('mensagem');
        $alert_tipo = $request->session()->get('alert_tipo');
        return view('admin.inscritos.index', compact('mensagem', 'alert_tipo', 'cursos','status_candidatos'));
    }


    public function listarInscritosPost(Request $request)
    {


        $nome = "";
        if (isset($request->nome)) {
            $nome = $request->nome;
        }

        $cpf = "";
        if (isset($request->cpf)) {
            $cpf = $request->cpf;
        }

        $email = "";
        if (isset($request->email)) {
            $email = $request->email;
        }

        $todosCursos = Curso::where('status', '=', 1)->select('id')->get();
        foreach ($todosCursos as $curso) {
            $cursosSelecionados[$curso->id] = $curso->id;
        }

        $cursoEscolhido = $cursosSelecionados;
        if (isset($request->cursoEscolhido)) {
            if ($request->cursoEscolhido != "*") {
                $cursoEscolhido = array();
                $cursoEscolhido[$request->cursoEscolhido] = $request->cursoEscolhido;
            }
        }

        $status_candidato = StatusCandidato::select('status_int')->get();
        foreach ($status_candidato as $st) {
            $statusSelecionado[$st->status_int] = $st->status_int;
        }
        $status = $statusSelecionado;
        if (isset($request->statusCandidato)) {
            if ($request->statusCandidato != "*") {
                $status = array();
                $status[$request->statusCandidato] = $request->statusCandidato;
            }
        }



        $inscritos = Inscrito::where('firstName', 'LIKE', '%' . $nome . '%')
            ->where('nDocumento', 'LIKE', '%' . $cpf . '%')
            ->where('email', 'LIKE', '%' . $email . '%')
            ->whereIn('curso_id', $cursoEscolhido)
            ->whereIn('status', $status)
            ->leftJoin('redacao_alunos', 'redacao_alunos.inscrito_id', '=', 'inscritos.id')
            ->select('inscritos.*', 'redacao_alunos.corrigido')
            ->get();

        //print_r($inscritos);
        //echo $inscritos;
        $inscricoes = array();

        foreach ($inscritos as $inscrito) {
            $inscricoes[] = array(
                'status' => "<span class='badge " . Helper::retornaBadgeStatusInscrito($inscrito['status'], $inscrito['id']) . "'>" . Helper::retornaStatusInscrito($inscrito['status'], $inscrito['id']) . "</span>",
                'id' => $inscrito['id'],
                'nomeCompleto' => $inscrito['firstName'] . ' ' . $inscrito['lastName'],
                'curso' => "<a href='/admin/cursos/{$inscrito['curso_id']}'>{$inscrito->curso->abreviacao}</a>",
                'nDocumento' =>  $inscrito->nDocumento,
                'contato' => $inscrito->email . '<br>' . $inscrito->phone,
                'viewContato' => "<a href='/admin/inscrito/$inscrito->id' class='btn btn-primary btn-sm mb-1'>Visualizar</a>"
            );
        }


        return response()->json($inscricoes, 201);
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
        $status_candidato = StatusCandidato::where('status_int', '>', 2)->get();
        $payments = Payment::where('reference', '=', $id)
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('admin.inscritos.inscrito', compact('inscrito', 'payments','status_candidato'));
    }


    public function inscritoXcurso()
    {
        $relacao = Curso::where('status', '=', 1)
                        ->withCount(['inscritos'])
                        ->get();

        foreach ($relacao as $val) {
            $relacaoRetorno[] = array(
                'curso' => $val['abreviacao'],
                'total' => $val['inscritos_count'],
                'color' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT)
            );
        }

        return response()->json($relacaoRetorno, 201);
    }


    public function countCandidatos($status){
        $inscritos = Inscrito::where('status', '=', $status)->count();

        return $inscritos;
    }

    public function situacoesCandidatos()
    {
    
        $statusCandidato = StatusCandidato::select('status_int','status')->get();

        foreach($statusCandidato as $val)
        {
            $retorno[] = array(
                'status' => $val->status, 
                'total' => $this->countCandidatos($val->status_int),
                'color' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT)
            ); 
        }


        return response()->json($retorno, 201);
    }

    public function inscricoesPorMeses(){
        $inscritos = Inscrito::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
                ->groupBy('year', 'month')
                ->orderBy('month', 'desc')
                ->get();

        foreach($inscritos as $ins){
            $retorno[] = array(
                'mes' => Helper::mes($ins['month']),
                'total' => $ins['data'],
                'color' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT)
            );
        }
        return response()->json($retorno, 201);
    }

    
}
