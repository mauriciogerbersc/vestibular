@extends('layout/app')

@section('conteudo')

<section class="service-wrap-layout1 bg-accent bg-common bg-image-cursos">
    <div class="container">
        <div class="heading-layout1 heading-light">
            <div class="item-subtitle">Temas para Redação</div>
            <h2>Selecione o tema desejado</h2>
        </div>
        <div class="row">
            @foreach($temas as $tema)
            <div class="col-lg-4 col-md-6">
                <div class="tema-redacao mb-40">
                    <div class="tema-readacao-head">
                        <div class="uc-game-head-title">
                            <h4><a href="/vestibular/redacao/prova/{{$tema->id}}">{{$tema->titulo_redacao}}</a></h4>
                        </div>
                     
                    </div>
                    <p>{{$tema->descricao_redacao}}</p>
                    <div class="tema-redacao-thumb">
                        <img src="/files/{{$tema->tema_imagem}}" alt="{{$tema->titulo_redacao}}">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection


