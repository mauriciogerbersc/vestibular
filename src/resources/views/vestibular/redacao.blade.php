@extends('layout/app')

@section('conteudo')


<section class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="breadcrumb-content text-center">
                    <h2>{{$redacaoTema->titulo_redacao}}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('selecionar_tema')}}">Temas</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$redacaoTema->titulo_redacao}}</li>
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
            <div class="col-lg-12 col-12">
                <h3>{{$redacaoTema->titulo_redacao}}</h3>
                <p>{!!$redacaoTema->descricao_redacao!!}</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row row-inside">
            <div class="col-lg-12 col-12">

                <div class="alert alert-success alert-dismissible fade show d-none messageBox" role="alert">
                    
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between" style="border:none">
                        <div id="contador">
                            Linhas:
                            <span class="atual">0</span> /
                            <span class="limite">25</span>
                        </div>
                        <span class="d-flex"><strong class="timer"></strong></span>
                    </li>
                </ul>
                <form name='formRedacao'>
                    @csrf
                    <input type="hidden" name="inscrito_id" value="{{ Auth::user()->inscrito_id }}" />
                    <input type="hidden" name="tema_id" value="{{$redacaoTema->id}}" />
                    <input type="hidden" name="enviou_redacao" value="0" />
                    <div class="form-group">
                        <textarea class="form-control" id="redacao" name="redacao" onkeyup="limitTextarea(this,25,105)" cols="20" rows="15">@if(isset($redacaoAnterior->redacao_aluno)) {{$redacaoAnterior->redacao_aluno}} @endif </textarea>
                    </div>

                    <button class="btn btn-primary btn-lg btn-block" type="submit" id="enviarFormulario">Enviar Redação</button>
                </form>
            </div>
        </div>

    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.rawgit.com/hilios/jQuery.countdown/2.2.0/dist/jquery.countdown.min.js"></script>

<script type="text/javascript" charset="utf-8">
    

    var oneHour = new Date().getTime() + 6000 * 60 * 15;
    //var fiveSeconds = new Date().getTime() + 5000;
    $('.timer').countdown(oneHour)
        // removed the elapsed: true
        .on('update.countdown', function(event) {
            var $this = $(this);
            if (event.elapsed) {
                $this.html(event.strftime('<span>%H:%M:%S</span>'));
            } else {
                $this.html(event.strftime('<span>%H:%M:%S</span>'));
            }
        })
    // added a finish.countdown callback, to
    //  hide the countdown altogether and
    //  have a little fun.
    .on('finish.countdown', function(){
        $(this).html('Tempo encerrado.');
        $("#redacao").attr('disabled', 'true');
        saveRedacao();
    });

    $("#enviarFormulario").click(function(){
        var checkstr =  confirm('Caso você confirme o envio da redação, não poderá retoma-la. Confirma o envio?');
        if(checkstr == true){
            $("input[name='enviou_redacao'").val(1);
            saveRedacao();
        }else{
            return false;
        }
    
    });

    function saveRedacao()
    {
        $('form[name=formRedacao]').submit(function(event){
            event.preventDefault();

            $.ajax({
                url: "{{ route('salvar_prova') }}",
                type: "POST",
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response){    
                    console.log(response);
                   if(response.success === true){
                       $('.messageBox').removeClass('d-none').html(response.message);
                       $("#redacao").attr('disabled', 'true');
                       $("#enviarFormulario").hide();
                       $(".timer").destroy();
                   }    
                }
            });
        });
    }

    /* Bloqueando colar na textarea */
    $('#redacao').bind('paste', function(event) {
         event.preventDefault();
    }); 


    /* Limitador de caracteres da textare */
    function limitTextarea(textarea, maxLines, maxChar) {
        var lines = textarea.value.replace(/\r/g, '').split('\n'), lines_removed, char_removed, i;
        if (maxLines && lines.length > maxLines) {
            
            lines = lines.slice(0, maxLines);
            lines_removed = 1
        }
        if (maxChar) {
            i = lines.length;
            $(".atual").text(i);
            while (i-- > 0) if (lines[i].length > maxChar) {
                lines[i] = lines[i].slice(0, maxChar);
                char_removed = 1
            }
            if (char_removed || lines_removed) {
                textarea.value = lines.join('\n')
            }
        }
    }
</script>
@endsection