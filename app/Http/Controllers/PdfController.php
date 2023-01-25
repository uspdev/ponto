<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\Util;
use Uspdev\Replicado\Pessoa;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Requests\pessoaRequest;
use Carbon\CarbonInterval;
use PDF;

class PdfController extends Controller
{
    public function folha(Request $request, $codpes){

        $request->validate([
            'in' => 'required|date_format:d/m/Y',
            'out' => 'required|date_format:d/m/Y'
        ]);

        $in = Carbon::createFromFormat('d/m/Y',$request->in);
        $out = Carbon::createFromFormat('d/m/Y',$request->out);

        $computes = Util::compute($codpes, $in, $out);
        
        if(count($computes) > 31) {
            $request->session()->flash('alert-danger',$request->in . ' e ' . $request->out . 
            ' inválidos. Selecione intervalo com até 31 dias.');
            return redirect('/pessoas/' . $codpes);
        }

        // dividindo computes em duas partes para o pdf
        if(count($computes) < 17) {
            $parte1 = $computes;
            $parte2 = [];  
        } else {
            $parte1 = array_slice($computes, 0, 17);
            $parte2 = array_slice($computes, 17, count($computes));
        }

        $pdf = PDF::loadView('pdfs.folha', [
            'parte1'   => $parte1,
            'parte2'   => $parte2,
            'computes' => $computes,
            'dias'     => array_keys($computes),
            'in'       => $request->in,
            'out'      => $request->out,
            'total'    => Util::computeTotal($computes)
        ]);

        return $pdf->download("$codpes.pdf");
    }
}
