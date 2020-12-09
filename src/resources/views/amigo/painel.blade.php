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

    .btn-group button {
        border-radius: 7px;
        background-image: linear-gradient(to bottom, hsla(0, 0%, 0%, 0), hsla(0, 0%, 0%, 0.2));

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

                <div class="btn-group filters-button-group btn-group " role="group">
                    <button type="button" class="btn is-checked bg-df-1 tx-white" data-filter="*">Convites Enviados <span class="badge badge-danger">{{$total_indicacoes}}</span></button>
                    <button type="button" class="btn bg-df-2 tx-white" data-filter=".inscritos">Inscritos <span class="badge badge-danger">{{$total_inscricoes}}</span> </button>
                    <button type="button" class="btn bg-df-3 tx-white" data-filter=".matriculados">Matriculados <span class="badge badge-danger">0</span></button>

                </div>

                <!--
                <ul class="list-inline d-flex mg-t-20 mg-sm-t-10 mg-md-t-0 mg-b-0 filters-button-group">
                    <li class="list-inline-item d-flex align-items-center">
                        <span class="d-block wd-10 ht-10 bg-df-1 rounded mg-r-5"></span>
                        <span class="tx-sans tx-uppercase tx-10 tx-medium tx-color-03">Convite enviado </span>
                    </li>
                    <li class="list-inline-item d-flex align-items-center mg-l-5">
                        <span class="d-block wd-10 ht-10 bg-df-2 rounded mg-r-5"></span>
                        <span class="tx-sans tx-uppercase tx-10 tx-medium tx-color-03">Inscrito </span>
                    </li>
                    <li class="list-inline-item d-flex align-items-center mg-l-5">
                        <span class="d-block wd-10 ht-10 bg-df-3 rounded mg-r-5"></span>
                        <span class="tx-sans tx-uppercase tx-10 tx-medium tx-color-03">Matriculado <span class="badge">0</span></span>
                    </li>
                </ul>
-->


                <div class="grid mg-t-20">
                    @foreach($indicacoes as $indicacao)
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 element-item mg-b-10 {!! Helper::retornaClasseIndicado($indicacao->email_indicado) !!}">
                        <div class="card tx-white {!! Helper::retornaStatusIndicado($indicacao->email_indicado) !!}">
                            <div class="card-header tx-semibold">
                                {{$indicacao->name_indicado}}<br>
                                {{$indicacao->email_indicado}}
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    <strong>Data Envio:</strong> {{$indicacao->created_at->format('d/m/Y')}}</span>
                                </p>
                            </div>
                        </div>
                    </div>


                    @endforeach
                </div>

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
<script src="https://isotope.metafizzy.co/js/isotope-docs.min.js?6"></script>
<script>
    // init Isotope
    var iso = new Isotope('.grid', {
        itemSelector: '.element-item',
        layoutMode: 'fitRows'
    });

    // filter functions
    var filterFns = {
        // show if number is greater than 50
        numberGreaterThan50: function(itemElem) {
            var number = itemElem.querySelector('.number').textContent;
            return parseInt(number, 10) > 50;
        },
        // show if name ends with -ium
        ium: function(itemElem) {
            var name = itemElem.querySelector('.name').textContent;
            return name.match(/ium$/);
        }
    };

    // bind filter button click
    var filtersElem = document.querySelector('.filters-button-group');
    filtersElem.addEventListener('click', function(event) {
        // only work with buttons
        if (!matchesSelector(event.target, 'button')) {
            return;
        }
        var filterValue = event.target.getAttribute('data-filter');
        // use matching filter function
        filterValue = filterFns[filterValue] || filterValue;
        iso.arrange({
            filter: filterValue
        });
    });

    // change is-checked class on buttons
    var buttonGroups = document.querySelectorAll('.btn-group');
    for (var i = 0, len = buttonGroups.length; i < len; i++) {
        var buttonGroup = buttonGroups[i];
        radioButtonGroup(buttonGroup);
    }

    function radioButtonGroup(buttonGroup) {
        buttonGroup.addEventListener('click', function(event) {
            // only work with buttons
            if (!matchesSelector(event.target, 'button')) {
                return;
            }
            buttonGroup.querySelector('.is-checked').classList.remove('is-checked');
            event.target.classList.add('is-checked');
        });
    }


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