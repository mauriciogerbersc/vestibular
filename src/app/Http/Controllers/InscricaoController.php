<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Curso;
use App\Inscrito;
use App\Payment;
use Illuminate\Support\Facades\Hash;
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
        $this->middleware('auth:admin')->except(['index', 'inscricao', 'create', 'store', 'confirmacao', 'payment', 'checkCadastro', 'testa']);
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
    public function store(Request $request, EnvioDeEmail $enviarEmail, PagamentoPagSeguro $pagamentoPagSeguro)
    {
        
        // Recupera dados do inscrito para finalizar pagametno
        $dadosInscrito = Inscrito::find($request->inscrito_id);

        // Definindo telefones para formato PagSeguro;
        $telefone = preg_split("/\(|\)/", $dadosInscrito->phone);
        $ddd = $telefone[1];
        $phone = str_replace("-","",trim($telefone[2]));
   
        if ($request->formaPagamento == 'b') {
            $payment = new stdClass();
            $payment->paymentMethod                = 'boleto';
            $payment->itemDescription1             =  $request->itemDescription1;
            $payment->itemAmount1                  =  $request->itemAmount1;
            $payment->itemQuantity1                = '1';
            $payment->reference                    =  $request->inscrito_id;
            $payment->senderName                   =  $dadosInscrito->firstName . ' ' . $dadosInscrito->lastName;
            $payment->senderCPF                    =  $dadosInscrito->nDocumento;
            $payment->senderAreaCode               =  $ddd;
            $payment->senderPhone                  =  $phone;
            $payment->senderEmail                  =  $dadosInscrito->email;
            $payment->senderHash                   =  $request->hashCard;
            $payment->shippingAddressStreet        =  $dadosInscrito->endereco;
            $payment->shippingAddressNumber        =  $dadosInscrito->numero;
            $payment->shippingAddressComplement    =  $dadosInscrito->complemento;
            $payment->shippingAddressDistrict      =  $dadosInscrito->bairro;
            $payment->shippingAddressPostalCode    =  $dadosInscrito->cep;
            $payment->shippingAddressCity          =  $dadosInscrito->cidade;
            $payment->shippingAddressState         =  $dadosInscrito->uf;;
            $payment->shippingAddressCountry       =  'BRA';
            $payment->shippingType                 =  '3';
            $payment->shippingCost                 =  '0.00';    
            $payment->creditCardToken               = $request->tokenCard;
            $payment->installmentQuantity           = '1';
            $payment->installmentValue              = $request->itemAmount1;
            $payment->noInterestInstallmentQuantity = '2';
            $retornoPagamento = $pagamentoPagSeguro->pagamentoBoleto($payment);
           // print_r($retornoPagamento);exit;
            if($retornoPagamento['success'] == 1){
                
                // Salva dados do pagamento.
                $pagamentoPagSeguro->savePayment(
                    $request->inscrito_id, 
                    $retornoPagamento['retorno']->code[0], 
                    $retornoPagamento['retorno']->status[0], 
                    'b'
                );
              
                // Recupero nome do curso para enviar no email.
                $curso = Curso::find($request->curso_id);
                // recupero link do boleto pra enviar pro email.
                $link_boleto = $retornoPagamento['retorno']->paymentLink[0];

                $enviarEmail        = $enviarEmail->emailBoleto($dadosInscrito->firstName, $dadosInscrito->email, $curso->curso, $link_boleto);
                
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
            $payment->reference                    =  $request->inscrito_id;
            $payment->senderName                   =  $dadosInscrito->firstName . ' ' . $dadosInscrito->lastName;
            $payment->senderCPF                    =  $dadosInscrito->nDocumento;
            $payment->senderAreaCode               =  $ddd;
            $payment->senderPhone                  =  $phone;
            $payment->senderEmail                  =  $dadosInscrito->email;
            $payment->senderHash                   =  $request->hashCard;
            $payment->shippingAddressStreet        =  $dadosInscrito->endereco;
            $payment->shippingAddressNumber        =  $dadosInscrito->numero;
            $payment->shippingAddressComplement    =  $dadosInscrito->complemento;
            $payment->shippingAddressDistrict      =  $dadosInscrito->bairro;
            $payment->shippingAddressPostalCode    =  $dadosInscrito->cep;
            $payment->shippingAddressCity          =  $dadosInscrito->cidade;
            $payment->shippingAddressState         =  $dadosInscrito->uf;;
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
            $payment->billingAddressStreet          =  $request->endereco_cobranca;
            $payment->billingAddressNumber          =  $request->numero_cobranca;
            $payment->billingAddressComplement      =  $request->complemento_cobranca;
            $payment->billingAddressDistrict        =  $request->bairro_cobranca;
            $payment->billingAddressPostalCode      =  $request->cep_cobranca;
            $payment->billingAddressCity            =  $request->cidade_cobranca;
            $payment->billingAddressState           =  $request->uf_cobranca;
            $payment->billingAddressCountry         = 'BRA';
            $retornoPagamento = $pagamentoPagSeguro->pagamentoCartao($payment);
            
            if($retornoPagamento['success'] == 1){
                // Salva dados do pagamento.
                $pagamentoPagSeguro->savePayment(
                    $request->inscrito_id, 
                    $retornoPagamento['retorno']->code[0], 
                    $retornoPagamento['retorno']->status[0], 
                    'cc'
                );

                $retorno['success'] = true;
                $retorno['message'] = "Seu pedido está em análise junto a sua operadora de cartão de crédito. Você receberá pelo email informado o retorno da transação.";
                $retorno['classe']  = "alert-success";
                echo json_encode($retorno);
                return;

            } else {
                $retorno['success'] = false;
                $retorno['message'] = "Não foi possível continuar com sua inscrição. Entre em contato com a instituição.";
                $retorno['classe']  = "alert-warning";

                echo json_encode($retorno);
                return;
            }
    

        } 

    }

    public function testa(){
        $cpf = trim("05958703501");
        $cpf = Hash::make($cpf);
        echo $cpf;
    }

    public function payment(Request $request, CadastroInscrito $cadastrarInscrito){
      
        // Validações de formulário.
        $rules = [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|unique:inscritos',
            'nDocumento'  => 'required',
            'phone' => 'required',
            'historico_escolar'  => 'required|mimes:doc,docx,pdf,png,jpg,jpeg,img|max:2048',
            'cep' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'uf' => 'required',
            'endereco' => 'required',
            'numero' => 'required'
        ];

        $messages = [
            'firstName.required' => 'O campo nome é obrigatório',
            'lastName.required' => 'O campo sobrenome é obrigatório',
            'email.required' => 'O campo Email é obrigatório',
            'email.unique'   => 'O email já está registrado na base de dados',
            'nDocumento.required' => 'O campo nº Documento é obrigatório',
            'phone.required' => 'O campo telefone é obrigatório',
            'historico_escolar.required' => 'O campo histórico escolar é obrigatório',
            'historico_escolar.mimes' => 'O arquivo enviado deve ter as seguintes extensões: doc, docx, pdf, jpg, jpeg, png, img.',
            'historico_escolar.max'  => 'O tamanho máximo permitido para o histórico escolar é 2MB (2048 KB). Se você está enviando uma foto, tente reduzir a resolução e tente novamente.',
            'cep.required' => 'O campo CEP é obrigatório',
            'bairro.required' => 'O campo bairro é obrigatório',
            'cidade.required' => 'O campo cidade é obrigatório',
            'uf.required' => 'O campo UF é obrigatório',
            'endereco.required' => 'O campo endereço é obrigatório',
            'numero.required' => 'O campo número é obrigatório'
        ];

        $validator = $request->validate($rules, $messages);
        
          // Realizo upload do histórico escolar
          if($request->hasFile('historico_escolar')){
            $historico = $request->file('historico_escolar');

            $name                     = $historico->getClientOriginalName();
            $name_sem_extensao        = pathinfo($name, PATHINFO_FILENAME);
            $extension                = $historico->getClientOriginalExtension();
            $fileNameToStore          = uniqid().'_'.time().'.'.$extension;
            $historico->move(public_path().'/files/historicos/', $fileNameToStore);
        }

        // Cadastro o inscrito no banco de dados
        $cadastroDeInscrito              = new stdClass();
        $cadastroDeInscrito->firstName   = $request->firstName;
        $cadastroDeInscrito->lastName    = $request->lastName;
        $cadastroDeInscrito->nDocumento  = $request->nDocumento;
        $cadastroDeInscrito->email       = $request->email;
        $cadastroDeInscrito->cep         = $request->cep;
        $cadastroDeInscrito->bairro      = $request->bairro;
        $cadastroDeInscrito->cidade      = $request->cidade;
        $cadastroDeInscrito->uf          = $request->uf;
        $cadastroDeInscrito->endereco    = $request->endereco;
        $cadastroDeInscrito->numero      = $request->numero;
        $cadastroDeInscrito->complemento = $request->complemento;
        $cadastroDeInscrito->historico   = $fileNameToStore;
        $cadastroDeInscrito->curso_id    = $request->curso_id;
        $cadastroDeInscrito->status      = 0;
        $cadastroDeInscrito->phone       = $request->phone;
        $inscrito                      = $cadastrarInscrito->cadastrarInscrito($cadastroDeInscrito);

        // Recupera ID do inscrito.
        $id_inscrito                     = $inscrito->id;

        // Redirect para o pagamento
        return view('inscricao.pagamento', compact('inscrito'));
        
    }
  

    public function checkCadastro(Request $request){
         // Validações de formulário.
         $rules = [
            'cpfCadastrado' => 'required',
        ];

        $messages = [
            'cpfCadastrado.required' => 'O Documento Inscrito é obrigatório.',
        ];

        $validator = $request->validate($rules, $messages);

        $inscrito = Inscrito::where('nDocumento', '=', $request->cpfCadastrado)->first();
        if(!$inscrito){
            $request->session()->flash('mensagem', "Seu CPF não foi encontrado na base dados.");
            return redirect()->back();
           // return redirect()->back()->withErrors(['error' => 'Seu CPF não foi encontrado na base dados.']);   
        }

        return view('inscricao.pagamento', compact('inscrito'));
    }
}
