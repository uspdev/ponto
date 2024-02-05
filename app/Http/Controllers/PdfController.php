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
use App\Models\Grupo;

class PdfController extends Controller
{
    public function folha(Request $request, $codpes){
        if (config('ponto.gerarFolha') == 'yes') {
            $permission = 'owner';
        } else {
            $permission = 'boss';
        }
        
        $this->authorize($permission, $codpes);

        $request->validate([
            'in' => 'required|date_format:d/m/Y',
            'out' => 'required|date_format:d/m/Y'
        ]);

        $in = Carbon::createFromFormat('d/m/Y',$request->in);
        $out = Carbon::createFromFormat('d/m/Y',$request->out);

        $datas = Util::listarDiasUteis($in->format('d/m/Y'), $out->format('d/m/Y'));

        $computes = Util::compute($codpes, $in, $out);
        
        if(count($computes) > 31) {
            $request->session()->flash('alert-danger',$request->in . ' e ' . $request->out . 
            ' inválidos. Selecione intervalo com até 31 dias.');
            return redirect('/pessoas/' . $codpes);
        }

        $nome = Pessoa::nomeCompleto($codpes);
        // supervisor
        $grupo = Grupo::getGroup($codpes);
        if($grupo) {
            $codpes_supervisor = $grupo->codpes_supervisor;
            $nome_supervisor = Pessoa::nomeCompleto($codpes_supervisor);
        } else {
            $request->session()->flash('alert-danger',"{$nome} não pertence a nenhum setor.");
            return redirect('/pessoas/' . $codpes);
        }

        $pdf = PDF::loadView('pdfs.folha', [
            'computes' => $computes,
            'dias'     => array_keys($computes),
            'in'       => $request->in,
            'out'      => $request->out,
            'total'    => Util::computeTotal($computes),
            'codpes'             => $codpes,
            'codpes_supervisor'  => $codpes_supervisor,
            'nome'               => $nome,
            'nome_supervisor'    => $nome_supervisor,
            'datas'              => $datas,
        ]);

        return $pdf->download("$codpes.pdf");
    }
}
