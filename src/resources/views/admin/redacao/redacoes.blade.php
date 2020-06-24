@extends('admin/layout/admin', ["current" => "redacaos"])

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
                        <li class="breadcrumb-item active" aria-current="page">Redações Alunos</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Redações Alunos</h4>
            </div>
        </div>
    </div>
</div>

@include('admin.mensagem', ['mensagem' => $mensagem ?? '', 'alert_tipo' => $alert_tipo ?? ''])
<div class="content">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">

        <table id="example1" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="wd-48p">Inscrito</th>
                    <th class="wd-45p">Tema Escolhido</th>
                    <th class="wd-7p">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($redacoesAlunos as $key=>$redacaoAluno)
                <tr>
                    <td>{{$key+1}}</td>
                    <td class="align-middle tx-uppercase"><a href="{{ route('visualizar_inscrito', $redacaoAluno->inscrito_id) }}">{{$redacaoAluno->inscrito->firstName}} {{$redacaoAluno->inscrito->lastName}}</a></td>
                    <td><a href="{{ route('visualizar_redacao', $redacaoAluno->redacao_id) }}">{{$redacaoAluno->redacao->titulo_redacao}}</a></td>
                    <td class="align-middle text-center">
                        <a href="{{ route('force_download', $redacaoAluno->id) }}"><i data-feather="download" class="wd-12 ht-12 stroke-wd-3"></i></a>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4">Nenhuma redação enviada.</td>
                </tr>
                @endforelse
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