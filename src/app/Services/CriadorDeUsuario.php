<?php 

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CriadorDeUsuario 
{
    public function criarUsuario(string $name, string $email, int $cpf, int $id): User
    {

        $cpf = trim($cpf);
        $cpf = Hash::make($cpf);
        DB::beginTransaction();
            $user = User::create(['name' => $name, 'email' => $email, 'password' => $cpf, 'inscrito_id' => $id]);
        DB::commit();

        return $user;
    }
}