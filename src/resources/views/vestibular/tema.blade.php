@extends('layout/app')

@section('conteudo')

<section class="service-wrap-layout1 bg-accent bg-common bg-image-cursos">
    @if(!empty($redacaoAnterior))
        <div class="container">
            <h2 style="color:orange; text-align:center">Olá, <strong style="color:white">{{$inscrito_nome}}</strong></h2>
            <h3 style="color:orange; text-align:center">Sua redação já se encontra em nossa base dados,  aguarde correção que entraremos em contato com você.</h2>
        </div>
    @else
    <div class="container">
        <div class="heading-layout1 heading-light">
            <div class="item-subtitle">Temas para Redação</div>
            <h2>Selecione o tema desejado</h2>
        </div>
        <div class="row">
           
                @foreach($temas as $tema)
                    <div class="col-lg-4 col-md-6">
                        <div class="tema-redacao mb-10">
                            <div class="tema-readacao-head">

                                <div class="tema-redacao-thumb">
                                    <img src="/files/{{$tema->tema_imagem}}" alt="{{$tema->titulo_redacao}}">
                                </div>

                                <div class="uc-game-head-title">
                                    <h4><a href="/vestibular/redacao/prova/{{$tema->id}}">{{$tema->titulo_redacao}}</a></h4>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            
        </div>
    </div>
    @endif
</section>
@endsection


