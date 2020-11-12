<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Indicacao;
use Hashids\Hashids;
use App\Services\EnvioDeEmail;

class IndicaAmigoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $mensagem   = $request->session()->get('mensagem');
        $alert_tipo = $request->session()->get('alert_tipo');
    
        return view('amigo.index', compact('mensagem', 'alert_tipo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function check(Request $request)
    {   

        // Validações de formulário.
        $rules = [
            'cpf' => 'required',
        ];
        
        $messages = [
            'cpf.required' => 'O campo CPF é obrigatório',
        ];
        
        $validator = $request->validate($rules, $messages);

        $users = DB::connection('mysql2')
                    ->select("SELECT pessoas.cd_pessoa as cd_pessoa, pessoas.ds_login as user, pessoas.nm_pessoa as name, nm_mae, GET_CONTATO_PESSOA(pessoas.cd_pessoa,4) AS email 
                            FROM pessoas 
                            WHERE ds_cpf = '".$request->cpf."'");
        
        if(!$users){
            $request->session()->flash('mensagem', "CPF não encontrado.");
            $request->session()->flash('alert_tipo', "alert-danger");
            return redirect()->back()->withInputs($request->cpf);
        }


        $request->session()->put('cd_pessoa', $users[0]->cd_pessoa);
        $request->session()->put('name', $users[0]->name);

        return redirect()->route('painel_amigo');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, EnvioDeEmail $enviarEmail)
    {   
        $rules = [
            'name_indicado' => 'required',
            'email_indicado' => 'required'
        ];
        
        $messages = [
            'name_indicado.required' => 'O campo Nome é obrigatório',
            'email_indicado.required' => 'O campo email é obrigatório'
        ];
        
        $validator = $request->validate($rules, $messages);

        // Verifico se existe e-mail  do indicado no banco do Unimestre
        $users = DB::connection('mysql2')
                        ->select("SELECT ds_contato, cd_pessoa FROM unimestre.contatos_pessoas
                        where cd_contato  = 4
                        and ds_contato = '$request->email_indicado'");

        if($users){
            $request->session()->flash('mensagem', "Convite não enviado.<br> Este email já existe na base de dados.");
            $request->session()->flash('alert_tipo', "alert-danger");
            return redirect()->back()->withInputs($request->email_indicado);
        }

        // Verifico se existe e-mail do indicado no banco da Indicação
        $indicacao = Indicacao::where('email_indicado', '=',$request->email_indicado)->first();
        
        if($indicacao){
            $request->session()->flash('mensagem', "Convite não enviado.<br> Este email já existe na base de dados.");
            $request->session()->flash('alert_tipo', "alert-danger");
            return redirect()->back()->withInputs($request->email_indicado);
        }

        // Gera hash baseada no codigo de quem indica, vindo do Unimestre
        $hashids             = new Hashids('this is my salt', 20, 'abcdefgh123456789');
        $hashGerada          = $hashids->encode($request->session()->get('cd_pessoa'));

        if(empty($hashGerada)){
            $request->session()->flash('mensagem', "Erro ao gerar código para convite. Tente novamente");
            $request->session()->flash('alert_tipo', "alert-danger");
            return redirect()->back();
        }

        // Armazena hash
        DB::beginTransaction();
        $indicacao = Indicacao::create([
            'cd_pessoa_unimestre' => $request->session()->get('cd_pessoa'),
            'hash'  => $hashGerada,
            'name_indicado' => $request->name_indicado,
            'email_indicado' => $request->email_indicado,
            'celular_indicado' => $request->celular_indicado
        ]);
        DB::commit();

        if(!$indicacao){
            $request->session()->flash('mensagem', "Erro ao gerar convite. Tente novamente");
            $request->session()->flash('alert_tipo', "alert-danger");
            return redirect()->back();
        }
    
        // Envia convite por email
        $tipo = 'indicacao';
        $enviarEmail->enviarEmailIndicacao($tipo, $request->name_indicado, $request->email_indicado, $hashGerada);

        // Redireciona para o painel.
        $request->session()->flash('mensagem', "Convite enviado com sucesso.");
        $request->session()->flash('alert_tipo', "alert-success");
        return redirect()->back();
    }

    /**
     * Mostra painel com indicações do aluno
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {   

        
        $hashids             = new Hashids('this is my salt', 20, 'abcdefgh123456789');
        $hashGerada          = $hashids->encode($request->session()->get('cd_pessoa'));
       
        $cd_pessoa_unimestre = $request->session()->get('cd_pessoa');
      
        $indicacoes = Indicacao::where('cd_pessoa_unimestre', '=', $cd_pessoa_unimestre)->get();
        
        // Quantidade de indicados que se inscreveram.
        $total_inscricoes = 0;
        foreach($indicacoes as $indicacao){
            $users = DB::connection('mysql2')->select("SELECT ds_contato, cd_pessoa FROM unimestre.contatos_pessoas
            where cd_contato  = 4
            and ds_contato = '$indicacao->email_indicado'");
           
           if($users){
               $total_inscricoes++;
           }
        }
        
        // Retorna total de indicações feitas pelo aluno
        $total_indicacoes = Indicacao::where('cd_pessoa_unimestre', '=', $cd_pessoa_unimestre)->count();

        $mensagem   = $request->session()->get('mensagem');
        $alert_tipo = $request->session()->get('alert_tipo');
    
        return view('amigo.painel', compact('mensagem', 'alert_tipo', 'indicacoes', 'total_indicacoes', 'total_inscricoes', 'hashGerada'));
    }


}
