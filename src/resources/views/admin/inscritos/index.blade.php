@extends('admin/layout/admin', ["current" => "inscritos"]))

@section('conteudo')

<div class="content content-fixed bd-b">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="/admin">Painel de Controle</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Inscrições para o Vestibular</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Inscrições para o Vestibular</h4>
            </div>
        </div>
    </div>
</div>


@include('admin.mensagem', ['mensagem' => $mensagem ?? '', 'alert_tipo' => $alert_tipo ?? ''])
<div class="content">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">

        <div data-label="Example" class="df-example demo-table">
            <table id="example1" class="table">
                <thead>
                    <tr>
                        <th>Situação</th>
                        <th>Pagamento</th>
                        <th>Inscrito</th>
                        <th>Curso</th>
                        <th>Documento</th>
                        <th>Contato</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inscritos as $inscrito)
                    <tr>
                        <!-- -->
                        <td>
                            <span class="badge {!! Helper::retornaBadgeStatusInscrito($inscrito->status,$inscrito->id) !!} corrigido_{{$inscrito->id}}">
                                {!! Helper::retornaStatusInscrito($inscrito->status,$inscrito->id) !!}</span>
                        </td>
                        <td>
                            @php
                            $transacao = Helper::tentouPagar($inscrito->id);
                            @endphp

                            @if(empty($transacao))
                            <span class="badge badge-pill badge-dark">Não realizou pagamento.</span>
                            @else
                            @if($transacao == 3)
                            <span class="badge badge-pill badge-success">Pagamento Efetuado</span>
                            @else
                            <span class="badge badge-pill badge-primary">Aguardando Baixa</span>
                            @endif

                            @endif
                        </td>
                        <td>{{$inscrito->firstName}} {{$inscrito->lastName}}</td>
                        <td><a href="cursos/{{$inscrito->curso->id}}/editar">{{$inscrito->curso->curso}}</a></td>

                        <td>{{$inscrito->nDocumento}}</td>
                        <td>{{$inscrito->email}}
                            <br>{{$inscrito->phone}}</td>
                        <td class="d-flex">

                            <div class="btn-group-vertical">
                                <a href="/admin/inscrito/{{$inscrito->id}}" class="btn btn-primary btn-sm mb-1">Visualizar</a>
                                @if($inscrito->historico!='')
                                <a href="/baixar-arquivo/{{$inscrito->historico}}" target="_blank" class="btn btn-secondary mb-1">
                                    Histórico
                                </a>
                                @else
                                <span class="btn btn-danger btn-sm mb-1 not-active" alt="Não foi enviado histórico escolar" title="Não foi enviado histórico escolar">Histórico</span>
                                @endif

                                @if($inscrito->status == 2)
                                @if($inscrito->corrigido)
                                <span class="btn btn-success btn-sm correcao not-active">Corrigido!</span>
                                @else
                                <button type="button" class="btn btn-dark btn-sm correcao corrigido_{{$inscrito->id}}" onclick="confirmarCorrecao({{$inscrito->id}});">Corrigido?</button>
                                @endif
                                @else
                                <span class="btn btn-dark btn-sm mb-1 not-active" alt="Redação ainda não corrigida" title="Redação ainda não corrigida">Corrigido?</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script src="{{asset('assets/lib/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/lib/datatables.net-dt/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{asset('assets/lib/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js')}}"></script>


<script>
    function confirmarCorrecao(inscrito_id) {
        var id = inscrito_id;
        var r = confirm("Confirma correção da prova?");
        if (r == true) {
            txt = "Confirmada correção da redação.";
        } else {
            txt = "Ok. Ação cancelada.";
        }

        var url_correcao = '/admin/redacoes/' + inscrito_id + '/corrigida';
        $.ajax({
            url: url_correcao,
            type: "GET",
            dataType: 'json',
            beforeSend: function() {
                $("#loader").show();
            },
            success: function(response) {
                console.log(response);
                if (response) {
                    $(".corrigido_" + inscrito_id).text("Corrigido!").removeClass('btn-dark').addClass('not-active').addClass('btn-success');
                } else {
                    alert("O aluno ainda não realizou a redação.");
                }
            },
            error: function() {
                alert("O aluno ainda não realizou a redação.");
            }
        });

        console.log(txt + " inscrito_id " + id);
    }

    $(document).ready(function() {
        $('.table').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });
    });
</script>
@endsection