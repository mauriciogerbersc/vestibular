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
            <h3 class="display-4">Inscrições</h3>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
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
                        <td><span class="badge {!! Helper::retornaBadgeStatusInscrito($inscrito->status) !!}">{!! Helper::retornaStatusInscrito($inscrito->status) !!}</span></td>
                        <td>{{$inscrito->firstName}} {{$inscrito->lastName}}</td>
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
        </div>

        <div class="col-md-6 order-md-6 mb-6">
            <h3 class="display-4">Redações realizadas</h3>
            <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
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
                                    Baixar TXT
                                </a>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>

@endsection