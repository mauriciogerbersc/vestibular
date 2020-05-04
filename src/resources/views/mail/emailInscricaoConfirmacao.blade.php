@php
    $link = 'http://localhost:8080/vestibular/redacao?hash='.$user->hash;
@endphp
@component('mail::message')

    <h1>Inscrição do Vestibular</h1>
    <p>Olá {{$user->name}},</p>
    <p>Você já pode realizar a sua prova no vestibular da <a href="https://aerotd.com.br">AeroTD</a>, para realizar a prova para o curso
        <strong>{{$user->curso}}</strong>, basta clicar no botão abaixo que será redirecionado automáticamente
    </p>
    @component('mail::button', ['url' => $link])
    Faça sua prova
    @endcomponent

@endcomponent