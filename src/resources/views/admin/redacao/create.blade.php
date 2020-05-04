@extends('admin/layout/admin')

@section('conteudo')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Cadastro de Tema</h1>
</div>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/redacao-temas">Temas</a></li>
        <li class="breadcrumb-item active" aria-current="page">Novo Tema</li>
    </ol>
</nav>

<form method="post" enctype="multipart/form-data">
    @csrf

    <div class="form-row">
        
        <div class="form-group col-md-8">
            <label for="titulo">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo">
        </div>


        <div class="form-group col-md-4">
            <label for="imgCurso">Imagem do Tema</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="tema_imagem" name="tema_imagem">
                <label class="custom-file-label" for="tema_imagem">Escolha o Arquivo</label>
            </div>
        </div>
    </div>

    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="descricaoDoTema">Descrição do Tema</label>
            <textarea class="form-control" name="descricao"></textarea>
        </div>

    </div>

    <button type="submit" class="btn btn-primary mt-2">Salvar</button>
</form>
<br />

@endsection