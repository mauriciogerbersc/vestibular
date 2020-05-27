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

    <table class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Modalidade</th>
                <th>Imagem</th>
                <th>Curso</th>
                <th>Ações</th>
                
        </thead>
        <tbody>
            @foreach($cursos as $curso)
            <tr>
                <td>{{$curso->tipo_curso}}</td>
                <td><img src="/files/{{$curso->imagem_curso}}" style="height:  60px !important;"></td>
                <td><a href="/admin/cursos/{{$curso->id}}/editar">{{$curso->curso}}</a></td>
                <td class="d-flex">
                   

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


@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    $('.table').DataTable();
} );
</script>
@endsection