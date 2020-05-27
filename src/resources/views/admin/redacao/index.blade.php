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



<div class="table-responsive">
    <table class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Título da Redação</th>
                <th>Imagem</th>
                <th>Ações</th>
            </th>
        </thead>
        <tbody>
            @foreach($redacoes as $redacao)
            <tr>
                <td><a href="/admin/redacao-temas/{{$redacao->id}}/editar">{{$redacao->titulo_redacao}}</a></td>
                <td><img src="/files/{{$redacao->tema_imagem}}" style="height:  60px !important;"></td>
                <td class="d-flex">
               
                    <form method="post" action="/admin/redacao-temas/{{$redacao->id}}/desativar" onsubmit="return confirm('Tem certeza que deseja remover ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Desativar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>

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