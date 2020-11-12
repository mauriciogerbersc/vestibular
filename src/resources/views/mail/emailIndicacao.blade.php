@php
    $link = $_ENV['APP_MATRICULA'].'?hash='.$user->hash;
@endphp
@component('mail::message')

    <h1>Programa de Indicação</h1>
    <p>Olá {{$user->name}},</p>
    <p>Você foi indicado para o programa de bônus da <a href="https://aerotd.com.br">AeroTD</a>, para realizar a inscrição em curso, 
    basta clicar no botão abaixo que será redirecionado automáticamente já com desconto aplicado.
    </p>
    @component('mail::button', ['url' => $link])
    Faça sua Inscrição
    @endcomponent

@endcomponent