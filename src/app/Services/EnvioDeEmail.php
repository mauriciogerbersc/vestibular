<?php 

namespace App\Services;
use Illuminate\Support\Facades\Mail;
use stdClass;

class EnvioDeEmail 
{

    public function enviarEmailInscricao(string $paraNome, string $paraEmail, string $curso, string $hash){
        $user = new stdClass();
        $user->name = $paraNome;
        $user->email = $paraEmail;
        $user->curso = $curso;
        $user->hash  = $hash;
        $user->titulo = "Inscrição para Vestibular - AeroTD";
        $this->enviarEmail($user);
    }

    public function emailBoleto(string $paraNome, string $paraEmail, string $curso, string $link_boleto){
        $user = new stdClass();
        $user->name = $paraNome;
        $user->email = $paraEmail;
        $user->curso = $curso;
        $user->link_boleto = $link_boleto;
        $user->titulo = "Boleto de inscrição - AeroTD";
        $this->enviarEmail($user);
    }

    public function enviarEmailIndicacao(string $tipo, string $paraNome, string $paraEmail, string $hash){
        $user = new stdClass();
        $user->name = $paraNome;
        $user->email = $paraEmail;
        $user->hash  = $hash;
        $user->tipo = $tipo;
        $user->titulo = "Programa de indicações - AeroTD";
        $this->enviarEmail($user);
    }

    public function enviaEmailTeste(string $paraEmail, string $conteudo){
      
        $user = new stdClass();
        $user->titulo = "teste";
        $user->name = "Mauricio teste";
        $user->email = $paraEmail;
        $user->conteudo = $conteudo;
        $this->enviarEmail($user);
    }

    public function enviarEmail($user){
        Mail::send(new \App\Mail\newLaravelTips($user));
    }
}