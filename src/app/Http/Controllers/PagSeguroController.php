<?php

namespace App\Http\Controllers;

use App\Inscrito;
use App\Curso;
use Illuminate\Http\Request;
use App\Services\PagamentoPagSeguro;
use App\Services\EnvioDeEmail;
use App\Payment;
use App\Services\CriadorDeHash;
use App\Services\CriadorDeUsuario;
use Illuminate\Support\Facades\DB;

class PagSeguroController extends Controller
{


    public function email(EnvioDeEmail $enviarEmail){
        $enviarEmail->enviaEmailTeste("mauricio.gerber@gmail.com");
    }

    public function verificarStatusTransacao(PagamentoPagSeguro $pagamentoPagSeguro){
        $cod_referencia = 5;
        $retorno        = $pagamentoPagSeguro->verificarStatusTransacao($cod_referencia);

        print_r($retorno);
    }


    public function verificarTransacaoPorData(PagamentoPagSeguro $pagamentoPagSeguro, EnvioDeEmail $enviarEmail){
        // Forçar timezone SP/BR
        date_default_timezone_set('America/Sao_Paulo');


        $inicialDate        =  date("Y-m-d", strtotime('-2 days'))."T00:00";
        //$inicialDate    = "2020-05-26T12:00";
        $hour_minute        =  date("H:m");
        //$hour_minute           = "21:30";
        $finalDate          =  date("Y-m-d")."T{$hour_minute}";
        
        //$finalDate      = "2020-05-26T21:30";
        $page               =  1;
        $maxPageResults     =  40;

       
        $retorno = $pagamentoPagSeguro->verificarTransacaoPorData($inicialDate, $finalDate, $page, $maxPageResults);
        //print_r($retorno);exit;die;
        $conteudo = "";
        if($retorno['success'] == 1){
            foreach($retorno['retorno']->transactions as $transaction){
                foreach($transaction as $trans){
                   $conteudo = $this->checkIfChangeStatus($trans->code, $trans->status, $trans->reference);
                }
            }
        }
        
        if(!empty($conteudo)){
            $conteudo = $conteudo;
            $enviarEmail->enviaEmailTeste("mauricio@aerotd.com.br", $conteudo);
        }
     
     

    }


    public function checkIfChangeStatus($codigo, $status_transacao, $reference){
    
        $payment = Payment::where('codigo', '=', $codigo)->get();
       
        $arrToCheck = array();
        
        $string = "";
        foreach($payment as $key=>$val){
            $arrToCheck[$val['codigo']] = $val['status_transacao'];
         
            foreach($arrToCheck as $code=>$status){
                if($code==$codigo){
                   
                    if($status!=$status_transacao){
                        DB::beginTransaction();
                        $statusUpdate = Payment::where("codigo", "=", $code)->first();
                        $statusUpdate->status_transacao = $status_transacao;
                        $statusUpdate->save();
                        $string   .= "<strong>Salvou o status da transação {$code}, como {$status_transacao}</strong> \n\n";
                        
                        if($status_transacao==3){
                            $inscrito = Inscrito::where('id', '=', $reference)->first();
                            $criadorDeUsuario       = new CriadorDeUsuario();
                            $criarUsuarioInscrito   = $criadorDeUsuario->criarUsuario($inscrito->firstName, $inscrito->email, $inscrito->nDocumento, $inscrito->id);
                            $string .= "Criou o usuário para o candidato {$inscrito->firstName}\n\n";
                            /*Recupero curso que o aluno se inscreveu, para enviar por email  */
                            if ($criarUsuarioInscrito == true) {
                                /* Gero Hash para envio ao inscrito  */
                                $criadorDeHash      = new CriadorDeHash();
                                $hash               = $criadorDeHash->criarHash($inscrito->id);
                                $string .= "Criou  a hash {$hash->hash} para o candidato {$inscrito->firstName}\n\n";

                                $curso              = Curso::find($inscrito->curso_id);

                                $enviarEmail        = new EnvioDeEmail();
                                $enviarEmail        = $enviarEmail->enviarEmailInscricao($inscrito->firstName, $inscrito->email, $curso->curso, $hash->hash);
                                $string .= "Enviando email para o candidato {$inscrito->firstName}\n\n";
                                /*Altero o status do inscrito para 1. o Valor 1 quer dizer que ele pagou e falta realizar a redação. */
                                $procura_inscrito = Inscrito::find($inscrito->id);
                                $procura_inscrito->status = 1;
                                $procura_inscrito->save();

                                $string .= "Altero o status para que no administrador saiba que falta apenas fazer a redação <hr>.\n\n";
                            }
                        }
                        DB::commit();
                    }
                 
                }
            }
        }

        return $string;
        
    }

    public function getCredentials(Request $request, PagamentoPagSeguro $pagamentoPagSeguro){
        $result = $pagamentoPagSeguro->conectaPagSeguro();
        if($result['success'] == true){
            echo json_encode($result['retorno']);
            return;
        }
    }
}
