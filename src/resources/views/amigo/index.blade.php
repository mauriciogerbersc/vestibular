@extends('admin/layout/admin', ["current" => ""])

@section('conteudo')
<div class="content content-fixed content-auth">
    <div class="container">
        <div class="media align-items-stretch justify-content-center ht-100p pos-relative">
            <div class="media-body align-items-center d-none d-lg-flex">
                <div class="mx-wd-600">
                    <img src="{{asset('assets/images/banner-indicacao.jpeg')}}" class="img-fluid" alt="">
                </div>
            </div><!-- media-body -->
            <div class="sign-wrapper mg-lg-l-50 mg-xl-l-60">
                <form action="{{route('checkStudent')}}" method="POST">
                    @csrf
                    <div class="wd-200p" >
                        <h3 class="tx-color-01 mg-b-5">Acessar a Plataforma</h3>
                        <p class="tx-color-03 tx-16 mg-b-40">Acesse a Plataforma e indique seus amigos</p>

                        <div class="form-group">
                            <label>CPF do Aluno</label>
                            <input type="text" class="form-control cpf" name="cpf">
                        </div>

                        <button class="btn btn-brand-02 btn-block">Acessar</button>
                        <br>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif


                        @include('admin.mensagem', ['mensagem' => $mensagem ?? '', 'alert_tipo' => $alert_tipo ?? ''])
                    </div>
                </form>
            </div><!-- sign-wrapper -->
        </div><!-- media -->
    </div><!-- container -->
</div><!-- content -->
@endsection

@section('scripts')
<script src="{{asset('assets/js/jquery.mask.js')}}"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $(".cpf").mask("99999999999");
    });
</script>
@endsection