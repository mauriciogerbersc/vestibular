@extends('admin/layout/admin', ["current" => "processoSeletivo"]))

@section('css')
<link href="{{asset('assets/lib/datatables.net-dt/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css')}}" rel="stylesheet">
@endsection

@section('conteudo')

<div class="content content-fixed bd-b">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="/admin">Painel de Controle</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Processo Seletivo</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Processos Criados</h4>
            </div>
        </div>
    </div>
</div>


<div class="content">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        @include('admin.mensagem', ['mensagem' => $mensagem ?? '', 'alert_tipo' => $alert_tipo ?? ''])


        <table id="example1" class="table">
            <thead>
                <tr>
                    <th class="wd-10p">#</th>
                    <th class="wd-40p">Processo</th>
                    <th class="wd-20p">Período</th>
                    <th class="wd-20p">Status atual</th>
                    <th class="wd-10p">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($processos as $processo)
                <tr>
                    <td>{{$processo->id}}</td>
                    <td>{{$processo->nomeProcesso}}</td>
                    <td>{{$processo->dataInicio}} - {{$processo->dataFim}} </td>
                    <td>{{$processo->status}} </td>
                    <td class="d-flex">
                        <a href="/admin/processoSeletivo/{{$processo->id}}/edit" class="btn btn-info btn-sm mr-1">
                            Visualizar
                        </a>
                    </td>
                </tr>
                @endforeach
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