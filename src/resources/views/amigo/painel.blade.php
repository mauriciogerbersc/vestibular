@extends('admin/layout/admin', ["current" => ""])
@section('css')
<link rel="stylesheet" href="{{asset('assets/css/simple-lightbox.min.css')}}" />
<style>
    .gallery a img {
        border: 2px solid #fff;
        -webkit-transition: -webkit-transform .15s ease;
        -moz-transition: -moz-transform .15s ease;
        -o-transition: -o-transform .15s ease;
        -ms-transition: -ms-transform .15s ease;
        transition: transform .15s ease;
        position: relative;
    }
</style>
@endsection

@section('conteudo')
<div class="content content-fixed bd-b" style="margin-top:20px !important;">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="#">Convide um Amigo</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Seus Convites</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0">Seus Convites</h4>
            </div>
            <div class="search-form mg-t-20 mg-sm-t-0">
                <a href="{{ route('sair_indicacao') }}" class="btn btn-outline-danger">Desconectar-se</a>
            </div>
        </div>
    </div><!-- container -->
</div><!-- content -->

<div class="content">
    <div class="container pd-x-0 pd-lg-x-5 pd-xl-x-0">
        <div class="row">
            <div class="col-lg-9">
                <ul class="nav nav-line nav-line-profile mg-b-30">
                    <li class="nav-item">
                        <a href="" class="nav-link d-flex align-items-center active">Convites <span class="badge">{{$total_indicacoes}}</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">Inscritos <span class="badge">{{$total_inscricoes}}</span></a>
                    </li>
                    <li class="nav-item d-none d-sm-block">
                        <a href="" class="nav-link">Matriculados <span class="badge">0</span></a>
                    </li>
                </ul>

                <ul class="list-inline d-flex mg-t-20 mg-sm-t-10 mg-md-t-0 mg-b-0">
                    <li class="list-inline-item d-flex align-items-center">
                        <span class="d-block wd-10 ht-10 bg-df-1 rounded mg-r-5"></span>
                        <span class="tx-sans tx-uppercase tx-10 tx-medium tx-color-03">Convite enviado</span>
                    </li>
                    <li class="list-inline-item d-flex align-items-center mg-l-5">
                        <span class="d-block wd-10 ht-10 bg-df-2 rounded mg-r-5"></span>
                        <span class="tx-sans tx-uppercase tx-10 tx-medium tx-color-03">Inscrito</span>
                    </li>
                    <li class="list-inline-item d-flex align-items-center mg-l-5">
                        <span class="d-block wd-10 ht-10 bg-df-3 rounded mg-r-5"></span>
                        <span class="tx-sans tx-uppercase tx-10 tx-medium tx-color-03">Matriculado</span>
                    </li>
                </ul>

                <br>

                <div class="row row-xs mg-b-25">
                    @foreach($indicacoes as $indicacao)

                    <div class="col-sm-4 col-md-3 col-lg-4 col-xl-3 ">
                        <div class="card card-profile   {!! Helper::retornaStatusIndicado($indicacao->email_indicado) !!} ">
                            <div class="card-body tx-13">
                                <div style="margin-top:0; align-items:NONE !IMPORTANT;">
                                    <h5 class="tx-white">{{$indicacao->name_indicado}}</h5>
                                    <p class="tx-color-01">{{$indicacao->email_indicado}}</p>
                                    <div class="mg-b-25">
                                        <span class="tx-12 tx-color-01"><strong>Data Envio:</strong> {{$indicacao->created_at->format('d/m/Y')}}</span><br>
                                        <span class="tx-12 tx-color-01"><strong>Código Convite:</strong> {{$indicacao->hash}}</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- card -->
                    </div><!-- col -->
                    @endforeach
                </div><!-- row -->
            </div><!-- col -->

            <div class="col-lg-3 bg-gray-100 pd-t-15 pd-b-10">
                <div class="col-sm-6 col-md-5 col-lg mg-t-10">
                    <div class="d-flex align-items-center justify-content-between mg-b-20">
                        <h6 class="tx-uppercase tx-semibold mg-b-0">Enviar novo Convite</h6>
                    </div>
                    <form method="POST" action="/indicacao/envia">
                        @csrf
                        <ul class="list-unstyled media-list mg-b-15">
                            <li class="align-items-center">
                                <div class="media-body pd-l-5">
                                    <input type="text" class="form-control @error('name_indicado') is-invalid @enderror" value="{{ old('name_indicado') }}" placeholder="Nome da pessoa" name="name_indicado" />
                                </div>
                            </li>
                            <li class="align-items-center mg-t-15">
                                <div class="media-body pd-l-5">
                                    <input type="email" class="form-control @error('email_indicado') is-invalid @enderror" value="{{ old('email_indicado') }}" placeholder="E-mail da pessoa" name="email_indicado" />
                                </div>
                            </li>

                            <li class="align-items-center mg-t-15">
                                <div class="media-body pd-l-5">
                                    <input type="text" class="form-control @error('celular_indicado') is-invalid @enderror" value="{{ old('celular_indicado') }}" placeholder="Celular da pessoa" name="celular_indicado" />
                                </div>
                            </li>

                            <li class="align-items-center mg-t-15">
                                <div class="media-body justify-content-center pd-l-5">
                                    <button class="btn btn-primary" type="submit">Enviar Convite</button>
                                </div>
                            </li>
                        </ul>
                        @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                            @endforeach
                        </div>
                        @endif
                        @include('admin.mensagem', ['mensagem' => $mensagem ?? '', 'alert_tipo' => $alert_tipo ?? ''])
                    </form>
                </div>
                <hr>
                <div class="col-sm-6 col-md-5 col-lg mg-t-20">
                    <div class="d-flex align-items-center justify-content-between mg-t-20">
                        <h6 class="tx-uppercase tx-semibold mg-b-0">Compartilhe Também</h6>
                    </div>


                    <div class="d-flex justify-content-center tx-20 mg-t-10">
                        <div class=""><a class="share-popup" href="https://api.whatsapp.com/send?phone=&text=Acesse+{{$_ENV['APP_MATRICULA']}}?hash={{$hashGerada}}+e+realize+sua+inscrição+com+20%+de+desconto" target="_blank"><i class="fab fa-whatsapp" style="font-size:24px"></i></a></div>
                        <div class="pd-l-10"><a class="share-popup" href="https://www.facebook.com/sharer/sharer.php?u=matriculas.aerotd.com.br&quote=Acesse+{{$_ENV['APP_MATRICULA']}}?hash={{$hashGerada}}+e+realize+sua+inscrição+com+20%+de+desconto" data-descriptions="alsadlasd" target="_blank"><i class="fab fa-facebook" style="font-size:24px"></i></a></div>
                        <div class="pd-l-10"><a class="share-popup" href="https://twitter.com/share?url=matriculas.aerotd.com.br&via=AeroTD&text=Acesse+{{$_ENV['APP_MATRICULA']}}?hash={{$hashGerada}}+e+realize+sua+inscrição+com+20%+de+desconto" target="_blank"><i class="fab fa-twitter" style="font-size:24px"></i></a></div>
                        <div class="pd-l-10"><a class="share-popup" href="https://www.linkedin.com/shareArticle?mini=true&url=matriculas.aerotd.com.br&summary=Acesse+{{$_ENV['APP_MATRICULA']}}?hash={{$hashGerada}}+e+realize+sua+inscrição+com+20%+de+desconto&title=teste"><i class="fab fa-linkedin" style="font-size:24px"></i></a></div>
                    </div>
                </div>
                <hr>

                <div class="col-sm-6 col-md-5 col-lg mg-t-20 mg-b-20">

                    <div class="d-flex align-items-center justify-content-between mg-t-20">
                        <h6 class="tx-uppercase tx-semibold mg-b-0">Link de Desconto Direto</h6>
                    </div>

                    <div class="d-flex tx-20 mg-t-10">
                        <input type="hidden" value="{{$_ENV['APP_MATRICULA']}}?hash={{$hashGerada}}" id="linkDisponibilizar">
                        <button class="btn btn-xs btn-warning" onclick="copiarLink()">Copiar Link</button>

                    </div>
                </div>
                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                <hr>

                <div class="col-sm-6 col-md-5 col-lg mg-t-20">
                    <div class="d-flex align-items-center justify-content-between mg-b-15">
                        <h6 class="tx-13 tx-uppercase tx-semibold mg-b-0">Peças para Indicação</h6>
                    </div>

                    <div class="row row-xxs gallery">
                        <div class="col-6">
                            <a href="{{asset('assets/images/indica/imagem1.jpeg')}}" class="d-block ht-110"><img src="{{asset('assets/images/indica/imagem1.jpeg')}}" class="img-fit-cover" alt=""></a>
                        </div><!-- col -->
                        <div class="col-6">
                            <a href="{{asset('assets/images/indica/imagem2.jpeg')}}" class="d-block ht-110"><img src="{{asset('assets/images/indica/imagem2.jpeg')}}" class="img-fit-cover" alt=""></a>
                        </div><!-- col -->
                        <div class="col-6 mg-t-2">
                            <a href="{{asset('assets/images/indica/imagem3.jpeg')}}" class="d-block ht-110"><img src="{{asset('assets/images/indica/imagem3.jpeg')}}" class="img-fit-cover" alt=""></a>
                        </div><!-- col -->
                        <div class="col-6 mg-t-2">
                            <a href="{{asset('assets/images/indica/imagem4.jpeg')}}" class="d-block ht-110"><img src="{{asset('assets/images/indica/imagem4.jpeg')}}" class="img-fit-cover" alt=""></a>
                        </div><!-- col -->
                        <div class="col-6 mg-t-2">
                            <a href="{{asset('assets/images/indica/imagem5.jpeg')}}" class="d-block ht-110"><img src="{{asset('assets/images/indica/imagem5.jpeg')}}" class="img-fit-cover" alt=""></a>
                        </div><!-- col -->

                    </div><!-- row -->
                </div>
            </div>
        </div><!-- row -->
    </div><!-- container -->
</div><!-- content -->


@endsection

@section('scripts')

<script src="{{asset('assets/js/simple-lightbox.jquery.min.js')}}"></script>
<script>
    (function() {
        var $gallery = new SimpleLightbox('.gallery a', {});
    })();

    function copyToClipboard(text) {
        var selected = false;
        var el = document.createElement('textarea');
        el.value = text;
        el.setAttribute('readonly', '');
        el.style.position = 'absolute';
        el.style.left = '-9999px';
        document.body.appendChild(el);
        if (document.getSelection().rangeCount > 0) {
            selected = document.getSelection().getRangeAt(0)
        }
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
        if (selected) {
            alert('Link copiado para seu ctrl + v.')
            document.getSelection().removeAllRanges();
            document.getSelection().addRange(selected);
        }
    };

    function copiarLink() {
        var copiar = document.getElementById("linkDisponibilizar").value;
        copyToClipboard(copiar);
    }

    $(".share-popup").click(function() {
        var window_size = "width=585,height=511";
        var url = this.href;
        var domain = url.split("/")[2];
        switch (domain) {
            case "www.facebook.com":
                window_size = "width=585,height=368";
                break;
            case "www.twitter.com":
                window_size = "width=585,height=261";
                break;
            case "wwww.linkedin.com":
                window_size = "width=585,height=494";
                break;
        }
        window.open(url, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,' + window_size);
        return false;
    });
</script>
@endsection