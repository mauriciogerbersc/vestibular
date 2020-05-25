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
        <div class="row">
            <div class="col-md-3 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    Já tem cadastro?
                </h4>
                
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">Formulário cadastrado</h6>
                            <small class="text-muted">Caso já tenha cadastro, informe o seu CPF abaixo.</small>
                        </div>
                    </li> 
                    <li class="list-group-item">
                        <form action="{{route('temCadastro')}}" method="post">
                            @csrf
                            <input type="text" name="cpfCadastrado" placeholder="Nº doc" class="form-control @error('cpfCadastrado') is-invalid @enderror cpfCadastrado" />
                            <br><button class="btn btn-primary btn-block" type="submit" id="enviarFormulario">Acessar</button>
                        </form>
                    </li>
                    
                </ul>
            </div>

            <div class="col-md-9 order-md-1">
                    
                <form action="{{route('inscricaoPayment')}}" method="POST" enctype="multipart/form-data"  files="true">
                    @csrf
                    <input type="hidden" name="curso_id" value="{{$curso->id}}" />
                    <div class="row">
                        <!--  Dados Pessoais do Aluno -->
                        <div class="col-md-12 order-md-1">
                            <h4 class="mb-3">Dados do Aluno</h4>
                                <!-- dados pessoais -->
                                <div class="row">

                                    <div class="col-md-4 mb-3">
                                        <label for="firstName">Primeiro Nome</label>
                                        <input type="text"
                                            class="form-control @error('firstName') is-invalid @enderror firstName"
                                            id="firstName" name="firstName" placeholder="" value="{{ old('firstName') }}">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="lastName">Sobrenome</label>
                                        <input type="text" class="form-control @error('lastName') is-invalid @enderror lastName"
                                            id="lastName" name="lastName" placeholder="" value="{{ old('lastName') }}">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="documento">CPF</label>
                                        <input type="text" class="form-control @error('nDocumento') is-invalid @enderror cpf" id="cpf"
                                            name="nDocumento" value="{{ old('nDocumento') }}">
                                    </div>

                                </div>

                                <!-- dados para contato -->
                                <div class="row">

                                    <div class="col-md-6 mb-6">
                                        <label for="telefone">Telefone para contato</label>
                                        <input type="text"  value="{{ old('phone') }}" class="form-control 
                                        @error('phone') is-invalid @enderror phone" id="phone" name="phone">
                                        
                                    
                                    </div>

                                    <div class="col-md-6 mb-6">
                                        <label for="email">Email</label>
                                        <input type="email" value="{{ old('email') }}"
                                            class="form-control  @error('email') is-invalid @enderror" id="email" name="email">

                                    </div>

                                </div>

                                <hr class="mb-4">
                                <h4 class="mb-3">Histórico Escolar</h4>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="historico">Anexar</label>
                                        <div class="custom-file">
                                            
                                            <input type="file" class="custom-file-input @error('historico_escolar') is-invalid @enderror" id="historico_escolar" name="historico_escolar">
                                            <label class="custom-file-label" for="customFile">Escolha o Arquivo</label>
                                        </div>
                                    </div>
                                </div>

                                <hr class="mb-4">
                                <h4 class="mb-3">Endereço</h4>

                                <div class="row">

                                    <div class="col-md-3 mb-3">
                                        <label for="zip">CEP</label>
                                        <input type="text" value="{{ old('cep') }}" class="form-control cep  @error('cep') is-invalid @enderror" id="cep" name="cep">
                                        
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="bairro">Bairro</label>
                                        <input type="text" value="{{ old('bairro') }}" class="form-control  @error('bairro') is-invalid @enderror" id="bairro" name="bairro">
                                        
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="cidade">Cidade</label>
                                        <input type="text" value="{{ old('cidade') }}" class="form-control  @error('cidade') is-invalid @enderror" id="cidade" name="cidade">
                                        
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        <label for="uf">UF</label>
                                        <input type="text" value="{{ old('uf') }}" class="form-control  @error('uf') is-invalid @enderror" id="uf" name="uf">
                                        
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-5 mb-3">
                                        <label for="endereco">Endereço</label>
                                        <input type="text" value="{{ old('endereco') }}" class="form-control  @error('endereco') is-invalid @enderror" id="endereco" name="endereco">
                                        
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="numero">Número</label>
                                        <input type="text" value="{{ old('numero') }}" class="form-control  @error('numero') is-invalid @enderror" id="numero" name="numero">
                                        
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="complemento">Complemento</label>
                                        <input type="text" value="{{ old('complemento') }}" class="form-control " id="complemento" name="complemento">
                                        
                                    </div>

                                </div>

                                <hr class="mb-4">

                                
                                    
                                @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>Ops!</strong> Alguns campos não foram preenchidos corretamente.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                    @endif
                            
                                <button class="btn btn-primary btn-lg btn-block" type="submit" id="enviarFormulario">Continue para Pagamento</button>
                                <small style="color:red;font-style:italic;">* Para efetuar a sua INSCRIÇÃO PARA VESTIBULAR será cobrada uma taxa de <strong>R$ 20,00</strong></small>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</section>
@endsection


@section('scripts')

<script src="{{asset('assets/js/jquery.mask.js')}}"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
 
        $(".cpf").mask("99999999999");
        $('.cep').mask('99999-999');
        $('.nascimento').mask('99/99/9999');
     
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