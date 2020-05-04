@extends('layout.app')


@section('conteudo')
<form name='formPagamento'>
    @csrf
    <!--  Dados para pagamento -->
    <div id="cartao_credito">

        <hr class="mb-4">
        <h4 class="mb-3">Dados de Pagamento</h4>
        <input type="text" id="tokenCard" name="tokenCard" />
        <input type="text" id="bandeiraCartao" />
        <input type="text" id="hashCard" name="hashCard" />
        <span class="bandeira-cartao"></span><br><br>
        <div id="msg"></div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="cc-name">Nome no Cartão</label>
                <input type="text" class="form-control pagamento_cartao" id="cc-name" placeholder="">
                <small class="text-muted">Nome completo exatamente como no cartão</small>
                <div class="invalid-feedback">
                    O campo <strong>Nome no Cartão</strong> é obrigatório.
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <label for="cc-number">Número do Cartão</label>
                <input type="text" class="form-control cartao_numero pagamento_cartao" value="4111111111111111" id="cc-number">
                <div class="invalid-feedback">
                    O campo <strong>Número do Cartão</strong> é obrigatório.
                </div>
            </div>

            <div class="col-md-2 mb-2">
                <label for="cc-expiration">Expiração</label>
                <input type="text" class="form-control data-expiracao pagamento_cartao" id="cc-expiration"
                    placeholder="">
                <div class="invalid-feedback">
                    O campo <strong>Data de Expiração</strong> é obrigatório.
                </div>
            </div>
            <div class="col-md-2 mb-2">
                <label for="cc-cvv">CVV</label>
                <input type="text" class="form-control cvv pagamento_cartao" id="cc-cvv" value="123">
                <div class="invalid-feedback">
                    O campo <strong>CVV</strong> é obrigatório.
                </div>
            </div>
        </div>
        <hr class="mb-4">
    </div>

    <button class="btn btn-primary btn-lg btn-block" type="submit" id="enviarFormulario">Enviar Formulário</button>
</form>
@endsection

@section('scripts')
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

    $('#cc-number').on('keyup', function () {
       
        //Receber o número do cartão digitado pelo usuário
        var numCartao = $(this).val();
    
        //Contar quantos números o usuário digitou
        var qntNumero = numCartao.length;

        //Validar o cartão quando o usuário digitar 6 digitos do cartão
        if (qntNumero == 6) {
            
            //Instanciar a API do PagSeguro para validar o cartão
            PagSeguroDirectPayment.getBrand({
                cardBin: numCartao,
                success: function (retorno) {
                    $('#msg').empty();
                    //Enviar para o index a imagem da bandeira
                    var imgBand = retorno.brand.name;
                    $('.bandeira-cartao').html("<img src='https://stc.sandbox.pagseguro.uol.com.br/public/img/payment-methods-flags/42x20/" + imgBand + ".png' />");
                    $('#bandeiraCartao').val(imgBand);
                },
                error: function (retorno) {
                    //Enviar para o index a mensagem de erro
                    $('.bandeira-cartao').empty();
                    $('#msg').html("Cartão inválido");
                }
            });
        }
    });

    function getTokenCard() {
        PagSeguroDirectPayment.createCardToken({
            cardNumber:      $("#cc-number").val(), // Número do cartão de crédito
            brand:           'visa', // Bandeira do cartão
            cvv:             $("#cc-cvv").val(), // CVV do cartão
            expirationMonth: '12', // Mês da expiração do cartão
            expirationYear: '2026', // Ano da expiração do cartão, é necessário os 4 dígitos.
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
        getTokenCard();
        senderHashReady();
    });
    
    $("#enviarFormulario").click(function (){
        doPayment(); 
    })
  

    function doPayment(){
        $('form[name=formPagamento]').submit(function(event){
            event.preventDefault();

            $.ajax({
                url: "{{ route('payment') }}",
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){
                    console.log(response);
                }
            });
        });
    }


   
</script>
@endsection