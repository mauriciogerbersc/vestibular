<?php

namespace App\Helpers;

use App\Payment;
use App\RedacaoAluno;

class Helper
{
    public static function createSlug($string)
    {

        $table = array(
            'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
            'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
            'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
            'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
            'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
            'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r', '/' => '-', ' ' => '-'
        );

        // -- Remove duplicated spaces
        $stripped = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $string);

        // -- Returns the slug
        return strtolower(strtr($string, $table));
    }

    public static function retornaStatusInscrito(int $status, int $inscrito_id)
    {


        $redacao = RedacaoAluno::where('inscrito_id', '=', $inscrito_id)
            ->where('corrigido', 1)
            ->count();
        if ($redacao > 0) {
            $status = 4;
        }

        $statusArray = array(
            0 => 'Aguardando Pagamento',
            1 => 'Aguardando Redação',
            2 => 'Aguardando Correção',
            4 => 'Redação Corrigida'
        );

        return $statusArray[$status];
    }

    public static function retornaBadgeStatusInscrito(int $status, int $inscrito_id)
    {


        $redacao = RedacaoAluno::where('inscrito_id', '=', $inscrito_id)
            ->where('corrigido', 1)
            ->count();
        if ($redacao > 0) {
            $status = 4;
        }

        $statusArray = array(0 => 'badge-danger', 1 => 'badge-warning', 2 => 'badge-success', 4 => 'badge-info');

        return $statusArray[$status];
    }


    public static function tentouPagar(int $id)
    {

        $reference = Payment::where('reference', '=', $id)

            ->orderBy('status_transacao', 'desc')->get();

        foreach ($reference as $key => $val) {
            if ($val['status_transacao'] == 3) {
                return 3;
                break;
            } else {
                return 1;
                break;
            }
        }
    }
}
