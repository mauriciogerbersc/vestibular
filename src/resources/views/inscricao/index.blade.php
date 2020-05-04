@extends('layout/app')

@section('conteudo')

<section class="service-wrap-layout1 bg-accent bg-common bg-image-cursos"
    data-bg-image="{{asset('assets/images/figure/banner-shape1.png')}}">
    <div class="container">
        <div class="heading-layout1 heading-light">
            <div class="item-subtitle">Nossos Cursos</div>
            <h2>Presencial e Semi-Presencial</h2>
        </div>
        <div class="row">
            @foreach($cursos as $curso)
            <div class="col-lg-4 col-md-6">
                <div class="service-box-layout1">
                    <div class="item-img">
                        <img src="files/{{$curso->imagem_curso}}" />
                    </div>
                    <div class="item-content">
                        <h3 class="item-title">{{$curso->curso}}</h3>
                        
                        <p>
                            <a class="btn btn-secondary" href="/inscricao/{{$curso->slug}}" role="button">Visualizar Detalhes »</a>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>

@endsection