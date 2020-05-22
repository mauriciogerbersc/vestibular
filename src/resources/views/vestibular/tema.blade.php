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
             
                    <div class="col-lg-4 col-md-6 ">
                        <a href="/vestibular/redacao/prova/{{$tema->id}}">
                        <div class="service-box-layout1">
                            <div class="item-img">
                                    <img src="/files/{{$tema->tema_imagem}}" alt="{{$tema->titulo_redacao}}" style="height: 160px !important;">
                                </div>

                                <div class="item-content">
                                    <h3 class="item-title" style="text-align: left">{{$tema->titulo_redacao}}</h3>
                                </div>

                            </div>
                        </a>
                    </div>
               
                @endforeach
            
        </div>
    </div>
    @endif
</section>
@endsection


