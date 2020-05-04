<?php 

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Inscrito;

class CadastroInscrito 
{
    public function cadastrarInscrito($inscrito): Inscrito
        {
        DB::beginTransaction();
        $inscrito = Inscrito::create([
            'firstName'     => $inscrito->firstName,
            'lastName'      => $inscrito->lastName,
            'nDocumento'    => $inscrito->nDocumento,
            'email'         => $inscrito->email,
            'cep'           => $inscrito->cep,
            'bairro'        => $inscrito->bairro,
            'cidade'        => $inscrito->cidade,
            'uf'            => $inscrito->uf,
            'endereco'      => $inscrito->endereco,
            'numero'        => $inscrito->numero,
            'complemento'   => $inscrito->complemento,
            'curso_id'      => $inscrito->curso_id,
            'status'        => $inscrito->status,
            'phone'         => $inscrito->phone
        ]);
        DB::commit();
        return $inscrito;
    }

}