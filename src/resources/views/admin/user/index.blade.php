@extends('admin/layout/admin', ["current" => "users"]))

@section('conteudo')


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Inscrições para o Vestibular</h1>
</div>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Usuários do Sistema</li>
    </ol>
</nav>

<a href="{{ route('novo_usuario') }}" class="btn btn-dark mb-2">Novo Usuário</a> <br />


@include('admin.mensagem', ['mensagem' => $mensagem ?? '', 'alert_tipo' => $alert_tipo ?? ''])

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Usuário de Acesso</th>
                <th>Nível de Acesso</th>
                <th>Ações</th>
            </th>
        </thead>
        <tbody>
        @foreach($admins as $admin)
            <tr>
                <td>{{$admin->email}}</td>
                <td>{{$admin->grupo_usuario}}</td>
                <td class="d-flex">

                    <a href="/admin/usuarios/{{$admin->id}}/edit" class="btn btn-info btn-sm mr-1">
                        Visualizar
                    </a>
                  

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@endsection