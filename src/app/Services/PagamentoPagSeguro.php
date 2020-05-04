<?php

namespace App\Services;

use App\Payment;
use Illuminate\Support\Facades\DB;


class PagamentoPagSeguro
{

    private $email;
    private $token_sandbox;
    private $token;
    private $url;
    private $url_sandbox;

    public function __construct()
    {
        $this->url              = "https://ws.pagseguro.uol.com.br/v2/";
        $this->url_sandbox      = "https://ws.sandbox.pagseguro.uol.com.br/v2/";
        $this->email            = "financeiro.seminario@aerotd.com.br";
        $this->token_sandbox    = "C5DEA9B3A39D4B6681EF520A4096E5EB";
        $this->token            = "2BFE26E711B04FD5A01A10563B37D3A9";
    }

    public function conectaPagSeguro(){
        $dadosPagamento = '';
        return $this->transacaoAPI($dadosPagamento, 'sessions', 'sandbox');
    }

    public function transacaoAPI($dadosPagamento, $tipoRequisicao, $tipoTransacao){
   
        $url                                            = $this->url;
        $token                                          = $this->token;
        if($tipoTransacao == 'sandbox'){
            $url                                        = $this->url_sandbox;
            $token                                      = $this->token_sandbox;
        }

        $transacaoCodigo = '';
        if((!is_array($dadosPagamento)) AND (!empty($transacaoCodigo))){
            $transacaoCodigo            = '&reference='.$dadosPagamento;
        }elseif($tipoRequisicao !== 'sessions'){
            $post                       =  http_build_query($dadosPagamento);
        }
        
        $url_transacao                                  = $url.$tipoRequisicao.'?email='.$this->email.'&token='.$token.$transacaoCodigo;

        try {
            if(is_array($dadosPagamento)){
                
                $curl = curl_init($url_transacao);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
            }else{
               
                $curl = curl_init($url_transacao);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, 1);
            }
            
            $retorno = curl_exec($curl);
           /*print_r($retorno);
            exit;*/
            $xml = simplexml_load_string($retorno);
        
            $infoRequisicao = curl_getinfo($curl);
            curl_close($curl);

            if ($infoRequisicao['http_code'] != 200) {
                return array('success' => false, 'mensagem' => "Ocorreu um erro [STATUS {$infoRequisicao['http_code']}] ao executar esta ação. Contate o suporte técnico.");
            }
           
            return array('success' => true, 'retorno' => $xml);

        }  catch (Exception $ex) {
            return array('success' => false, 'mensagem' => 'Ocorreu o segionte erro (EXCEPTION): ' . $ex->getMessage() . '.<br>Favor contatar o suporte técnico.');
        }
      
    }

    public function verificarStatusTransacao($cod_referencia){
        $dadosPagamento = 'REF1234';
        $retornaStatusPagamento = $this->transacaoAPI($dadosPagamento, 'transactions', 'sandbox');
        return $retornaStatusPagamento;
    }

    public function pagamentoBoleto($payment){
        
        $dadosPagamento['email']                        = $this->email;
        $dadosPagamento['token']                        = $this->token_sandbox;
        $dadosPagamento['paymentMode']                  = 'default';
        $dadosPagamento['paymentMethod']                = $payment->paymentMethod;
        $dadosPagamento['receiverEmail']                = $this->email;
        $dadosPagamento['currency']                     = 'BRL';
        $dadosPagamento['itemId1']                      = '0001';
        $dadosPagamento['extraAmount']                  = '0.00';
        $dadosPagamento['itemDescription1']             = $payment->itemDescription1;
        $dadosPagamento['itemAmount1']                  = $payment->itemAmount1;
        $dadosPagamento['itemQuantity1']                = $payment->itemQuantity1;
        $dadosPagamento['notificationURL']              = 'https://sualoja.com.br/notifica.html';
        $dadosPagamento['reference']                    = $payment->reference;
        $dadosPagamento['senderName']                   = $payment->senderName;
        $dadosPagamento['senderCPF']                    = $payment->senderCPF;
        $dadosPagamento['senderAreaCode']               = '11';
        $dadosPagamento['senderPhone']                  = '56273440';
        $dadosPagamento['senderEmail']                  = $payment->senderEmail;
        $dadosPagamento['senderHash']                   = $payment->senderHash;
        $dadosPagamento['senderHash']                   = $payment->senderHash;
        $dadosPagamento['shippingAddressStreet']        = $payment->shippingAddressStreet;
        $dadosPagamento['shippingAddressNumber']        = $payment->shippingAddressNumber;
        $dadosPagamento['shippingAddressComplement']    = $payment->shippingAddressComplement;
        $dadosPagamento['shippingAddressDistrict']      = $payment->shippingAddressDistrict;
        $dadosPagamento['shippingAddressPostalCode']    = $payment->shippingAddressPostalCode;
        $dadosPagamento['shippingAddressCity']          = $payment->shippingAddressCity;
        $dadosPagamento['shippingAddressState']         = $payment->shippingAddressState;
        $dadosPagamento['shippingAddressCountry']       = $payment->shippingAddressCountry;
        $dadosPagamento['shippingType']                 = $payment->shippingType;
        $dadosPagamento['shippingCost']                 = $payment->shippingCost;

        return $this->transacaoAPI($dadosPagamento, 'transactions', 'sandbox');

    }

    public function pagamentoCartao($payment)
    {   
       
        $dadosPagamento['email']                        = $this->email;
        $dadosPagamento['token']                        = $this->token_sandbox;
        $dadosPagamento['paymentMode']                  = 'default';
        $dadosPagamento['paymentMethod']                = $payment->paymentMethod;
        $dadosPagamento['receiverEmail']                = $this->email;
        $dadosPagamento['currency']                     = 'BRL';
        $dadosPagamento['itemId1']                      = '0001';
        $dadosPagamento['extraAmount']                  = '0.00';
        $dadosPagamento['itemDescription1']             = $payment->itemDescription1;
        $dadosPagamento['itemAmount1']                  = $payment->itemAmount1;
        $dadosPagamento['itemQuantity1']                = $payment->itemQuantity1;
        $dadosPagamento['notificationURL']              = 'https://sualoja.com.br/notifica.html';
        $dadosPagamento['reference']                    = $payment->reference;
        $dadosPagamento['senderName']                   = $payment->senderName;
        $dadosPagamento['senderCPF']                    = $payment->senderCPF;
        $dadosPagamento['senderAreaCode']               = $payment->senderAreaCode;
        $dadosPagamento['senderPhone']                  = $payment->senderPhone;
        $dadosPagamento['senderEmail']                  = $payment->senderEmail;
        $dadosPagamento['senderHash']                   = $payment->senderHash;
        $dadosPagamento['shippingAddressStreet']        = $payment->shippingAddressStreet;
        $dadosPagamento['shippingAddressNumber']        = $payment->shippingAddressNumber;
        $dadosPagamento['shippingAddressComplement']    = $payment->shippingAddressComplement;
        $dadosPagamento['shippingAddressDistrict']      = $payment->shippingAddressDistrict;
        $dadosPagamento['shippingAddressPostalCode']    = $payment->shippingAddressPostalCode;
        $dadosPagamento['shippingAddressCity']          = $payment->shippingAddressCity;
        $dadosPagamento['shippingAddressState']         = $payment->shippingAddressState;
        $dadosPagamento['shippingAddressCountry']       = $payment->shippingAddressCountry;
        $dadosPagamento['shippingType']                 = $payment->shippingType;
        $dadosPagamento['shippingCost']                 = $payment->shippingCost;
        $dadosPagamento['creditCardToken']               = $payment->creditCardToken;
        $dadosPagamento['installmentQuantity']           = $payment->installmentQuantity;
        $dadosPagamento['installmentValue']              = $payment->installmentValue;
        $dadosPagamento['noInterestInstallmentQuantity'] = $payment->noInterestInstallmentQuantity;
        $dadosPagamento['creditCardHolderName']          = $payment->creditCardHolderName;
        $dadosPagamento['creditCardHolderCPF']           = $payment->creditCardHolderCPF;
        $dadosPagamento['creditCardHolderBirthDate']     = $payment->creditCardHolderBirthDate;
        $dadosPagamento['creditCardHolderAreaCode']      = $payment->senderAreaCode;
        $dadosPagamento['creditCardHolderPhone']         = $payment->senderPhone;
        $dadosPagamento['billingAddressStreet']          = $payment->billingAddressStreet;
        $dadosPagamento['billingAddressNumber']          = $payment->billingAddressNumber;
        $dadosPagamento['billingAddressComplement']      = $payment->billingAddressComplement;
        $dadosPagamento['billingAddressDistrict']        = $payment->billingAddressDistrict;
        $dadosPagamento['billingAddressPostalCode']      = $payment->billingAddressPostalCode;
        $dadosPagamento['billingAddressCity']            = $payment->billingAddressCity;
        $dadosPagamento['billingAddressState']           = $payment->billingAddressState;
        $dadosPagamento['billingAddressCountry']         = 'BRA';

        return $this->transacaoAPI($dadosPagamento, 'transactions', 'sandbox');
    }


    public function savePayment(int $referencia, string $codigo, string $status, string $tipo_transacao){
        DB::beginTransaction();
            $payment = Payment::create(['reference' => $referencia, 'codigo' => $codigo, 'status_transacao' => $status, 'tipo_transacao' => $tipo_transacao]);
        DB::commit();
        return $payment;

    }
}
