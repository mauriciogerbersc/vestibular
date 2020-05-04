@extends('layout/app')

@section('conteudo')

<section class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content text-center">
                    <h2>Inscrição Para Vestibular</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Página Inicial</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::previous() }}">{{$curso->curso}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Inscrição Para Vestibular</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>



<section class="single-wrap-layout">
    <div class="container">
        <!--<form method="POST" action="/inscricao/store"> -->
        <form name="formPagamento">
            @csrf
            <input type="text" id="tokenCard" name="tokenCard" />
            <input type="text" id="bandeiraCartao" />
            <input type="text" id="hashCard" name="hashCard" />
            <input type="text" name="itemDescription1" value="Inscrição Vestibular AeroTD" />
            <input type="text" name="itemAmount1" value="15.00" />

            <input type="hidden" name="curso_id" value="{{$curso->id}}" />
            <div class="row">

                <div class="col-md-3 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Dados da Compra</span>
                    </h4>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">Taxa de Inscrição</h6>
                                <small class="text-muted">Taxa Inscrição para Vestibular</small>
                            </div>
                            <span class="text-muted">R$ 20</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0">Escolha sua forma de pagamento:</h6>
                                <br>
                            </div><br>

                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <input type="radio" name="formaPagamento" value="b" /> Boleto <br>
                                <input type="radio" name="formaPagamento" value="cc" /> Cartão de Crédito
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (R$)</span>
                            <strong>R$ 15</strong>
                        </li>
                    </ul>

                </div>

                <!-- 
            Dados Pessoais do Aluno
        -->
                <div class="col-md-9 order-md-1">
                    <h4 class="mb-3">Dados do Aluno</h4>
                    <form class="needs-validation" novalidate>
                        <!-- dados pessoais -->
                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label for="firstName">Primeiro Nome</label>
                                <input type="text"
                                    class="form-control @error('firstName') is-invalid @enderror firstName"
                                    id="firstName" name="firstName" placeholder="" value="{{ old('firstName') }}">
                                @error('cpf')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="lastName">Sobrenome</label>
                                <input type="text" class="form-control @error('lastName') is-invalid @enderror lastName"
                                    id="lastName" name="lastName" placeholder="" value="{{ old('lastName') }}">
                                @error('cpf')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="documento">CPF</label>
                                <input type="text" class="form-control @error('cpf') is-invalid @enderror cpf" id="cpf"
                                    name="nDocumento" value="{{ old('cpf') }}">

                                @error('cpf')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>

                        <!-- dados para contato -->
                        <div class="row">

                            <div class="col-md-6 mb-6">
                                <label for="telefone">Telefone para contato</label>
                                <input type="text" class="form-control phone" id="phone" name="phone">
                               
                            </div>

                            <div class="col-md-6 mb-6">
                                <label for="email">Email</label>
                                <input type="email" value="{{ old('email') }}"
                                    class="form-control  @error('email') is-invalid @enderror" id="email" name="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>

                        <hr class="mb-4">

                        <h4 class="mb-3">Endereço</h4>

                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <label for="zip">CEP</label>
                                <input type="text" class="form-control cep" id="cep" name="cep">
                                
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="bairro">Bairro</label>
                                <input type="text" class="form-control" id="bairro" name="bairro">
                               
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="cidade">Cidade</label>
                                <input type="text" class="form-control" id="cidade" name="cidade">
                               
                            </div>

                            <div class="col-md-2 mb-2">
                                <label for="uf">UF</label>
                                <input type="text" class="form-control" id="uf" name="uf">
                              
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="endereco">Endereço</label>
                                <input type="text" class="form-control" id="endereco" name="endereco">
                              
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="numero">Número</label>
                                <input type="text" class="form-control" id="numero" name="numero">
                              
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="complemento">Complemento</label>
                                <input type="text" class="form-control" id="complemento" name="complemento">
                              
                            </div>

                        </div>

                        <!--  Dados para pagamento -->
                        <div id="cartao_credito">

                            <hr class="mb-4">
                            <h4 class="mb-3">Dados de Pagamento</h4>

                            <div class="row">
                                <div class="col-md-5 mb-5">
                                    <label for="cc-name">Nome no Cartão</label>
                                    <input type="text" class="form-control pagamento_cartao" name="cc_name" id="cc-name"
                                        placeholder="">
                                    <small class="text-muted">Nome completo exatamente como no cartão</small>
                                  
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="cc-number">Número do Cartão</label>
                                    <input type="text" class="form-control cartao_numero pagamento_cartao"
                                        id="cc-number" placeholder="">
                                    <div id="msg"></div>
                                    
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="cc-nascimento">Nascimento Titular</label>
                                    <input type="text" class="form-control nascimento"
                                        id="cc-nascimento" name="cc_nascimento" placeholder="">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-6">
                                    <label for="cc-name">CPF Titular</label>
                                    <input type="text" class="form-control cpf" maxlength="11" name="cc_cpf" id="cc-cpf" placeholder="">
                                  
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="cc-expiration">Expiração</label>
                                    <input type="text" class="form-control data-expiracao pagamento_cartao"
                                        id="cc-expiration" placeholder="">
                                  
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="cc-cvv">CVV</label>
                                    <input type="text" class="form-control cvv pagamento_cartao" id="cc-cvv"
                                        placeholder="">
                                 
                                </div>
                            </div>
                            <hr class="mb-4">

                            <h4 class="mb-3">Endereço de Cobrança</h4>

                            <div class="d-block my-3">
                                <div class="custom-control custom-radio">
                                    <input id="credit" name="confirmaEndereco" id="confirmaEndereco" type="checkbox"
                                        class="custom-control-input pagamento_cartao">
                                    <label class="custom-control-label" for="credit">O endereço de cobrança é o mesmo que o do aluno?</label>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-3 mb-3">
                                    <label for="zip">CEP</label>
                                    <input type="text" class="form-control cep pagamento_cartao" id="cep_cobranca"
                                        name="cep_cobranca">
                            
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="zip">Bairro</label>
                                    <input type="text" class="form-control pagamento_cartao" id="bairro_cobranca"
                                        name="bairro_cobranca">
                                  
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="zip">Cidade</label>
                                    <input type="text" class="form-control pagamento_cartao" id="cidade_cobranca"
                                        name="cidade_cobranca">
                                 
                                </div>

                                <div class="col-md-2 mb-2">
                                    <label for="zip">UF</label>
                                    <input type="text" class="form-control pagamento_cartao" id="uf_cobranca"
                                        name="uf_cobranca">
                                    
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label for="zip">Endereço</label>
                                    <input type="text" class="form-control pagamento_cartao" id="endereco_cobranca"
                                        name="endereco_cobranca">
                                  
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="zip">Número</label>
                                    <input type="text" class="form-control pagamento_cartao" id="numero_cobranca"
                                        name="numero_cobranca">
                                   
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="zip">Complemento</label>
                                    <input type="text" class="form-control pagamento_cartao" id="complemento_cobranca"
                                        name="complemento_cobranca">

                                </div>

                            </div>
                        </div>
                        <hr class="mb-4">

                        <div id='loader' style='display: none; margin-bottom:20px;'>
                            <div class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-lg btn-block" type="submit" id="enviarFormulario">Continue para Pagamento</button>

                        
                        <div class="alert  alert-dismissible fade show d-none messageBox mt-4" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="mt-4" id="validationSignup"></div>
                </div>


            </div>
        </form>
    </div>
</section>
@endsection


@section('scripts')

<script src="{{asset('assets/js/jquery.mask.js')}}"></script>
<script src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
<script type="text/javascript" charset="utf-8">
    gerarTokenPagamento();
   

    function gerarTokenPagamento(){
        $.ajax({
            url: "{{ route('credenciais') }}",
            type: "GET",
            dataType: 'json',
            success: function(response){    
                PagSeguroDirectPayment.setSessionId(response.id);
            }, complete: function (response){
                console.log(PagSeguroDirectPayment);
            }
        });
    }


    function getTokenCard() {

        var result = $(".data-expiracao").val().split('/');
        var ano = result[1];
        var mes = result[0];
        PagSeguroDirectPayment.createCardToken({
            cardNumber:      $("#cc-number").val(), // Número do cartão de crédito
            brand:           $("#bandeiraCartao").val(), // Bandeira do cartão
            cvv:             $("#cc-cvv").val(), // CVV do cart�o
            expirationMonth: mes, // M�s da expira��o do cart�o
            expirationYear:  ano, // Ano da expira��o do cart�o, � necess�rio os 4 dígitos.
            success: function(response) {
                $("#tokenCard").val(response.card.token);
            },
            error: function(response) {
                console.log('erro ' + response)
            },
            complete: function(response) {
                $("#tokenCard").val(response.card.token);
            }
        });

        var df      = new $.Deferred();
        setTimeout(function(){
            console.log('Token Card');
        },3000);
         
        return df.promise();
    }


    
    $('#cc-number').on('keyup', function () {
       
       //Receber o número do cart�o digitado pelo usu�rio
       var numCartao = $(this).val();
   
       //Contar quantos números o usu�rio digitou
       var qntNumero = numCartao.length;

       //Validar o cart�o quando o usu�rio digitar 6 digitos do cart�o
       if (qntNumero == 6) {
           
           //Instanciar a API do PagSeguro para validar o cart�o
           PagSeguroDirectPayment.getBrand({
               cardBin: numCartao,
               success: function (retorno) {
                   $('#msg').empty();
                   //Enviar para o index a imagem da bandeira
                   var imgBand = retorno.brand.name;
                   $('#bandeiraCartao').val(imgBand);
               },
               error: function (retorno) {
                   //Enviar para o index a mensagem de erro
                   $('#msg').html("Cart�o inv�lido");
               }
           });
       }
   });



    function senderHashReady() {

        PagSeguroDirectPayment.onSenderHashReady(function (response){
            if(response.status == 'error'){
                console.log(response.message);
                return false;
            }
            $("#hashCard").val(response.senderHash);
        });

        var df      = new $.Deferred();
        setTimeout(function(){
            console.log('Hash card');
        },3000);
        
        return df.promise();
    }

    $(".cartao_numero").blur(function(){
        senderHashReady();
    });

    $(".cvv").blur(function(){
        getTokenCard();
    });

    $("#enviarFormulario").one('click', function() {
        doPayment(); 
    });

    function doPayment(){
        $('form[name=formPagamento]').submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{ route('inscricao_aluno') }}",
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function(){
                    $("#loader").show();
                    $("#validationSignup").addClass('d-none');
                    $(".messageBox").addClass('d-none');
                },
                error: function (data) {
                    if( data.status === 422) {
                        var erros = data.responseJSON; 
                        errorsHtml = '<div class="alert alert-danger"><ul>';
                        $.each( erros.errors , function( key, value ) {
                            errorsHtml += '<li>' + value[0] + '</li>'; 
                        });
                        errorsHtml += '</ul></div>';
                        $( '#validationSignup' ).html( errorsHtml ); 
                        $("#validationSignup").removeClass('d-none');
                    }
                },
                success: function(data) {
            
                    if(data.success === true){
                       console.log('sucess');
                       $('.messageBox').removeClass('d-none').html(data.message);
                       $("#enviarFormulario").addClass('d-none');
                       $(".messageBox").addClass(data.classe);
                      
                    }else{
                       $('.messageBox').removeClass('d-none').html(data.message);
                       $(".messageBox").addClass(data.classe);
                       $("#enviarFormulario").removeClass('d-none');
                    }
                },
                complete:function(data){
                    $("#loader").hide();
                }
            });
        });
    }


    $(document).ready(function(){

        $("#cartao_credito").css('display', 'none');

        $("#enviarFormulario").click(function(e){

            var check_forma_pagamento = $("input[name='formaPagamento']:checked").length;
            if (check_forma_pagamento == 0) {
                alert('Escolha uma forma de pagamento');
                return false;
            }

        });

        $("input[type='radio']").click(function(){
            var forma_pagamento = $("input[name='formaPagamento']:checked").val();
            if(forma_pagamento=='b'){
                $("#cartao_credito").css('display', 'none');
                $(".pagamento_cartao").removeAttr('required');
            }else{
                $("#cartao_credito").css('display', '');
                $(".pagamento_cartao").attr('required', 'pagamento_cartao');
            }
        });
        
         
        $(".cpf").mask("99999999999");
        $('.cep').mask('99999-999');
        $('.cvv').mask('999');
        $('.nascimento').mask('99/99/9999');
        $('.cartao_numero').mask('9999999999999999');
        $('.data-expiracao').mask('99/9999');

        var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        spOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
            }
        };

        $('.phone').mask(SPMaskBehavior, spOptions);
    });

    $(function () {
      
            function limpa_formulario_cep() {
                // Limpa valores do formul�rio de cep.
                $("#endereco").val("");
                $("#cidade").val("");
                $("#bairro").val("");
                $("#uf").val("");
            }

            'use strict'

            $(".cep").blur(function () {
                var cep = $(this).val().replace(/\D/g, '');
                //Verifica se campo cep possui valor informado.
                if (cep != "") {
                    //Express�o regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;
                    //Valida o formato do CEP.
                    if (validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#endereco").val("...");
                        $("#cidade").val("...");
                        $("#bairro").val("...");
                        $("#uf").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#endereco").val(dados.logradouro);
                                $("#cidade").val(dados.localidade);
                                $("#uf").val(dados.uf);
                                $("#bairro").val(dados.bairro);
                            } //end if.
                            else {
                                //CEP pesquisado n�o foi encontrado.
                                limpa_formulario_cep();
                                alert("CEP n�o encontrado.");
                            }
                        });
                    } else {
                        //cep � inv�lido.
                        limpa_formulario_cep();
                        alert("Formato de CEP inv�lido.");
                    }
                } else {
                    //cep sem valor, limpa formul�rio.
                    limpa_formulario_cep();
                }
            });

            $('input[type="checkbox"]').click(function () {
                if($(this).is(":checked")){
                    $("#endereco_cobranca").val($("#endereco").val());
                    $("#cep_cobranca").val($("#cep").val());
                    $("#bairro_cobranca").val($("#bairro").val());
                    $("#cidade_cobranca").val($("#cidade").val());
                    $("#uf_cobranca").val($("#uf").val());
                    $("#numero_cobranca").val($("#numero").val());
                    $("#complemento_cobranca").val($("#complemento").val());
                }
            });
        });
</script>
@endsection