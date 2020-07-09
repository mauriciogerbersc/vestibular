@extends('admin/layout/admin', ["current" => "users"]))



@section('conteudo')


<div class="content content-fixed bd-b">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="/admin">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="/admin/usuarios">Usuários do Sistema</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cadastro de Usuário</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0">Cadastro de Usuário</h4>
            </div>
        </div><!-- container -->
    </div><!-- content -->
</div>



<div class="content">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <form method="post" enctype="multipart/form-data">
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
    </div>
</div>
@endsection
