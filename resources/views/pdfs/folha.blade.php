<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
	<style>
        table, th, td {
            border: 0.5px solid black;
            border-spacing: 0px;
        }

        table.dados, th.dados, td.dados {
            border-left: none;
            border-right: none;
        }
    </style>
</head>

<body>
    <table style='width:100%'>
        <tr>
            <td width='12%' style='text-align:center;'>
                <img src='https://imagens.usp.br/wp-content/uploads/USP-Bras%C3%A3o-466x540.jpg' height='60px'/>
            </td>
            <td width='76%' style='text-align:center;'>
                <p align='center'><b>UNIVERSIDADE DE SÃO PAULO</b>
                <br>Controle de Frênquecia<br>
                </p>
            </td>
            <td swidth='12%' style='text-align:center;'>
                <span style='font-size: 9px'>{{ $in }} a {{ $out }} </span>
            </td>
        </tr>
	</table>
    <p align='center'><b>DADOS DO ESTAGIÁRIO</b></p>

    <table class="dados" style='width:100%'>
        <tr>
            <td class="dados" style='width:30%'><span style='font-size: 8px'>Número USP</span></td>
            <td class="dados" style='width:70%'><span style='font-size: 8px'>Nome</span></td>
        </tr>
        <tr>
            <td class="dados">{{ $codpes }}</td>
            <td class="dados">{{ $nome }}</td>

        </tr>
        <tr>
            <td class="dados" style='width:30%'><span style='font-size: 8px'>Número USP</span></td>
            <td  class="dados"style='width:70%'><span style='font-size: 8px'>Supervisor Interno</span></td>
        </tr>
        <tr>
            <td class="dados">{{ $codpes_supervisor }}</td>
            <td class="dados">{{ $nome_supervisor }}</td>
        </tr>
    </table>

    <p align='center'><b>FREQUÊNCIA NO PERÍODO</b></p>

    <table style='width:100%'>
        <tr>
            <td style='width:10%'>Dia</td>
            <td style='width:20%'>Ocorrência</td>
            <td style='width:20%'>Registro</td>
            <td style='width:10%'>Dia</td>
            <td style='width:20%'>Ocorrência</td>
            <td style='width:20%'>Registro</td>
        </tr>

        @for($i = 0; $i <= 16; $i++)
            @if(array_key_exists($i, $dias))  
                @php $col1 = App\Utils\Util::computeDayMinutes($computes,$dias[$i]); @endphp
            @else 
                @php $col1 = ['','',''] @endphp
            @endif

            @if(array_key_exists($i+16, $dias))  
                @php $col2 = App\Utils\Util::computeDayMinutes($computes,$dias[$i+16]); @endphp
            @else 
                @php $col2 = ['','',''] @endphp
            @endif

            <tr>
                <td><b>{{ $col1[0] }}</b></td>
                <td>{{{ $col1[1] }}}</td>
                <td>{{ $col1[2] }}</td>

                <td><b>{{ $col2[0] }}</b></td>
                <td>{{{ $col2[1] }}}</td>
                <td>{{ $col2[2] }}</td>
            </tr>
        @endfor
    </table>
    <br><br>
    Declaro, para fins de remuneração da bolsa de complementação de estágio, 
    que o estagiário acima identificado cumpriu <u>{{ $total }}</u> de estágio entre <i>{{$in}} e {{$out}}</i>.

    <br><br><br>
    <table style='width:100%'>
        <tr>
            <td class="dados" style='width:35%'><span style='font-size: 8px'>Assinatura do Estagiário</span></td>
            <td class="dados" style='width:10%'><span style='font-size: 8px'>Data</span></td>
            <td class="dados" style='width:40%'><span style='font-size: 8px'>Assinatura do Supervisor Interno</span></td>
            <td class="dados" style='width:10%'><span style='font-size: 8px'>Data</span></td>
        </tr>

        <tr>
            <td class="dados" style='width:35%; height:60px'></span>_______________________________</td>
            <td class="" style='width:10%'></span>____/____/____</td>
            <td class="" style='width:40%'></span>_______________________________</td>
            <td class="dados" style='width:10%'></span>____/____/____</td>
        </tr>

    </table>
</body>
</html>