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
                            <li class="breadcrumb-item"><a href="{{ URL::previous() }}">Formulário de Inscrição</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Formulário de Pagamento</li>
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
        <form name="formPagamento" method="POST" action="{{route('inscricao_pagamento')}}">

        
            @csrf

            <div class="row">
                <div class="col-md-12">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">Detalhes do Pagamento</h4>
                    <ul class="list-group mb-3" id="formasDePagamento">
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                          <div>
                            <h6 class="my-0">Taxa de Inscrição</h6>
                            <small class="text-muted">Inscrição para Vestibular AeroTD</small>
                          </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-condensed" >
                            <div>
                                <h6 class="my-0 mb-2">Forma de Pagamento</h6>
                                <div class="ml-4">
                                    <input class="form-check-input" type="radio" name="formaPagamento" id="formaPagamento" value="b">
                                    <label class="form-check-label" for="inlineRadio1">Boleto</label>
                                </div>
                                <div class="ml-4">
                                    <input class="form-check-input" type="radio" name="formaPagamento" id="formaPagamento" value="cc">
                                    <label class="form-check-label" for="inlineRadio2"> Cartão de Crédito</label>
                                </div>
                            </div>
                        </li>
                       
                        
                        <li class="list-group-item d-flex justify-content-between">
                          <span>Total (R$)</span>
                          <strong>R$ 20,00</strong>
                        </li>
                      </ul> 
                </div>
            </div>
            <input type="hidden" id="tokenCard" name="tokenCard" />
            <input type="hidden" id="bandeiraCartao" />
            <input type="hidden" id="hashCard" name="hashCard" />
            <input type="hidden" name="itemDescription1" value="Inscricao Vestibular AeroTD" />
            <input type="hidden" name="itemAmount1" value="20.00" />
            <input type="hidden" name="inscrito_id" value="{{$inscrito->id}}" />
            <input type="hidden" name="curso_id" value="{{$inscrito->curso_id}}" />
            
            <div class="row">
                
                <div class="col-md-12 order-md-1">
                    <!--  Dados para pagamento -->
                    <div id="cartao_credito">

                        <hr class="mb-4">

                        <h4 class="mb-3">Dados de Pagamento</h4>

                        <div class="row">
                            <div class="col-md-5 mb-2">
                                <label for="cc-name">Nome no Cartão</label>
                                <input type="text" class="form-control pagamento_cartao" name="cc_name" id="cc-name"
                                    placeholder="">
                            
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="cc-number">Número do Cartão</label>
                                <input type="text" class="form-control cartao_numero pagamento_cartao"
                                    id="cc-number" placeholder="">
                                <div id="msg"></div>
                                
                            </div>

                            <div class="col-md-3 mb-2">
                                <label for="cc-nascimento">Nasc. Titular</label>
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
                                <label for="cc-expiration">Validade</label>
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

                        <h4 class="mb-1">Endereço de Cobrança</h4>
                        <small class="text-muted">O endereço de cobrança deve ser exatamente igual ao do cartão</small>

                        <div class="row">
                        
                            <div class="col-md-3 mb-3">
                                <label for="zip">CEP</label>
                                <input type="text" class="form-control cep pagamento_cartao" id="cep_cobranca"
                                    name="cep_cobranca" value="{{$inscrito->cep}}">
                        
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="zip">Bairro</label>
                                <input type="text" class="form-control pagamento_cartao" id="bairro_cobranca"
                                    name="bairro_cobranca" value="{{$inscrito->bairro}}">
                                
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="zip">Cidade</label>
                                <input type="text" class="form-control pagamento_cartao" id="cidade_cobranca"
                                    name="cidade_cobranca" value="{{$inscrito->cidade}}">
                                
                            </div>

                            <div class="col-md-2 mb-2">
                                <label for="zip">UF</label>
                                <input type="text" class="form-control pagamento_cartao" id="uf_cobranca"
                                    name="uf_cobranca" value="{{$inscrito->uf}}">
                                
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="zip">Endereço</label>
                                <input type="text" class="form-control pagamento_cartao" id="endereco_cobranca"
                                    name="endereco_cobranca" value="{{$inscrito->endereco}}">
                                
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="zip">Número</label>
                                <input type="text" class="form-control pagamento_cartao" id="numero_cobranca"
                                    name="numero_cobranca" value="{{$inscrito->numero}}">
                                
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="zip">Complemento</label>
                                <input type="text" class="form-control pagamento_cartao" id="complemento_cobranca"
                                    name="complemento_cobranca" value="{{$inscrito->complemento}}">

                            </div>

                        </div>

                        <hr class="mb-4">
                    </div>

                    <div id='loader' style='display: none; margin-bottom:20px;'>
                        <div class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Carregando...</span>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary btn-lg btn-block" type="submit" id="enviarFormulario">Confirmar Pagamento</button>

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
<!--<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>-->
<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
<script type="text/javascript" charset="utf-8">
    $("#formasDePagamento").hide();
    $("#enviarFormulario").hide();
    gerarTokenPagamento();

    function gerarTokenPagamento(){
        $.ajax({
            url: "{{ route('credenciais') }}",
            type: "GET",
            dataType: 'json',
            beforeSend: function(){
                $("#loader").show();
            },
            success: function(response){    
                console.log(response.id);
                PagSeguroDirectPayment.setSessionId(response.id);
            }, complete: function (response){
                $("#loader").hide();
                $("#formasDePagamento").show();
            }
        });
    }

    $('.cartao_numero').keyup(function(){
        pagseguroValidateCard(this, false);
    });
    
    $('.cartao_numero').focusout(function(){
        pagseguroValidateCard(this, true);
    });

    function pagseguroValidateCard (element, bypassLengthTest) {
        $('#tokenCard').val('');
        var cardNum = $(element).val().replace(/[^\d.]/g, '');
        var card_invalid = 'Validamos os primeiros 6 números do seu cartão de crédito e está inválido. Por favor esvazie o campo e tente digitar de novo.';

        if (cardNum.length == 6 || (bypassLengthTest && cardNum.length >= 6)) {
            PagSeguroDirectPayment.getBrand({
                cardBin: cardNum.substr(0, 6),
                success: function(response) {
                    if (typeof response.brand.name != 'undefined') {
                        $('#bandeiraCartao').val(response.brand.name);
                    }else{
                        $('#msg').empty();
                        alert(card_invalid);
                    }
                },
                error: function(response) {
                    console.log(card_invalid);
                }
            });
        }
    }
 
    function getTokenCard() {
        $( '#validationSignup' ).html('');
        var result = $(".data-expiracao").val().split('/');
        var ano = result[1];
        var mes = result[0];    

        var senderHash = PagSeguroDirectPayment.getSenderHash();
        $('#hashCard').val(senderHash);
     
        if ($('#tokenCard').val().length == 0) {
            var param = {
                cardNumber: $("#cc-number").val(),
                brand: $("#bandeiraCartao").val(),
                cvv: $("#cc-cvv").val(),
                expirationMonth: mes,
                expirationYear: "20"+ano,
                success: function(response){
                    console.log('suc ' + JSON.stringify(response));
                    $("#tokenCard").val(response.card.token)
                },
                error: function(response){
                    errorsHtml = '<div class="alert alert-danger"><ul>';
                    if(undefined!=response.errors["30400"]) {
                        errorsHtml += '<li>Dados do cartão inválidos.</li>';
                    }else if(undefined!=response.errors["10001"]){
                        errorsHtml += '<li>Tamanho do cartão inválido.</li>';
                    }else if(undefined!=response.errors["10006"]){
                        errorsHtml += '<li>Tamanho do CVV inválido.</li>';
                    }else if(undefined!=response.errors["30405"]){
                        errorsHtml += '<li>Data de validade incorreta.</li>';
                    }else if(undefined!=response.errors["30403"]){
                        errorsHtml += '<li>Atualizar página.</li>';
                    }else{
                        errorsHtml += '<li>Verifique os dados do cartão digitado.</li>';
                    }
                    errorsHtml += '</ul></div>';
                    
                    $( '#validationSignup' ).html( errorsHtml ); 
                    console.log('Falha ao obter o token do cartao.');
                    console.log(response.errors);
                
                },
                complete: function(response){
                    console.log('comp' + JSON.stringify(response));
                    $("#retornoTransacao").val(JSON.stringify(response));
                
                }
            }

            PagSeguroDirectPayment.createCardToken(param);
        }
    }


    $(".cvv").on('blur touchend', function(){
        getTokenCard();
        $("#enviarFormulario").show();
    });

    $("#enviarFormulario").one('click touchstart', function() {
        doPayment(); 
    });

    function doPayment(){
        $('form[name=formPagamento]').submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{ route('inscricao_pagamento') }}",
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

        $("input[type='radio']").on('click touchstart', function(){
            
            var forma_pagamento = $("input[name='formaPagamento']:checked").val();
            console.log(forma_pagamento);
            if(forma_pagamento=='b'){
                $("#cartao_credito").css('display', 'none');
                $(".pagamento_cartao").removeAttr('required');
                $("#enviarFormulario").show();
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
        });
</script>
@endsection