@extends('admin/layout/admin', ["current" => "inscritos"]))

@section('conteudo')


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Inscrições para o Vestibular</h1>
</div>


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>

        <li class="breadcrumb-item"><a href="/admin/inscritos">Inscritos</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$inscrito->firstName}} {{$inscrito->lastName}}</li>
    </ol>
</nav>




<div id="accordion">
    <div class="card">
        <div class="card-header" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Dados Pessoais
                </button>
            </h5>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
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
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Histórico de Transações
                </button>
            </h5>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped ">
                            <thead>
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
                </div>
            </div>
        </div>
    </div>

</div>


@endsection