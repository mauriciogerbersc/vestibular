@extends('admin/layout/admin', ["current" => "temas"]))

@section('conteudo')




<div class="content content-fixed bd-b">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="/admin">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="/admin/redacao-temas">Temas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$redacao->titulo_redacao}}</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0">{{$redacao->titulo_redacao}}</h4>
            </div>
        </div><!-- container -->
    </div><!-- content -->
</div>

<div class="content">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <form method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-row">

                <div class="form-group col-md-8">
                    <label for="titulo">Título</label>
                    <input type="text" class="form-control" id="titulo" value="{{$redacao->titulo_redacao}}" name="titulo">
                </div>

                <div class="form-group col-md-4">
                    <label for="imgCurso">Imagem do Tema</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="tema_imagem" name="tema_imagem">
                        <input type="hidden" name="old_imagem" value="{{$redacao->tema_imagem}}" />
                        <label class="custom-file-label" for="tema_imagem">Escolha o Arquivo</label>
                    </div>
                </div>

            </div>


            <div class="form-row">

                <div class="form-group col-md-12">
                    <label for="descricaoCurso">Descrição do Curso</label>
                    <textarea id="wysiwyg_ckeditor" cols="30" rows="20" name="descricao">{{$redacao->descricao_redacao}}</textarea>

                </div>

            </div>


            <button type="submit" class="btn btn-primary mt-2">Salvar</button>
        </form>
    </div>
</div>

@endsection


@section('scripts')

<!-- ckeditor -->
<script src="{{asset('assets/bower_components/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('assets/bower_components/ckeditor/adapters/jquery.js')}}"></script>

<!--  wysiwyg editors functions -->
<script src="{{asset('assets/js/forms_wysiwyg.min.js')}}"></script>
@endsection