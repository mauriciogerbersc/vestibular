<?php

namespace App\Helpers;

use App\Payment;
use App\RedacaoAluno;
use App\StatusCandidato;

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

        $status_candidato = StatusCandidato::all();
        $statusArray = array();
        foreach ($status_candidato as $val) {
            $statusArray[$val->status_int] = $val->status;
        }

        return $statusArray[$status];
    }


    public static function retornaTipoTransacao(string $tipo)
    {

        $statusArray = array(
            'b' => 'Boleto',
            'cc' => 'Cartão de Crédito'
        );

        return $statusArray[$tipo];
    }


    public static function formatDate($date)
    {
        return date('d/m/Y H:i', strtotime($date));
    }

    public static function retornaStatusTransacao(int $status)
    {

        $statusArray = array(
            1 => 'Aguardando pagamento',
            2 => 'Em análise',
            3 => 'Paga',
            4 => 'Disponível',
            5 => 'Em disputa',
            6 => 'Devolvida',
            7 => 'Cancelada'
        );

        return $statusArray[$status];
    }

    public static function mes(string $mes){
        switch($mes){
            case "January":    $mes = "Jan";     break;
            case "February":    $mes = "Fev";   break;
            case "March":    $mes = "Mar";       break;
            case "Abril":    $mes = "Abr";       break;
            case "May":    $mes = "Mai";        break;
            case "June":    $mes = "Jun";       break;
            case "July":    $mes = "Jul";       break;
            case "August":    $mes = "Ago";      break;
            case "September":    $mes = "Set";    break;
            case "October":    $mes = "Out";     break;
            case "November":    $mes = "Nov";    break;
            case "December":    $mes = "Dez";    break; 
        }

        return $mes;
    }
    public static function retornaBadgeStatusInscrito(int $status, int $inscrito_id)
    {
        $statusBadges = array(
            0 => 'badge-danger',
            1 => 'badge-warning',
            2 => 'badge-success',
            4 => 'badge-info',
            5 => 'badge-dark',
            6 => 'badge-light'
        );

        return $statusBadges[$status];
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
