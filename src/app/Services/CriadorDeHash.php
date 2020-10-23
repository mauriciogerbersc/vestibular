<?php 

namespace App\Services;

use App\Hash;
use Hashids\Hashids;
use Illuminate\Support\Facades\DB;

class CriadorDeHash 
{
    public function criarHash(int $inscrito_id): Hash
    {

        $hasHash = Hash::where('inscrito_id', '=', $inscrito_id)->first();

        if($hasHash->id != ''){
            return $hasHash;
        }

        $hashids             = new Hashids('this is my salt', 20, 'abcdefgh123456789');
        $hashGerada          = $hashids->encode($inscrito_id);

        DB::beginTransaction();
            $hash = Hash::create(['hash' => $hashGerada, 'inscrito_id'=> $inscrito_id]);
        DB::commit();

        return $hash;
    }
}