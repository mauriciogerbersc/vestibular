@extends('admin/layout/admin')

@section('conteudo')


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Temas</h1>
</div>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Redações de Alunos</li>
    </ol>
</nav>

@include('admin.mensagem', ['mensagem' => $mensagem ?? '', 'alert_tipo' => $alert_tipo ?? ''])


<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Inscrito</th>
                <th>Tema Escolhido</th>
                <th>Ações</th>
            </th>
        </thead>
        <tbody>
            @foreach($redacoesAlunos as $redacaoAluno)
            
            <tr>
                <td><a href="{{ route('visualizar_inscrito', $redacaoAluno->inscrito_id) }}">{{$redacaoAluno->inscrito->firstName}} {{$redacaoAluno->inscrito->lastName}}</a></td>
                <td><a href="{{ route('visualizar_redacao', $redacaoAluno->redacao_id) }}">{{$redacaoAluno->redacao->titulo_redacao}}</a></td>
                <td class="d-flex">
                    <a href="{{ route('force_download', $redacaoAluno->id) }}" class="btn btn-info btn-sm mr-1">
                        Baixar TXT
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@endsection