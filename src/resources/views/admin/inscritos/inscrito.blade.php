@extends('admin/layout/admin', ["current" => "inscritos"]))

@section('conteudo')



<div class="content content-fixed bd-b">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="/admin">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="/admin/cursos">Inscrições</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dados do Candidato: <strong>{{$inscrito->firstName}} {{$inscrito->lastName}}</strong></li>
                    </ol>
                </nav>
                <h4 class="mg-b-0">Dados do Candidato</h4>
            </div>
        </div><!-- container -->
    </div><!-- content -->
</div>

<div class="content">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">

        <div data-label="Example" class="df-example">
            <div id="accordion" class="accordion">
                <h6 class="accordion-title">Dados Pessoais</h6>
                <div class="accordion-body">

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label for="firstName">Primeiro Nome</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" value="{{$inscrito->firstName}}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="lastName">Sobrenome</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" value="{{$inscrito->lastName}}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="documento">CPF</label>
                            <input type="text" class="form-control" id="nDocumento" name="nDocumento" value="{{$inscrito->nDocumento}}">
                        </div>

                    </div>

                    <hr class="mb-4">

                    <div class="row">

                        <div class="col-md-6 mb-6">
                            <label for="telefone">Telefone para contato</label>
                            <input type="text" class="form-control phone" id="phone" name="phone" value="{{$inscrito->phone}}">
                        </div>

                        <div class="col-md-6 mb-6">
                            <label for="email">Email</label>
                            <input type="email" value="{{$inscrito->email}}" class="form-control" id="email" name="email">
                        </div>

                    </div>

                    <hr class="mb-4">

                    <div class="row">

                        <div class="col-md-3 mb-3">
                            <label for="zip">CEP</label>
                            <input type="text" class="form-control cep" id="cep" name="cep" value="{{$inscrito->cep}}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="bairro">Bairro</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" value="{{$inscrito->bairro}}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="cidade">Cidade</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" value="{{$inscrito->cidade}}">
                        </div>

                        <div class="col-md-2 mb-2">
                            <label for="uf">UF</label>
                            <input type="text" class="form-control" id="uf" name="uf" value="{{$inscrito->uf}}">
                        </div>

                    </div>

                    <hr class="mb-4">

                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="endereco">Endereço</label>
                            <input type="text" class="form-control" id="endereco" name="endereco" value="{{$inscrito->endereco}}">

                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="numero">Número</label>
                            <input type="text" class="form-control" id="numero" name="numero" value="{{$inscrito->numero}}">

                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="complemento">Complemento</label>
                            <input type="text" class="form-control" id="complemento" name="complemento" value="{{$inscrito->complemento}}">
                        </div>

                    </div>
                </div>
                <h6 class="accordion-title">Histórico de Transações</h6>
                <div class="accordion-body">
                    
                        <table class="table table-striped ">
                            <thead class="thead-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Cod. PagSeguro</th>
                                    <th>Tipo</th>
                                    <th>Transação</th>
                                    <th>Data Transação</th>
                                    <th>Última Atualização</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                <tr>
                                    <th>{{$payment->id}}</th>
                                    <td>{{$payment->codigo}}</td>
                                    <td>{!! Helper::retornaTipoTransacao($payment->tipo_transacao) !!}</td>
                                    <td>{!! Helper::retornaStatusTransacao($payment->status_transacao) !!}</td>
                                    <td>{!! Helper::formatDate($payment->created_at) !!}</td>
                                    <td>{!! Helper::formatDate($payment->updated_at) !!}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    
                </div>

            </div><!-- az-accordion -->
        </div><!-- df-example -->

    </div>
</div>
</div>

@endsection

@section('scripts')
<script>
    $(function() {
        'use strict'
        $('#accordion').accordion({
            heightStyle: 'content',
            collapsible: true
        });
    });
</script>
@endsection