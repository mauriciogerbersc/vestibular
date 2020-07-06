@extends('layout.app')

@section('conteudo')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Acessar ao Sistema</div>

                <div class="card-body">
                    <form method="POST">
                        @csrf
                        <input type="hidden" value="{{$hash}}" name="hash" />

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Endereço de Email</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">CPF</label>

                            <div class="col-md-6">
                                <input id="password" type="text"
                                    class="form-control cpf @error('password') is-invalid @enderror" 
                                    value="{{ old('password') }}" name="password"
                                    required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Acessar
                                </button>
                            </div>
                        </div>

                        <br>
                        @include('admin.mensagem', ['mensagem' => $mensagem ?? '', 'alert_tipo' => $alert_tipo ?? ''])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('assets/js/jquery.mask.js')}}"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
        
        $(".cpf").mask("99999999999");

    });
</script>
@endsection