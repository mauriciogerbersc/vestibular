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
        
        $enviarEmail->enviaEmailTeste("mauricio@aerotd.com.br");
        exit;
        $inicialDate    =  date("Y-m-d", strtotime('-10 day'))."T00:00";
 
        $finalDate      =  date("Y-m-d")."T13:00";
   
        $page           =  1;
        $maxPageResults =  10;


        $retorno = $pagamentoPagSeguro->verificarTransacaoPorData($inicialDate, $finalDate, $page, $maxPageResults);
        
 
        if($retorno['success'] == 1){
            foreach($retorno['retorno']->transactions as $transaction){
                foreach($transaction as $trans){
                    $this->checkIfChangeStatus($trans->code, $trans->status, $trans->reference);
                }
            }
        }else{
            echo "nada pra fazer por hoje {$inicialDate} :)\n\n";
        }

    }


    public function checkIfChangeStatus($codigo, $status_transacao, $reference){

        $payment = Payment::where('codigo', '=', $codigo)->get();
        $arrToCheck = array();
     
        foreach($payment as $key=>$val){
            $arrToCheck[$val['codigo']] = $val['status_transacao'];
         
            foreach($arrToCheck as $code=>$status){
                if($code==$codigo){
                   
                    if($status!=$status_transacao){
                        DB::beginTransaction();
                        $statusUpdate = Payment::where("codigo", "=", $code)->first();
                        $statusUpdate->status_transacao = $status_transacao;
                        $statusUpdate->save();
                        echo "Salvou o status da transação {$code}, como {$status_transacao} \n\n";
                        $inscrito = Inscrito::where('id', '=', $reference)->first();
                        
                        $criadorDeUsuario       = new CriadorDeUsuario();
                        $criarUsuarioInscrito   = $criadorDeUsuario->criarUsuario($inscrito->firstName, $inscrito->email, $inscrito->nDocumento, $inscrito->id);
                        echo "Criou o usuário para o candidato {$inscrito->firstName}\n\n";
                        /*Recupero curso que o aluno se inscreveu, para enviar por email  */
                        if ($criarUsuarioInscrito == true) {
                            /* Gero Hash para envio ao inscrito  */
                            $criadorDeHash      = new CriadorDeHash();
                            $hash               = $criadorDeHash->criarHash($inscrito->id);
                            echo "Criou  a hash {$hash->hash} para o candidato {$inscrito->firstName}\n\n";

                            $curso              = Curso::find($inscrito->curso_id);

                            $enviarEmail        = new EnvioDeEmail();
                            $enviarEmail        = $enviarEmail->enviarEmailInscricao($inscrito->firstName, 'mauricio.gerber@gmail.com', $curso->curso, $hash->hash);
                            echo "Enviando email para o candidato {$inscrito->firstName}\n\n";
                            /*Altero o status do inscrito para 1. o Valor 1 quer dizer que ele pagou e falta realizar a redação. */
                            $procura_inscrito = Inscrito::find($inscrito->id);
                            $procura_inscrito->status = 1;
                            $procura_inscrito->save();

                            echo "Altero o status para que no administrador saiba que falta apenas fazer a redação.\n\n";
                        }

                        DB::commit();
                    }
                 
                }
            }
        }
        
    }

    public function getCredentials(Request $request, PagamentoPagSeguro $pagamentoPagSeguro){
        $result = $pagamentoPagSeguro->conectaPagSeguro();
        if($result['success'] == true){
            echo json_encode($result['retorno']);
            return;
        }
    }
}
