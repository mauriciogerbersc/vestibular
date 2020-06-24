@extends('admin/layout/admin', ["current" => "cursos"]))

@section('conteudo')

<div class="content content-fixed bd-b">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="/admin">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="/admin/cursos">Cursos Criados</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Editando Curso: <strong>{{$curso->curso}}</strong></li>
                    </ol>
                </nav>
                <h4 class="mg-b-0">Editar Curso</h4>
            </div>
        </div><!-- container -->
    </div><!-- content -->
</div>

<div class="content">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <form method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-row">

                <div class="form-group col-md-3">
                    <label for="curso">Modalidade</label>
                    <select class="form-control" name="modalidade">
                        <option {{ $curso->tipo_curso  == 'EAD' ? "selected" : ""}} value="EAD">EAD</option>
                        <option {{ $curso->tipo_curso  == 'Presencial' ? "selected" : ""}} value="Presencial">Presencial</option>
                    </select>
                </div>

                <div class="form-group col-md-5">
                    <label for="curso">Nome do Curso</label>
                    <input type="text" class="form-control" id="curso" name="curso" value="{{$curso->curso}}">
                </div>

                <div class="form-group col-md-4">
                    <label for="curso">URL do Curso (sem HTTP://)</label>
                    <input type="text" class="form-control" id="link_curso" name="link_curso" value="{{$curso->link_curso}}">
                </div>

            </div>

            <div class="form-row">

                <div class="form-group col-md-6">
                    <label for="imgCurso">Banner do Curso (Página Interna)</label>
                    <div class="custom-file">
                        <input type="text" name="old_banner" value="{{$curso->banner_curso}}" />
                        <input type="file" class="custom-file-input" id="customFile" name="banner_curso">
                        <label class="custom-file-label" for="customFile">Escolha o Arquivo</label>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="imgCurso">Imagem do Curso (Miniatura)</label>
                    <div class="custom-file">
                        <input type="text" name="old_image" value="{{$curso->imagem_curso}}" />
                        <input type="file" class="custom-file-input" id="customFileBanner" name="curso_imagem">
                        <label class="custom-file-label" for="customFileBanner">Escolha o Arquivo</label>
                    </div>
                </div>

            </div>

            <div class="form-row">

                <div class="form-group col-md-12">
                    <label for="descricaoCurso">Descrição do Curso</label>
                    <textarea id="wysiwyg_ckeditor" cols="30" rows="20" name="descricao">{{$curso->descricao}}</textarea>

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