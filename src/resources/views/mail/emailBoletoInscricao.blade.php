@php
    $link = $user->link_boleto;
@endphp
@component('mail::message')

    <h1>Inscrição do Vestibular</h1>
    <p>Olá {{$user->name}},</p>
    <p>Parabéns por escolher o curso <strong>{{$user->curso}}</strong> da <a href="https://aerotd.com.br">Faculdade AeroTD</a></p>
    <p>Você já pode realizar o pagamento da sua inscrição através do link abaixo, basta clicar no botão abaixo que será redirecionado automáticamente.</p>
    @component('mail::button', ['url' => $link])
    Visualizar Boleto
    @endcomponent

@endcomponent