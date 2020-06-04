<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileDownloadController extends Controller
{
    public function down(Request $request){
        if(file_exists(public_path(). "/files/historicos/".$request->arquivo))
        {
            $file = public_path(). "/files/historicos/".$request->arquivo;
        }else{ 
            $request->session()->flash('mensagem', "Histórico não encontrado.");
            $request->session()->flash('alert_tipo', "alert-danger");
        
            return redirect()->route('lista_inscritos');

        }
        $name = basename($file);
        return response()->download($file, $name);
    }
}
