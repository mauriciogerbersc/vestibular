@extends('layout/app')

@section('conteudo')

<section class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content text-center">
                    <h2>{{$curso->curso}}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Página Inicial</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$curso->curso}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="single-wrap-layout">


    <div class="container">
        <div class="row row-inside">
            <div class="col-lg-8 col-12">
                <div class="item-content">
                    <div class="item-subtitle">
                        {{$curso->curso}}
                    </div>
                    {!!$curso->descricao!!}
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="widget widget-curso">
                    <div class="heading-layout3 mg-b-0">
                        <h3 class="mg-b-8">Informações Adicionais</h3>
                    </div>

                    <ul class="item-list">
                        <li>
                            <a href="https://{{$curso->link_curso}}" target="_blank" style="background-color:red;">
                            <i class="fa fa-info" aria-hidden="true"></i>Mais Informações
                            </a>
                        </li>
                    </ul>

                    <ul class="item-list">
                        <li><a href=""><i class="fa fa-graduation-cap" aria-hidden="true"></i><strong>{{$curso->tipo_curso}}</strong></a></li>
                    </ul>
                    
                    <ul class="item-list">
                        <li><a href="#"> <i class="fa fa-file" aria-hidden="true"></i>Edital .pdf</a> </li>
                    </ul>
                   
                </div>
            </div>
        </div>

    </div>
    <div class="container">
        <a href="/inscricao/formulario/{{$curso->slug}}" class="btn btn-success btn-lg btn-block mt-5">Inscrever-se</a>
    </div>
</section>
@endsection