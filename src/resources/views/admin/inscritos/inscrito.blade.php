@extends('admin/layout/admin', ["current" => "inscritos"]))

@section('conteudo')



<div class="content content-fixed bd-b">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="/admin">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="/admin/inscritos">Inscrições</a></li>
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


        <div class="text-center" id="loader">
            <div class="spinner-border">...</div>
        </div>

        <div id="notLoader">
        <h6 class="accordion-title">Dados Pessoais</h6>


        <div class="row">
            <input type="hidden" id="inscrito_id" value="{{$inscrito->id}}" />
            <div class="col-md-3 mb-3">
                <label for="firstName">Primeiro Nome</label>
                <input type="text" class="form-control" id="firstName" name="firstName" value="{{$inscrito->firstName}}">
            </div>

            <div class="col-md-3 mb-3">
                <label for="lastName">Sobrenome</label>
                <input type="text" class="form-control" id="lastName" name="lastName" value="{{$inscrito->lastName}}">
            </div>

            <div class="col-md-3 mb-3">
                <label for="documento">CPF</label>
                <input type="text" class="form-control" id="nDocumento" name="nDocumento" value="{{$inscrito->nDocumento}}">
            </div>

            <div class="col-md-3 mb-3">
                <label for="status_candidato">Situação do Candidato</label>
                <br>
                <div class="candidato_status">
                    <span class="badge {!! Helper::retornaBadgeStatusInscrito($inscrito->status,$inscrito->id) !!} corrigido_{{$inscrito->id}}">
                        {!! Helper::retornaStatusInscrito($inscrito->status,$inscrito->id) !!}</span>
                    <a href="#" id="alterar_status">Alterar</a>
                </div>
                <select class="custom-select statusCandidato" name="statusCandidato">
                    <option value="--">Selecione uma opção</option>
                    @foreach($status_candidato as $status)
                    <option value="{{$status->status_int}}" {{ $status->status_int == $inscrito->status ? "selected" : ""}}>{{$status->status}}</option>
                    @endforeach
                </select>
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

        <HR>


        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="transacoes-tab" data-toggle="tab" href="#transacoes" role="tab" aria-controls="transacoes" aria-selected="true">Histórico de Transações</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="escolar-tab" data-toggle="tab" href="#escolar" role="tab" aria-controls="escolar" aria-selected="false">Histórico Escolar</a>
            </li>

        </ul>

        <div class="tab-content bd bd-gray-300 bd-t-0 pd-20" id="myTabContent">
            <div class="tab-pane fade show active" id="transacoes" role="tabpanel" aria-labelledby="transacoes-tab">
                <h6>Histórico de Pagamento</h6>
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
                        @forelse($payments as $payment)
                        <tr>
                            <th>{{$payment->id}}</th>
                            <td>{{$payment->codigo}}</td>
                            <td>{!! Helper::retornaTipoTransacao($payment->tipo_transacao) !!}</td>
                            <td>{!! Helper::retornaStatusTransacao($payment->status_transacao) !!}</td>
                            <td>{!! Helper::formatDate($payment->created_at) !!}</td>
                            <td>{!! Helper::formatDate($payment->updated_at) !!}</td>
                        </tr>
                        @empty
                        <tr>
                            <td>Nenhum registro encontrado</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="escolar" role="tabpanel" aria-labelledby="escolar-tab">
                <h6>Histórico Escolar</h6>
                <p>
                    @if($inscrito->historico!='')
                    <a href="/baixar-arquivo/{{$inscrito->historico}}" target="_blank" class="btn btn-secondary mb-1">
                        Baixar Histórico
                    </a>
                    @else
                    <span class="btn btn-danger btn-sm mb-1 not-active" alt="Não foi enviado histórico escolar" title="Não foi enviado histórico escolar">Histórico não enviado</span>
                    @endif
                </p>
            </div>

        </div>
</div>
    </div>
</div>


@endsection

@section('scripts')
<script>
    $(function() {
        'use strict'
        $("#loader").hide();
        $('.statusCandidato').hide();
        $('#alterar_status').click(function() {
            $(".statusCandidato").show();
            $('.candidato_status').hide();
        });

        $('.statusCandidato').change(function() {
     
            if($(this).val() == '--'){
                return false;
            }else{
                confirmarCorrecao($(this).val());
            }
         
        });


        function confirmarCorrecao(status_id) {
            var status_id = status_id;
            var candidato_id = $("#inscrito_id").val();
            var r = confirm("ATENÇÃO: Você confirma a alteração do status do candidato?");
            var txt = "";
            if (r == true) {
                txt = "Confirmada alteração de status.";
            } else {
                txt = "Ok. Ação cancelada.";
                alert(txt);
                return;
            }

            var url_alteracao = '/admin/redacoes/' + status_id + '/' + candidato_id + '/statusCandidato';
            $.ajax({
                url: url_alteracao,
                type: "GET",
                dataType: 'json',
                beforeSend: function() {
                    $("#notLoader").hide();
                    $("#loader").show();
                },
                success: function(response) {
                    console.log(response);
                    if (response) {
                        alert("O status do candidato foi alterado.");
                        location.reload();
                    } else {
                        alert("O status do candidato não foi alterado.");
                        location.reload();
                    }
                },
                error: function() {
                    alert("O status do candidato não foi alterado.");
                    location.reload();
                }
            });
          
        }
        $('#accordion').accordion({
            heightStyle: 'content',
            collapsible: true
        });
    });
</script>
@endsection