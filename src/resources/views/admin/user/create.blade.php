@extends('admin/layout/admin', ["current" => "cursos"]))

@section('conteudo')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Criar Usuários</h1>
</div>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/usuarios">Usuários</a></li>
        <li class="breadcrumb-item active" aria-current="page">Novo Usuário</li>
    </ol>
</nav>

<form method="post">
    @csrf

    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="curso">Nome</label>
            <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name" name="name" value="">
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group col-md-4">
            <label for="curso">Email</label>
            <input type="text" class="form-control  @error('email') is-invalid @enderror" id="email" name="email" value="">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    
        <div class="form-group col-md-4">
            <label for="imgCurso">Senha de Acesso</label>
            <input type="password" class="form-control  @error('password') is-invalid @enderror" id="password" name="password" value="">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

    </div>

    <button type="submit" class="btn btn-primary mt-2">Salvar</button>
</form>
<br />

@endsection
