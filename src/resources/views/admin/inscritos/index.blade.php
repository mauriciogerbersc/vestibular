@extends('admin/layout/admin', ["current" => "inscritos"])

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

        <form method="post" action="/admin/inscritos">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputForNome">Nome</label>
                    <input type="text" class="form-control" id="nome" placeholder="Nome Candidato">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputForEmail">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Email">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputForCpf">CPF</label>
                    <input type="text" class="form-control" id="cpf" placeholder="CPF">
                </div>

            </div>

            <div class="form-row">

                <div class="form-group col-md-4">
                    <label for="selectCurso">Curso Escolhido</label>
                    <select class="custom-select" name="cursoEscolhido" id="cursoEscolhido">
                        <option value="*">Todos</option>
                        @foreach($cursos as $curso)
                        <option value="{{$curso->id}}">{{$curso->abreviacao}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label>Status Candidato</label>
                    <select class="custom-select" name="statusCandidato" id="statusCandidato">
                        <option value="*">Todos</option>
                        @foreach($status_candidatos as $status)
                            <option value="{{$status->status_int}}">{{$status->status}}</option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group col-md-4">
                    <label>Filtrar Processo</label>
                    <select class="custom-select" name="processoSeletivo" id="processoSeletivo">
                        <option value="*">Todos</option>
                        @foreach($processos_seletivos as $processo)
                            <option value="{{$processo->id}}">{{$processo->nomeProcesso}}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <button type="submit" class="btn btn-primary" id="buscar">Buscar</button>
        </form>


        <hr>
        <div class="text-center" id="loader">
            <div class="spinner-border">...</div>
        </div>

        <div class="row">
            <table id="example1" class="table">
                <thead>
                    <tr>
                        <th>COD</th>
                        <th>Situação</th>
                        <th>Inscrito</th>
                        <th>Curso</th>
                        <th>Documento</th>
                        <th>Contato</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="lista-inscricoes" name="lista-inscricoes">

                </tbody>
            </table>

        </div>
    </div>

    @endsection


    @section('scripts')
    <script src="{{asset('assets/lib/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/lib/datatables.net-dt/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/lib/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js')}}"></script>


    <script>
        $("#loader").hide();

        var url = "/admin/inscritos/lista";

        $(document).ready(function() {
            $("#buscar").click(function(e) {
                e.preventDefault();
                var formData = {
                    nome: $('#nome').val(),
                    cpf: $("#cpf").val(),
                    email: $("#email").val(),
                    statusFinanceiro: $("#statusFinanceiro option:selected").val(),
                    statusCandidato: $("#statusCandidato option:selected").val(),
                    cursoEscolhido: $("#cursoEscolhido option:selected").val(),
                    processoSeletivo: $("#processoSeletivo option:selected").val()
                }

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function() {
                        $("#loader").show();
                        $("#example1").hide();
                    },
                    success: function(data) {
                        var response = data;
                        OnSuccess_(response);
                    },
                    complete: function(data) {
                        $("#loader").hide();
                        $("#example1").show();
                    }
                });
            });

         
        })

        $("#loader").show();
        $("#example1").hide();

        $.get(url, function(data) {
            console.log('carregando');
        }).done(function(data) {
            if (data) {
                var response = data;
                OnSuccess_(response);
                $("#loader").hide();
                $("#example1").show();
            }
        });

        function OnSuccess_(response) {
            $(document).ready(function() {
                $('.table').DataTable({
                    data: response,
                    columnDefs: [
                        { "width": "10%"},
                        { "width": "20%"},
                        { "width": "10%"},
                        { "width": "10%"},
                        { "width": "10%"},
                        { "width": "10%"},
                        { "width": "20%"}
                    ],
                    columns: [{
                            "data": "id"
                        },
                        {
                            "data": "status"
                        },
                        {
                            "data": "nomeCompleto"
                        },
                        {
                            "data": "curso"
                        },
                        {
                            "data": "nDocumento"
                        },
                        {
                            "data": "contato"
                        },
                        {
                            "data": "viewContato"
                        }
                    ],
                    language: {
                        searchPlaceholder: 'Buscar...',
                        sSearch: '',
                        lengthMenu: '_MENU_ items/página',
                    },
                    destroy: true
                });
            });
        }

        function enviarEmailUsuarioSenha(inscrito_id){
            var id = inscrito_id;
            var r = confirm("Confirma envio de usuário e senha para o aluno?");
            if (r == true) {
                txt = "Email enviado.";
            } else {
                txt = "Ok. Ação cancelada.";
            }

            var url_email = '/admin/enviarEmail/' + id;
            $.ajax({
                url: url_email,
                type: "GET",
                dataType: 'json',
                beforeSend: function() {
                    $("#loader").show();
                },
                success: function(response) {
                    console.log(response);
                    if (response) {
                        $(".email_" + id).text("Enviado!").removeClass('btn-warning').addClass('not-active').addClass('btn-success');
                        alert(txt);
                    } else {
                        alert(txt);
                    }

                    $("#loader").hide();
                },
                error: function() {
                    alert(txt);
                }
            });

            console.log(txt + " inscrito_id " + id);
            $("#loader").hide();
            return false;
        }

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
    </script>
    @endsection