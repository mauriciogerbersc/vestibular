@extends('admin/layout/admin')

@section('conteudo')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edição de Tema</h1>
</div>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/redacao-temas">Temas</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$redacao->titulo_redacao}}</li>
    </ol>
</nav>

<form method="post" enctype="multipart/form-data">
    @csrf

    <div class="form-row">
        
        <div class="form-group col-md-12">
            <label for="titulo">Título</label>
            <input type="text" class="form-control" id="titulo" value="{{$redacao->titulo_redacao}}" name="titulo">
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="descricaoDoTema">Descrição do Tema</label>
            <textarea class="form-control" name="descricao">{{$redacao->descricao_redacao}}</textarea>
        </div>

    </div>

    <button type="submit" class="btn btn-primary mt-2">Salvar</button>
</form>
<br />

@endsection