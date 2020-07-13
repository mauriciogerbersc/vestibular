@extends('admin/layout/admin', ["current" => "cursos"]))

@section('conteudo')


<div class="content content-fixed bd-b">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="/admin">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="/admin/usuarios">Usuários do Sistema</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Editando usuário: <strong>{{$user->name}}</strong></li>
                    </ol>
                </nav>
                <h4 class="mg-b-0">Editando usuário: <strong>{{$user->name}}</strong></h4>
            </div>
        </div><!-- container -->
    </div><!-- content -->
</div>

<div class="content">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <form method="post" enctype="multipart/form-data">
            @csrf

            @foreach($roles as $role)
            <div class="form-check-inline">
                <input type="checkbox" name="roles[]"  @if($user->roles->contains($role->id)) checked=checked @endif  value="{{$role->id}}">
                <label>{{$role->name}}</label>
            </div>
            @endforeach 

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="curso">Nome</label>
                    <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name" name="name" value="{{$user->name}}">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="curso">Email</label>
                    <input type="text" class="form-control  @error('email') is-invalid @enderror" id="email" name="email" value="{{$user->email}}">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="imgCurso">Senha de Acesso</label>
                    <input type="password" class="form-control  @error('password') is-invalid @enderror" id="password" name="password" value="">
                    <input type="hidden" value="{{$user->password}}" name="old_password" />
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