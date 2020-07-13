@extends('admin/layout/admin', ["current" => "dashboard"])

@section('conteudo')

<div class="content content-fixed">
  <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="/admin">Painel de Controle</a></li>
            <li class="breadcrumb-item active" aria-current="page">Análise Geral</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Painel de Controle</h4>
      </div>

    </div>

    <div class="row row-xs">

      <!-- Gráfico de inscritos x cursos matriculados -->
      <div class="col-lg-4 col-md-6 mg-b-10">
        <div class="card">
          <div class="card-header">
            <h6 class="mg-b-0">Inscrições por Curso</h6>
          </div><!-- card-header -->
          <div class="card-body pd-lg-25">
            <div class="chart-seven"><canvas id="chartDonut"></canvas></div>
          </div><!-- card-body -->
          <div class="card-footer pd-20">
            <div class="row inscricoesCursos"></div><!-- row -->
          </div><!-- card-footer -->
        </div><!-- card -->
      </div>


      <div class="col-lg-4 col-md-6 mg-b-10">
        <div class="card">
          <div class="card-header">
            <h6 class="mg-b-0">Situação Candidatos</h6>
          </div><!-- card-header -->
          <div class="card-body pd-lg-25">
            <div class="chart-seven"><canvas id="chartPie"></canvas></div>
          </div><!-- card-body -->
          <div class="card-footer pd-20">
            <div class="row pieChart"></div><!-- row -->
          </div><!-- card-footer -->
        </div><!-- card -->
      </div>


      <div class="col-lg-4 col-md-6 mg-b-10">
        <div class="card">
          <div class="card-header">
            <h6 class="mg-b-0">Inscrições x Mês</h6>
          </div><!-- card-header -->
          <div class="card-body pd-lg-25">
            <div class="ht-250 ht-lg-300"><canvas id="chartBar2"></canvas></div>
          </div><!-- card-body -->
          <div class="card-footer pd-20">
            <div class="row barChart"></div><!-- row -->
          </div><!-- card-footer -->
        </div><!-- card -->
      </div>


      <!-- Gráfico de inscritos por estados -->
      <div class="col-lg-12 col-md-21 mg-t-10 mg-b-10">
        <div class="card">
          <div class="card-header">
            <h6 class="mg-b-0">Inscritos por Estados</h6>
          </div>
          <div class="card-body pd-lg-25">
            <div class="ht-250 ht-lg-300"><canvas id="chartArea1"></canvas></div>
          </div><!-- card-body -->
         
        </div>
      </div>








      <div class="col-lg-6 col-xl-6">
        <div class="card">
          <div class="card-header">
            <h6 class="lh-5 mg-b-0">Pagou e não realizou redação</h6>
          </div><!-- card-header -->
          <div class="card-body pd-y-15 pd-x-10">
            <div class="table-responsive">
              <table class="table table-borderless table-sm tx-13 tx-nowrap mg-b-0">
                <thead>
                  <tr class="tx-10 tx-spacing-1 tx-color-03 tx-uppercase">
                    <th class="wd-5p">#</th>
                    <th>Nome</th>
                    <th class="text-center">Curso Escolhido</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($inscritosSemRedacao as $key=>$inscrito)
                  <tr>

                    <td class="align-middle text-center">
                      <a href="{{ route('visualizar_inscrito', $inscrito->id) }}"><i data-feather="external-link" class="wd-12 ht-12 stroke-wd-3"></i></a>
                    </td>
                    <td class="align-middle tx-uppercase">
                      {{$inscrito->firstName}} {{$inscrito->lastName}}
                    </td>
                    <td class="align-middle text-center">{{$inscrito->curso->abreviacao}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>



      <div class="col-lg-6 col-xl-6">
        <div class="card">
          <div class="card-header">
            <h6 class="lh-5 mg-b-0">Aguardando Correção</h6>
          </div><!-- card-header -->
          <div class="card-body pd-y-15 pd-x-10">
            <div class="table-responsive">
              <table class="table table-borderless table-sm tx-13 tx-nowrap mg-b-0">
                <thead>
                  <tr class="tx-10 tx-spacing-1 tx-color-03 tx-uppercase">
                    <th class="wd-5p">#</th>
                    <th>Nome</th>
                    <th>Redação</th>
                  </tr>
                </thead>
                </thead>
                <tbody>
                  @foreach($aguardandoCorrecao as $key=>$inscrito)
                  <tr>

                    <td class="align-middle text-center">
                      <a href="{{ route('visualizar_inscrito', $inscrito->id) }}"><i data-feather="external-link" class="wd-12 ht-12 stroke-wd-3"></i></a>
                    </td>
                    <td class="align-middle tx-uppercase">
                      {{$inscrito->firstName}} {{$inscrito->lastName}}
                    </td>
                    <td class="align-middle">
                      <a href="{{ route('force_download', $inscrito->id) }}"><i data-feather="download" class="wd-12 ht-12 stroke-wd-3"></i></a>

                    </td>

                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>




    </div>
  </div>
</div>

@endsection

@section('scripts')
<script src="{{asset('assets/lib/chart.js/Chart.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/scripts.js')}}"></script>
<script>
  $(document).ready(function() {
    //$('.table').DataTable();
  });
</script>
@endsection