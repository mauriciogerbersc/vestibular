@extends('admin/layout/admin', ["current" => "dashboard"])

@section('conteudo')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Dashboard</li>
    </ol>
</nav>

    <div class="row">
      
        <div class="col-md-6 order-md-6 mb-6">
            <h4 class="display-5">Inscritos que não realizaram redação</h3>
           
              <table class="table table-striped table-bordered" style="width:100%">
                <thead>
             
                    <tr>
                      <th>#</th>
                      <th>Status</th>
                      <th>Nome</th>
                      <th>Curso Escolhido</th>
                      <th>Visualizar</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($inscritos as $key=>$inscrito)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td><span class="badge {!! Helper::retornaBadgeStatusInscrito($inscrito->status, $inscrito->id) !!}">{!! Helper::retornaStatusInscrito($inscrito->status,$inscrito->id) !!}</span></td>
                        <td><a href="{{ route('visualizar_inscrito', $inscrito->id) }}">{{$inscrito->firstName}} {{$inscrito->lastName}}</a></td>
                         
                        <td><a href="admin/curso/{{$inscrito->curso->id}}/inscritos">{{$inscrito->curso->curso}}</a></td>
                        <td class="d-flex">
                            <a href="/admin/inscrito/{{$inscrito->id}}" class="btn btn-info btn-sm mr-1">
                                Visualizar
                            </a>

                        </td>
                    </tr>
                @endforeach
                  </tbody>
                </table>
            
        </div>

        <div class="col-md-6 order-md-6 mb-6">
          <h4 class="display-5">Redações realizadas</h3>
            
              <table class="table table-striped table-bordered" style="width:100%">
                <thead>
             
                    <tr>
                          <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Tema Escolhido</th>
                            <th>Visualizar</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($redacoesAlunos as $key=> $redacaoAluno)
                          <tr>
                            <td>{{ ++$key }}</td>
                            <td><a href="{{ route('visualizar_inscrito', $redacaoAluno->inscrito_id) }}">{{$redacaoAluno->inscrito->firstName}} {{$redacaoAluno->inscrito->lastName}}</a></td>
                            <td><a href="{{ route('visualizar_redacao', $redacaoAluno->redacao_id) }}">{{$redacaoAluno->redacao->titulo_redacao}}</a></td>
                            <td class="d-flex">
                                <a href="{{ route('force_download', $redacaoAluno->id) }}" class="btn btn-info btn-sm mr-1">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down-circle"><circle cx="12" cy="12" r="10"/><polyline points="8 12 12 16 16 12"/><line x1="12" y1="8" x2="12" y2="16"/></svg>
                                  TXT
                                </a>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                    </table>
           
        </div>
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