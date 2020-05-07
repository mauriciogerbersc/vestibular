<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Curso;
use App\Inscrito;
use App\Payment;

use stdClass;

use App\Services\CriadorDeHash;
use App\Services\CriadorDeUsuario;
use App\Services\EnvioDeEmail;
use App\Services\PagamentoPagSeguro;
use App\Services\CadastroInscrito;

class InscricaoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin')->except(['index', 'inscricao', 'create', 'store', 'confirmacao']);
    }

    public function confirmacao()
    {
        return "Oi";
    }

    /* Método que trata de enviar o email com confirma��o de inscri��o para o aluno */
    public function emailInscricao($user)
    {
        Mail::send(new \App\Mail\newLaravelTips($user));
        //return new \App\Mail\newLaravelTips($user);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cursos = Curso::where('status', '=', 1)->get();
        return view('inscricao.index', compact('cursos'));
    }

    /**
     * P�gina que exibe os dados do curso selecionado para que efetue a inscri��o
     *
     * @return \Illuminate\Http\Response
     */
    public function inscricao($curso)
    {
        $curso = Curso::where('slug', '=', $curso)->first();

        return view('inscricao.curso', compact('curso'));
    }


    /**
     * Exibe o formul�rio de inscri��o para o curso desejado 
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $slug)
    {
        $curso          = Curso::where('slug', '=', $slug)->first();
        return view('inscricao.formulario', compact('curso'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CadastroInscrito $cadastrarInscrito, CriadorDeHash $criadorDeHash, CriadorDeUsuario $criadorDeUsuario, EnvioDeEmail $enviarEmail, PagamentoPagSeguro $pagamentoPagSeguro)
    {

   
       $rules = [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|unique:inscritos',
            'nDocumento'  => 'required',
            'phone' => 'required',
        ];

        $messages = [
            'firstName.required' => 'O campo nome é obrigatório',
            'lastName.required' => 'O campo sobrenome é obrigatório',
            'email.required' => 'O campo Email é obrigatório',
            'email.unique'   => 'O email já está registrado na base de dados',
            'nDocumento.required' => 'O campo nº Documento é obrigatório',
            'phone.required' => 'O campo telefone é obrigatório'
        ];

        $validator = $request->validate($rules, $messages);

       
        if(isset($validator['message'])){
           
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }
        }else {

            $telefone = preg_split("/\(|\)/", $request->phone);
            $ddd = $telefone[1];
            $phone = str_replace("-","",trim($telefone[2]));
            
   
            $ultimoIdInscrito = Inscrito::max('id');
            $ultimoIdInscritoReference = $ultimoIdInscrito+1;

            if ($request->formaPagamento == 'b') {

                $payment = new stdClass();
                $payment->paymentMethod                = 'boleto';
                $payment->itemDescription1             =  $request->itemDescription1;
                $payment->itemAmount1                  =  $request->itemAmount1;
                $payment->itemQuantity1                = '1';
                $payment->reference                    =  $ultimoIdInscritoReference;
                $payment->senderName                   =  $request->firstName . ' ' . $request->lastName;
                $payment->senderCPF                    =  $request->nDocumento;
                $payment->senderAreaCode               =  $ddd;
                $payment->senderPhone                  =  $phone;
                $payment->senderEmail                  =  $request->email;
                $payment->senderHash                   =  $request->hashCard;
                $payment->shippingAddressStreet        =  $request->endereco;
                $payment->shippingAddressNumber        =  $request->numero;
                $payment->shippingAddressComplement    =  $request->complemento;
                $payment->shippingAddressDistrict      =  $request->bairro;
                $payment->shippingAddressPostalCode    =  $request->cep;
                $payment->shippingAddressCity          =  $request->cidade;
                $payment->shippingAddressState         =  $request->uf;;
                $payment->shippingAddressCountry       =  'BRA';
                $payment->shippingType                 =  '3';
                $payment->shippingCost                 =  '0.00';    
                $payment->creditCardToken               = $request->tokenCard;
                $payment->installmentQuantity           = '1';
                $payment->installmentValue              = $request->itemAmount1;
                $payment->noInterestInstallmentQuantity = '2';
                $retornoPagamento = $pagamentoPagSeguro->pagamentoBoleto($payment);
    
                if($retornoPagamento['success'] == 1){
                   
                    // Salva dados do pagamento.
                    $pagamento = $pagamentoPagSeguro->savePayment($ultimoIdInscritoReference, $retornoPagamento['retorno']->code[0], $retornoPagamento['retorno']->status[0], 'b');
                  
                    if($pagamento){
                    // Insiro inscrito no banco de dados.
                        $cadastroDeInscrito = new stdClass();
                        $cadastroDeInscrito->firstName  = $request->firstName;
                        $cadastroDeInscrito->lastName   = $request->lastName;
                        $cadastroDeInscrito->nDocumento = $request->nDocumento;
                        $cadastroDeInscrito->email      = $request->email;
                        $cadastroDeInscrito->cep        = $request->cep;
                        $cadastroDeInscrito->bairro     = $request->bairro;
                        $cadastroDeInscrito->cidade     = $request->cidade;
                        $cadastroDeInscrito->uf         = $request->uf;
                        $cadastroDeInscrito->endereco   = $request->endereco;
                        $cadastroDeInscrito->numero     = $request->numero;
                        $cadastroDeInscrito->complemento = $request->complemento;
                        $cadastroDeInscrito->curso_id   = $request->curso_id;
                        $cadastroDeInscrito->status     = 0;
                        $cadastroDeInscrito->phone      = $request->phone;
                        $cadastrarInscrito->cadastrarInscrito($cadastroDeInscrito);

                    }else{
                        $retorno['success'] = false;
                        $retorno['message'] = "Não foi possível continuar com sua inscrição. Entre em contato com a instituição.";
                        $retorno['classe']  = "alert-warning";
        
                        echo json_encode($retorno);
                        return;
                    }
                    // Recupero nome do curso para enviar no email.
                    $curso = Curso::find($request->curso_id);
                    // recupero link do boleto pra enviar pro email.
                    $link_boleto = $retornoPagamento['retorno']->paymentLink[0];

                    $enviarEmail        = $enviarEmail->emailBoleto($request->firstName, $request->email, $curso->curso, $link_boleto);
                  
                    $retorno['success'] = true;
                    $retorno['message'] = "Cadastro Realizado com sucesso. Você receberá por email o link com boleto para pagamento.";
                    $retorno['classe']  = "alert-success";


                    echo json_encode($retorno);
                    return;
                }else{
                    $retorno['success'] = false;
                    $retorno['message'] = "Não foi possível continuar com sua inscrição. Entre em contato com a instituição.";
                    $retorno['classe']  = "alert-warning";

                    echo json_encode($retorno);
                    return;
                }
            }elseif($request->formaPagamento == 'cc'){
                $payment = new stdClass();
                $payment->paymentMethod                = 'creditCard';
                $payment->itemDescription1             =  $request->itemDescription1;
                $payment->itemAmount1                  =  $request->itemAmount1;
                $payment->itemQuantity1                = '1';
                $payment->reference                    =  $ultimoIdInscritoReference;
                $payment->senderName                   =  $request->firstName . ' ' . $request->lastName;
                $payment->senderCPF                    =  $request->nDocumento;
                $payment->senderAreaCode               =  $ddd;
                $payment->senderPhone                  =  $phone;
                $payment->senderEmail                  =  $request->email;
                $payment->senderHash                   =  $request->hashCard;
                $payment->shippingAddressStreet        =  $request->endereco;
                $payment->shippingAddressNumber        =  $request->numero;
                $payment->shippingAddressComplement    =  $request->complemento;
                $payment->shippingAddressDistrict      =  $request->bairro;
                $payment->shippingAddressPostalCode    =  $request->cep;
                $payment->shippingAddressCity          =  $request->cidade;
                $payment->shippingAddressState         =  $request->uf;;
                $payment->shippingAddressCountry       =  'BRA';
                $payment->shippingType                 =  '3';
                $payment->shippingCost                 =  '0.00';    
                $payment->creditCardToken               = $request->tokenCard;
                $payment->installmentQuantity           = '1';
                $payment->installmentValue              = $request->itemAmount1;
                $payment->itemDescription1             =  $request->itemDescription1;
                $payment->noInterestInstallmentQuantity = '2';
                $payment->creditCardHolderName          =  $request->cc_name;
                $payment->creditCardHolderCPF           =  $request->cc_cpf;
                $payment->creditCardHolderBirthDate     =  $request->cc_nascimento;
                $payment->senderAreaCode                =  $ddd;
                $payment->senderPhone                   =  $phone;
                $payment->billingAddressStreet          =  $request->endereco;
                $payment->billingAddressNumber          =  $request->numero;
                $payment->billingAddressComplement      =  $request->complemento;
                $payment->billingAddressDistrict        =  $request->bairro;
                $payment->billingAddressPostalCode      =  $request->cep;
                $payment->billingAddressCity            =  $request->cidade;
                $payment->billingAddressState           =  $request->uf;
                $payment->billingAddressCountry         = 'BRA';
                $retornoPagamento = $pagamentoPagSeguro->pagamentoCartao($payment);
                
                if($retornoPagamento['success'] == 1){

                    if(($retornoPagamento['retorno']->status[0] != 3) OR ($retornoPagamento['retorno']->status[0] != 4)){
                        $retorno['success'] = false;
                        $retorno['message'] = "Não foi possível concluir sua transação. Verifique os dados do seu cartão de crédito.";
                        $retorno['classe']  = "alert-warning";
        
                        echo json_encode($retorno);
                        return;
                    }

                    // Salva dados do pagamento.
                    $pagamento = $pagamentoPagSeguro->savePayment($ultimoIdInscritoReference, $retornoPagamento['retorno']->code[0], $retornoPagamento['retorno']->status[0], 'cc');

                    if($pagamento){
                        // Insiro inscrito no banco de dados.
                        $cadastroDeInscrito = new stdClass();
                        $cadastroDeInscrito->firstName  = $request->firstName;
                        $cadastroDeInscrito->lastName   = $request->lastName;
                        $cadastroDeInscrito->nDocumento = $request->nDocumento;
                        $cadastroDeInscrito->email      = $request->email;
                        $cadastroDeInscrito->cep        = $request->cep;
                        $cadastroDeInscrito->bairro     = $request->bairro;
                        $cadastroDeInscrito->cidade     = $request->cidade;
                        $cadastroDeInscrito->uf         = $request->uf;
                        $cadastroDeInscrito->endereco   = $request->endereco;
                        $cadastroDeInscrito->numero     = $request->numero;
                        $cadastroDeInscrito->complemento = $request->complemento;
                        $cadastroDeInscrito->curso_id   = $request->curso_id;
                        $cadastroDeInscrito->status     = 0;
                        $cadastroDeInscrito->phone      = $request->phone;
                        $resultadoCadastro = $cadastrarInscrito->cadastrarInscrito($cadastroDeInscrito);
                    }else{
                        $retorno['success'] = false;
                        $retorno['message'] = "Não foi possível continuar com sua inscrição. Entre em contato com a instituição.";
                        $retorno['classe']  = "alert-warning";
        
                        echo json_encode($retorno);
                        return;
                    }

                    if($retornoPagamento['retorno']->status[0] == 4){
                        $retorno['success'] = false;
                        $retorno['message'] = "Seu pedido está em análise pela sua operadora de cartão de crédito.";
                        $retorno['classe']  = "alert-info";
        
                        echo json_encode($retorno);
                        return;
                    }

                    // Recupero nome do curso para enviar no email.
                    $curso = Curso::find($request->curso_id);

                    /* Crio um usuário na tabela de usuários para acesso futuro do candidato. */
                    $criarUsuarioInscrito   = $criadorDeUsuario->criarUsuario($resultadoCadastro->firstName, $resultadoCadastro->email, $resultadoCadastro->nDocumento, $resultadoCadastro->id);
                    
                    /*Recupero curso que o aluno se inscreveu, para enviar por email  */
                    if ($criarUsuarioInscrito == true) {
                        /* Gero Hash para envio ao inscrito  */
                        $hash               = $criadorDeHash->criarHash($resultadoCadastro->id);
                        $enviarEmail        = $enviarEmail->enviarEmailInscricao($resultadoCadastro->firstName, $resultadoCadastro->email, $curso->curso, $hash->hash);

                        /*Altero o status do inscrito para 1. o Valor 1 quer dizer que ele pagou e falta realizar a redação. */
                        $procura_inscrito = Inscrito::find($resultadoCadastro->id);
                        $procura_inscrito->status = 1;
                        $procura_inscrito->save();
                    }

                    $retorno['success'] = true;
                    $retorno['message'] = "Cadastro Realizado com sucesso. Você receberá por email o link com as instruções para realização do vestibular.";
                    $retorno['classe']  = "alert-success";
                    echo json_encode($retorno);
                    return;
                    
                }else {
                    $retorno['success'] = false;
                    $retorno['message'] = "Não foi possível continuar com sua inscrição. Entre em contato com a instituição.";
                    $retorno['classe']  = "alert-warning";

                    echo json_encode($retorno);
                    return;
                }
        

            }
        }
        

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
