@extends('admin/layout/admin', ["current" => "inscritos"]))

@section('conteudo')


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Inscrições para o Vestibular</h1>
</div>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Alunos Inscritos</li>
    </ol>
</nav>

@include('admin.mensagem', ['mensagem' => $mensagem ?? '', 'alert_tipo' => $alert_tipo ?? ''])

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Situação</th>
                <th>Curso</th>
                <th>Inscrito</th>
                <th>Documento</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ações</th>
            </th>
        </thead>
        <tbody>
        @foreach($inscritos as $inscrito)
            <tr>
                <td><span class="badge {!! Helper::retornaBadgeStatusInscrito($inscrito->status) !!}">{!! Helper::retornaStatusInscrito($inscrito->status) !!}</span></td>
                <td><a href="admin/curso/{{$inscrito->curso->id}}/inscritos">{{$inscrito->curso->curso}}</a></td>
                <td>{{$inscrito->firstName}} {{$inscrito->lastName}}</td>
                <td>{{$inscrito->nDocumento}}</td>
                <td>{{$inscrito->email}}</td>
                <td>{{$inscrito->phone}}</td>
                <td class="d-flex">

                    <a href="/admin/inscrito/{{$inscrito->id}}" class="btn btn-info btn-sm mr-1">
                        Visualizar
                    </a>
        
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@endsection