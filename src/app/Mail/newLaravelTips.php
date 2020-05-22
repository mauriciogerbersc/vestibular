<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class newLaravelTips extends Mailable
{
    use Queueable, SerializesModels;

    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\stdClass $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject($this->user->titulo);
        $this->to($this->user->email,$this->user->name);
        
        if(isset($this->user->hash)){
            return $this->markdown('mail.emailInscricaoConfirmacao', [
                'user' => $this->user
            ]);
        }else{
            if($this->user->titulo == 'teste'){
                return $this->markdown('mail.emailTeste', ['conteudo' => $this->user->conteudo]);
            }
            return $this->markdown('mail.emailBoletoInscricao', [
                'user' => $this->user
            ]);
        }
    }
}
