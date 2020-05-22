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
                <th>Inscrito</th>
                <th>Curso</th>
               
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
                
                <td>{{$inscrito->firstName}} {{$inscrito->lastName}}</td>
                <td><a href="cursos/{{$inscrito->curso->id}}/editar">{{$inscrito->curso->curso}}</a></td>
               
                <td>{{$inscrito->nDocumento}}</td>
                <td>{{$inscrito->email}}</td>
                <td>{{$inscrito->phone}}</td>
                <td class="d-flex">

                    <a href="/admin/inscrito/{{$inscrito->id}}" class="btn btn-info btn-sm mr-1">
                        Visualizar
                    </a>
                    
                    @if($inscrito->historico!='')
                    <a href="/files/historicos/{{$inscrito->historico}}" target="_blank" class="btn btn-success btn-sm mr-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down-circle"><circle cx="12" cy="12" r="10"/><polyline points="8 12 12 16 16 12"/><line x1="12" y1="8" x2="12" y2="16"/></svg>
                        Histórico 
                    </a>
                    @else 
                        <span class="btn btn-danger btn-sm mr-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            Histórico</span>
                    @endif

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@endsection