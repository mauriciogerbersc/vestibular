<?php 

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CriadorDeUsuario 
{
    public function criarUsuario(string $name, string $email, int $cpf, int $id): User
    {

        $user = User::where('email', '=', $email)->first();
       
        if($user){
            return $user;
        } 

        $cpf = trim($cpf);
        $cpf = bcrypt($cpf);
        DB::beginTransaction();
            $user = User::create(['name' => $name, 'email' => $email, 'password' => $cpf, 'inscrito_id' => $id]);
        DB::commit();

        return $user;
    }
}