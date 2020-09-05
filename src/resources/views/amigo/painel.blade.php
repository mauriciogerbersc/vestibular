@extends('admin/layout/admin', ["current" => ""])

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
                <input type="search" class="form-control" placeholder="Buscar Convite">
                <button class="btn" type="button"><i data-feather="search"></i></button>
            </div>
        </div>
    </div><!-- container -->
</div><!-- content -->

<div class="content">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
            <div class="col-lg-9">
                <ul class="nav nav-line nav-line-profile mg-b-30">
                    <li class="nav-item">
                        <a href="" class="nav-link d-flex align-items-center active">Convites <span class="badge">{{$total_indicacoes}}</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">Inscritos <span class="badge">0</span></a>
                    </li>
                    <li class="nav-item d-none d-sm-block">
                        <a href="" class="nav-link">Matriculados <span class="badge">0</span></a>
                    </li>
                </ul>

                <div class="row row-xs mg-b-25">
                    @foreach($indicacoes as $indicacao)

                   
                 
                   
                    <div class="col-sm-4 col-md-3 col-lg-4 col-xl-3">
                        <div class="card card-profile">
                            <img src="https://via.placeholder.com/500" class="card-img-top" alt="">
                            <div class="card-body tx-13">
                                <div>
                                    <h5>{{$indicacao->name_indicado}}</h5>
                                    <p>{{$indicacao->email_indicado}}</p>
                                    <div class="mg-b-25">
                                    <span class="tx-12 tx-color-03"><strong>Data Envio:</strong> {{$indicacao->created_at->format('d/m/Y')}}</span><br>
                                        <span class="tx-12 tx-color-03"><strong>Código Convite:</strong> {{$indicacao->hash}}</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- card -->
                    </div><!-- col -->
                    @endforeach
                </div><!-- row -->
            </div><!-- col -->
            <div class="col-lg-3 mg-t-40 mg-lg-t-0">
                <div class="d-flex align-items-center justify-content-between mg-b-20">
                    <h6 class="tx-uppercase tx-semibold mg-b-0">Enviar novo Convite</h6>
                </div>
                <form method="POST" action="/indica-amigo/envia-convite">
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
                            <div class="media-body pd-l-5">
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
               
                <div class="d-flex align-items-center justify-content-between mg-t-40">
                    <h6 class="tx-uppercase tx-semibold mg-b-0">Compartilhe Também</h6>
                </div>
                <div class="d-flex tx-20 mg-t-10">
                    <div class=""><a class="share-popup" href="https://api.whatsapp.com/send?phone=&text=Acesse+matriculas.aerotd.com.br+e+use+meu+código+e+tenha+desconto+no+valor+da+sua+mensalidade.+Código: {{$hashGerada}}" target="_blank"><i class="fab fa-whatsapp"></i></a></div>
                    <div class="pd-l-10"><a class="share-popup" href="https://www.facebook.com/sharer/sharer.php?u=matriculas.aerotd.com.br&quote=Use+meu+código+e+tenha+desconto+no+valor+da+sua+mensalidade.+Código: {{$hashGerada}}" data-descriptions="alsadlasd" target="_blank"><i class="fab fa-facebook"></i></a></div>
                    <div class="pd-l-10"><a class="share-popup" href="https://twitter.com/share?url=matriculas.aerotd.com.br&&via=AeroTD&text=Use+meu+código+e+tenha+desconto+no+valor+da+sua+mensalidade.+Código: {{$hashGerada}}" target="_blank"><i class="fab fa-twitter"></i></a></div>
                    <div class="pd-l-10"><a class="share-popup"  href="https://www.linkedin.com/shareArticle?mini=true&url=matriculas.aerotd.com.br&summary=teste&title=teste"><i class="fab fa-linkedin"></i></a></div>
                </div>

                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                
            </div>
        </div><!-- row -->
    </div><!-- container -->
</div><!-- content -->


@endsection

@section('scripts')
<script>
$(".share-popup").click(function(){
    var window_size = "width=585,height=511";
    var url = this.href;
    var domain = url.split("/")[2];
    switch(domain) {
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