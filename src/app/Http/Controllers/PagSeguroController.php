<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\PagamentoPagSeguro;

class PagSeguroController extends Controller
{

    public function verificarStatusTransacao(PagamentoPagSeguro $pagamentoPagSeguro){
        $cod_referencia = 'REF1234';
        print_r($pagamentoPagSeguro->verificarStatusTransacao($cod_referencia));
    }

    public function getCredentials(Request $request, PagamentoPagSeguro $pagamentoPagSeguro){
        $result = $pagamentoPagSeguro->conectaPagSeguro();
        if($result['success'] == true){
            echo json_encode($result['retorno']);
            return;
        }
    }
}
