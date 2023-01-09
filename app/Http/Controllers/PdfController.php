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

        $pdf = PDF::loadView('pdfs.folha', [
            'computes' => $computes,
            'in'       => $request->in,
            'out'      => $request->out,
        ]);

        return $pdf->download("$codpes.pdf");
    }
}
