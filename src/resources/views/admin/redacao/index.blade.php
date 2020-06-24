@extends('admin/layout/admin', ["current" => "temas"]))

@section('conteudo')

<div class="content content-fixed bd-b">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="/admin">Painel de Controle</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Temas</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Temas</h4>
            </div>
        </div>
    </div>
</div>



<div class="content">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        @include('admin.mensagem', ['mensagem' => $mensagem ?? '', 'alert_tipo' => $alert_tipo ?? ''])
        <div data-label="Example" class="df-example demo-table">
            <table id="example1" class="table">
                <thead>
                    <tr>
                        <th class="wd-60p">Título da Redação</th>
                        <th class="wd-15p">Imagem</th>
                        <th class="wd-15p">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($redacoes as $redacao)
                    <tr>
                        <td><a href="/admin/redacao-temas/{{$redacao->id}}/editar">{{$redacao->titulo_redacao}}</a></td>
                        <td><img src="/files/{{$redacao->tema_imagem}}" style="height:  60px !important;"></td>
                        <td class="d-flex">

                            <form method="post" action="/admin/redacao-temas/{{$redacao->id}}/desativar" onsubmit="return confirm('Tem certeza que deseja remover ?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Desativar</button>
                            </form>
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
    $(function() {
        'use strict'
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