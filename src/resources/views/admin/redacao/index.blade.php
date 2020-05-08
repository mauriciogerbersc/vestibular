@extends('admin/layout/admin', ["current" => "temas"]))

@section('conteudo')


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Temas</h1>
</div>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Temas</li>
    </ol>
</nav>

<a href="{{ route('criar_tema') }}" class="btn btn-dark mb-2">Cadastrar Tema</a> <br />


@include('admin.mensagem', ['mensagem' => $mensagem ?? '', 'alert_tipo' => $alert_tipo ?? ''])

<ul class="list-group">
    @foreach($redacoes as $redacao)
    <li class="list-group-item d-flex justify-content-between align-items-center">

        <span>{{$redacao->titulo_redacao}}</span>

        <span class="d-flex">

            <a href="/admin/redacao-temas/{{$redacao->id}}/editar" class="btn btn-info btn-sm mr-1">
                Editar
            </a>

            <form method="post" action="/admin/redacao-temas/{{$redacao->id}}/desativar"
                onsubmit="return confirm('Tem certeza que deseja remover ?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">
                    Desativar
                </button>
            </form>

        </span>
    </li>
    @endforeach
</ul>
@endsection