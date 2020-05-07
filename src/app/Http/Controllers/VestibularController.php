<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inscrito;
use App\Hash;
use App\Redacao;
use App\RedacaoAluno;
use Hashids\Hashids;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class VestibularController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'check']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $hash               = $request->query('hash');
        $mensagem           = $request->session()->get('mensagem');
        $alert_tipo         = $request->session()->get('alert_tipo');
        return view('vestibular.index', compact('hash','mensagem','alert_tipo'));
    }

    public function check(Request $request)
    {
        $hash = $request->input('hash');
       
        $hashids             = new Hashids('this is my salt', 20, 'abcdefgh123456789');
        $hashQuebrada        = $hashids->decode($hash);
       
        if(empty($hashQuebrada)){
            $request->session()->flash('mensagem', "Há algo errado com seu link de acesso. Entre em contato com a instituição.");
            $request->session()->flash('alert_tipo', "alert-danger");
    
            return redirect()->back();
        }

        $idBroked             = $hashQuebrada[0];
        $select = Hash::where('hash', '=', $hash)->where('inscrito_id', '=', $idBroked)->get();
     
        if(!$select){
            $request->session()->flash('mensagem', "Há algo errado com seu link de acesso. Entre em contato com a instituição.");
            $request->session()->flash('alert_tipo', "alert-danger");
    
            return redirect()->back();
        }

        if(!Auth::attempt($request->only(['email', 'password']))){
            
            $request->session()->flash('mensagem', "E-mail/CPF incorretos.");
            $request->session()->flash('alert_tipo', "alert-danger");
    
            return redirect()->back();
        }

        return redirect()->route('selecionar_tema');
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tema()
    {
        $temas = Redacao::where('status','=',1)->get();
        return view('vestibular.tema', compact('temas'));
    }


    public function prova($id){

        
        $redacaoTema = Redacao::where('id', '=', $id)->where('status','=', 1)->first();
        
        if(!$redacaoTema){
            return redirect()->route('selecionar_tema');
        }

     
        // Verifico se existe alguma redação anterior para que ele possa retomar, no caso de não ter enviado.
        $inscrito_id        = Auth::user()->inscrito_id;
        $redacaoAnterior    = RedacaoAluno::where('inscrito_id', '=', $inscrito_id)->Where('redacao_id', '=', $id)->first();

        if(isset($redacaoAnterior)){
            if($redacaoAnterior->enviou_redacao == 1)
            {
                return redirect()->route('selecionar_tema');
            }
        }

        return view('vestibular.redacao', compact('redacaoTema' , 'redacaoAnterior'));
    }


    public function provaSave(Request $request){

        $procuraRedacao = RedacaoAluno::where('inscrito_id', '=', $request->inscrito_id)->where('redacao_id', '=', $request->tema_id)->count();

        if($procuraRedacao == 0){

           DB::beginTransaction();
                RedacaoAluno::create([
                    'redacao_aluno' => $request->redacao,
                    'inscrito_id'   => $request->inscrito_id,
                    'redacao_id'    => $request->tema_id,
                    'enviou_redacao'=> $request->enviou_redacao
                ]);
            DB::commit();

            
        }else{
            $procuraRedacao = RedacaoAluno::where('inscrito_id', '=', $request->inscrito_id)->where('redacao_id', '=', $request->tema_id)->first();
            DB::beginTransaction();
            $procuraRedacao->redacao_aluno = $request->redacao;
            $procuraRedacao->save();
            DB::commit();
        }

        
        if($request->enviou_redacao == 1){
            $procura_inscrito = Inscrito::find($request->inscrito_id);
            $procura_inscrito->status = 2;
            $procura_inscrito->save();


            $procuraRedacao = RedacaoAluno::where('inscrito_id', '=', $request->inscrito_id)->where('redacao_id', '=', $request->tema_id)->first();
            $procuraRedacao->enviou_redacao = 1;
            $procuraRedacao->save();
        }

        $redacaoRetorno['success'] = true;
        $redacaoRetorno['message'] = "Redação enviada com sucesso";

        echo json_encode($redacaoRetorno);
        return;
        
    }
}
