@extends('admin/layout/admin', ["current" => "cursos"])

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
                        <li class="breadcrumb-item active" aria-current="page">Cursos Criados</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Cursos Criados</h4>
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
                        <th>#</th>
                        <th class="wd-15p">Modalidade</th>
                        <th class="wd-65p">Curso</th>
                        <th class="wd-10p">Imagem</th>
                        <th class="wd-10p">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cursos as $key=>$curso)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$curso->tipo_curso}}</td>
                        <td><a href="/admin/cursos/{{$curso->id}}/editar">{{$curso->curso}}</a></td>
                        <td><img src="/files/{{$curso->imagem_curso}}" style="height:  60px !important;"></td>
                        <td class="d-flex">
                            <form method="post" action="/admin/cursos/{{$curso->id}}/desativar" onsubmit="return confirm('Tem certeza que deseja remover ?')">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm">
                                    Desativar
                                </button>
                            </form>
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