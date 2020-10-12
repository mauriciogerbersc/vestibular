<?php

namespace App\Services;

use App\Payment;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;


class PagamentoPagSeguro
{

    private $email;
    private $token_sandbox;
    private $token;
    private $url;
    private $url_sandbox;

    public function __construct()
    {
        $this->url              = $_ENV['URL'];
        $this->url_sandbox      = $_ENV['URL_SANDBOX'];
        $this->email            = $_ENV['EMAIL'];
        $this->token_sandbox    = $_ENV['TOKEN_SANDBOX'];
        $this->token            = $_ENV['TOKEN'];
    }

    public function conectaPagSeguro(){
        return $this->processaNovaTransacao("",'connect');
    }


    public function processaNovaTransacao($dadosArray, $tipoTransacao)
    {   
        switch($tipoTransacao){
            case "payment": 
                return $this->transacaoAPI($dadosArray, "doPayment");
                break;
            case "connect": 
                return $this->transacaoAPI($dadosArray, "doConnect");
                break;
            case "transactionsByCode": 
                return $this->transacaoAPI($dadosArray, "doTransactionsByCode");
                break;
            case "transactionsByRangeDate":
                return $this->transacaoAPI($dadosArray, "doTransactionsByRangeDate");
                break;
        }
        
    }

    public function transacaoAPI($dadosArray, $tipoTransacao){
    
        $ambiente        = "producao";   
        $url             = $this->url;
        $token           = $this->token;
        $dados_transacao = "";
        $post            = "";

        if($ambiente == "sandbox"){
            $url            = $this->url_sandbox;
            $token          = $this->token_sandbox;
        }

        if($tipoTransacao =='doTransactionsByRangeDate'){ 
            /*
            doTransactionsByRangeDate
            */
            $url_reference      = 'transactions?email='.$this->email.'&token='.$token;
            $dados_transacao    = '&initialDate='.$dadosArray['inicialDate'].'&finalDate='.$dadosArray['finalDate'].'&page='.$dadosArray['page'].'&maxPageResults='.$dadosArray['maxPageResults'];
            $metodo             = "GET";
        }elseif($tipoTransacao=="doTransactionsByCode"){
            /*
            doTransactionsByCode
            */
            $url_reference      = 'transactions?email='.$this->email.'&token='.$token;
            $dados_transacao    = "&reference=".$dadosArray['referenceCode'];
            $metodo             = "GET";
            
        }elseif($tipoTransacao=="doConnect"){
            /*
            doConnect
            */
            $url_reference      = 'sessions?email='.$this->email.'&token='.$token;
            $metodo             = "POST";
        }else{
            /*
            doPayment
            */
            $url_reference      = 'transactions?email='.$this->email.'&token='.$token;
            $metodo             = 'POST';
            $post               =  http_build_query($dadosArray);
        }
        
        // Url final de transação
        $url_transacao = $url.$url_reference.$dados_transacao;
     
        // cURL para consulta no PagSeguro
        $headers = array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8');
        $curl = curl_init();
        try {

            if($metodo=='GET'){
                curl_setopt($curl, CURLOPT_URL,$url_transacao);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            }else{
                curl_setopt($curl, CURLOPT_URL, $url_transacao);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true );
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
            }
        
            $retorno = curl_exec($curl);
          
            $xml = simplexml_load_string($retorno);
           
            $infoRequisicao = curl_getinfo($curl);

            curl_close($curl);
            
            if ($infoRequisicao['http_code'] != 200) {
                return array('success' => false, 'mensagem' => "Ocorreu um erro [STATUS {$infoRequisicao['http_code']}] ao executar esta ação. Contate o suporte técnico.");
            }else{
                return array('success' => true, 'retorno' => $xml);
            }
            
        }catch(Exception $ex) {
            return array('success' => false, 'mensagem' => 'Ocorreu o segionte erro (EXCEPTION): ' . $ex->getMessage() . '.<br>Favor contatar o suporte técnico.');
        }
    }

    public function verificarStatusTransacao($cod_referencia){
        $dados['referenceCode']     = $cod_referencia;
        $retornaStatusPagamento     = $this->processaNovaTransacao($dados, 'transactionsByCode');
        return $retornaStatusPagamento;
    }

    public function verificarTransacaoPorData($inicialDate, $finalDate, $page, $maxPageResults){
        $dados['inicialDate']       = $inicialDate;
        $dados['finalDate']         = $finalDate;
        $dados['page']              = $page;
        $dados['maxPageResults']    = $maxPageResults;
       
        $processaNovaTransacao      = $this->processaNovaTransacao($dados, 'transactionsByRangeDate');
        return $processaNovaTransacao;
    }

    public function pagamentoBoleto($payment){

        $dadosPagamento['email']                        = $this->email;
        $dadosPagamento['token']                        = $this->token;
        $dadosPagamento['paymentMode']                  = 'default';
        $dadosPagamento['paymentMethod']                = $payment->paymentMethod;
        $dadosPagamento['firstDueDate']                 = date("Y-m-d", strtotime("+ 1 day"));
        $dadosPagamento['receiverEmail']                = $this->email;
        $dadosPagamento['currency']                     = 'BRL';
        $dadosPagamento['extraAmount']                  = '0.00';
        $dadosPagamento['itemId1']                      = '0001';
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
            
       return $this->processaNovaTransacao($dadosPagamento,'payment');

    }

    public function pagamentoCartao($payment)
    {   
       
        $dadosPagamento['email']                        = $this->email;
        $dadosPagamento['token']                        = $this->token;
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

        return $this->processaNovaTransacao($dadosPagamento,'payment');
    }


    public function savePayment(int $referencia, string $codigo, string $status, string $tipo_transacao){
        DB::beginTransaction();
            $payment = Payment::create(['reference' => $referencia, 'codigo' => $codigo, 'status_transacao' => $status, 'tipo_transacao' => $tipo_transacao]);
        DB::commit();
        return $payment;
    }

    
}
