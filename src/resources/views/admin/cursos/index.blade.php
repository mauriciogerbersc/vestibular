@extends('admin/layout/admin', ["current" => "cursos"]))

@section('conteudo')


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Cursos</h1>
</div>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Cursos</li>
    </ol>
</nav>

<a href="{{ route('criar_curso') }}" class="btn btn-dark mb-2">Criar Curso</a> <br />


@include('admin.mensagem', ['mensagem' => $mensagem ?? '', 'alert_tipo' => $alert_tipo ?? ''])



<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Modalidade</th>
                <th>Curso</th>
                <th>Ações</th>
                </th>
        </thead>
        <tbody>
            @foreach($cursos as $curso)
            <tr>
                <td>{{$curso->tipo_curso}}</td>
                <td>{{$curso->curso}}</td>
                <td class="d-flex">
                    <a href="/admin/cursos/{{$curso->id}}/editar" class="btn btn-info btn-sm mr-1">
                        Editar
                    </a>

                    <form method="post" action="/admin/cursos/{{$curso->id}}/desativar"
                        onsubmit="return confirm('Tem certeza que deseja remover ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">
                            Desativar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>

@endsection