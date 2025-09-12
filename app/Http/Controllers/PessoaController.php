<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Uspdev\Replicado\Pessoa;
use Uspdev\Replicado\Beneficio;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Requests\pessoaRequest;
use Carbon\CarbonInterval;

use App\Models\Registro;
use App\Models\Grupo;

use App\Utils\Util;
use Illuminate\Support\Facades\Auth;

class PessoaController extends Controller
{
    public function index()
    {
        $this->authorize("boss");

        return view("pessoas.index", [
            "grupos" => Grupo::gruposWithPessoas(),
        ]);
    }

    public function show(Request $request, $codpes = "my")
    {
        if ($codpes != "my") {
            $this->authorize("boss");
            $pessoa["codpes"] = $codpes;
        } else {
            $this->authorize("logado");
            $pessoa["codpes"] = auth()->user()->codpes;
        }

        $pessoa["nompes"] = Pessoa::obterNome($pessoa["codpes"]);

        $emails = Pessoa::emails($pessoa["codpes"]);
        $telefones = Pessoa::telefones($pessoa["codpes"]);

        // Verificar o início e fim da folha no Grupo que a pessoa pertence
        $inicio_folha = Grupo::getGroup($pessoa["codpes"])
            ? Grupo::getGroup($pessoa["codpes"])->inicio_folha
            : 21;
        $fim_folha = Grupo::getGroup($pessoa["codpes"])
            ? Grupo::getGroup($pessoa["codpes"])->fim_folha
            : 20;
        // Formato dia com dois dígitos
        $inicio_folha =
            strlen($inicio_folha) < 2 ? "0" . $inicio_folha : $inicio_folha;
        $fim_folha = strlen($fim_folha) < 2 ? "0" . $fim_folha : $fim_folha;

        if (!empty($request->in) and !empty($request->out)) {
            $request->validate([
                "in" => "required|date_format:d/m/Y",
                "out" => "required|date_format:d/m/Y",
            ]);
            // Ajustando a data de fim de folha quando for Bolsista
            if ($inicio_folha == 1) {
                // Bolsistas Pró-Aluno, inicia dia 1º e vai até o último dia do mês
                $request->out = Carbon::createFromFormat("d/m/Y", $request->in)
                    ->modify("last day of this month")
                    ->format("d/m/Y");
            }
        } else {
            // Se o dia corrente é dia 31, não estava subtraindo 1 mês em $request->in
            // https://stackoverflow.com/questions/9058523/php-date-and-strtotime-return-wrong-months-on-31st Answer #31
            $base = strtotime(date("Y-m", time()) . "-01 00:00:01");
            if ($inicio_folha == 1) {
                // Bolsistas Pró-Aluno, inicia dia 1º e vai até o último dia do mês
                $request->in = $inicio_folha . "/" . date("m/Y");
                $request->out = Carbon::createFromFormat("d/m/Y", $request->in)
                    ->modify("last day of this month")
                    ->format("d/m/Y");
            } else {
                // Estagiários setores, inicia dia 21 e vai até o dia 20 do outro mês
                // Se o dia corrente é menor ou igual ao dia de fim da folha, ex.: data corrente 01/12/2023, trazer início 21/11/2023 à 20/12/2023
                if (now()->format("d") <= $fim_folha) {
                    // Diminui 1 mês na data de início da folha
                    $request->in =
                        $inicio_folha .
                        "/" .
                        date("m/Y", strtotime("-1 month", $base));
                    $request->out = $fim_folha . "/" . date("m/Y");
                } else {
                    // Aumenta 1 mês na data de fim da folha
                    $request->in = $inicio_folha . "/" . date("m/Y");
                    $request->out =
                        $fim_folha .
                        "/" .
                        date("m/Y", strtotime("+1 month", $base));
                }
            }
        }

        $in = Carbon::createFromFormat(
            "d/m/Y H:i:s",
            $request->in . " 00:00:00"
        );
        $out = Carbon::createFromFormat(
            "d/m/Y H:i:s",
            $request->out . " 23:59:59"
        );

        $datas = Util::listarDiasUteis(
            $in->format("d/m/Y"),
            $out->format("d/m/Y")
        );

        $computes = Util::compute($pessoa["codpes"], $in, $out);

        if (count($computes) > 31) {
            $request
                ->session()
                ->flash(
                    "alert-danger",
                    "O intervalo de " .
                        $request->in .
                        " até " .
                        $request->out .
                        " é inválido. Selecione intervalo com no máximo 31 dias."
                );
            return redirect("/pessoas/" . $codpes);
        }

        $registros = Registro::where("created_at", ">=", $in)
            ->where("created_at", "<=", $out)
            ->where("codpes", "=", $pessoa["codpes"])
            ->get();

        // Totalizador
        $total = Util::computeTotal($computes);
        $carga_horaria_semanal = (!Grupo::getGroup($pessoa['codpes'])) ? 0 : Grupo::getGroup($pessoa['codpes'])->carga_horaria;
        $quantidade_dias_uteis = Util::contarDiasUteis(request()->in, request()->out);
        $carga_horaria_total = $quantidade_dias_uteis * ($carga_horaria_semanal / 5);
        $total_resgistrado = (!empty($total)) ? $total : '0 horas';
        
        // Criar os intervalos
        $intervalo1 = CarbonInterval::hours(88); # SUBSTITUIR
        $intervalo2 = CarbonInterval::hours(54)->minutes(40); # SUBSTITUIR

        // Converter para minutos
        $min1 = $intervalo1->totalMinutes;
        $min2 = $intervalo2->totalMinutes;

        // Calcular a diferença
        $diff = $min1 - $min2;

        // Converter em horas e minutos totais
        $horas = intdiv($diff, 60);
        $minutos = $diff % 60;

        // Exibir em formato hh:mm
        $saldo = "$horas horas e $minutos minutos";
        
        $totalizador = [
            'carga_horaria_semanal' => $carga_horaria_semanal, # inteiro (horas)
            'quantidade_dias_uteis' => $quantidade_dias_uteis, # inteiro (dias)
            'carga_horaria_total' => $carga_horaria_total, # inteiro (horas)
            'total_registrado' => $total_resgistrado, # string (hh horas e mm minutos)
            'saldo' => $saldo, # string (hh horas e mm minutos)
        ];    

        return view("pessoas.show", [
            "pessoa" => $pessoa,
            "emails" => $emails,
            "telefones" => $telefones,
            "registros" => $registros,
            "computes" => $computes,
            "total" => $total,
            'totalizador' => $totalizador,
            "datas" => $datas,
        ]);
    }

    public function listarMonitoresProAluno()
    {
        $codigoSalaMonitor = config("ponto.codigoSalaMonitor");
        return view("pessoas.proaluno", [
            "pessoas" => Beneficio::listarMonitoresProAluno($codigoSalaMonitor),
        ]);
    }
}

