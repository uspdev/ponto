@extends('main')

@section('content')

<div class="card">
    <div class="card-header font-weight-bold">
        Registro
    </div>
    <div class="card-body">
        <h5>{{ Uspdev\Replicado\Pessoa::obterNome($registro->codpes) }}</h5>
        {{ $registro->created_at->translatedFormat('l\, d \d\e F \d\e Y') }}
        <br />
        @if ($registro->type == 'in')
            <i class="fas fa-sign-in-alt text-success"></i> {{ $registro->created_at->format('H:i:s') }} (Entrada)
        @endif

        @if ($registro->type == 'out')
            <i class="fas fa-sign-in-alt text-danger"></i> {{ $registro->created_at->format('H:i:s') }} (Saída)
        @endif
        <br />
        @if($registro->image != 'undefined')
            <img src="/registros/{{ $registro->id }}/picture" class="rounded img-thumbnail p-3 mt-3" alt="Foto">
        @endif
        <br>

        @if ($registro->motivo)
            <div> <b>Motivo:</b> {{ $registro->motivo }} </div>
        @endif

        @if ($registro->justificativa)
            <div> <b>Justicativa dada:</b> {{ $registro->justificativa }} </div>
        @endif

        @if ($registro->analise)
            <div> <b>Análise da Justificativa:</b> {{ $registro->analise }} </div>
        @endif

        @if ($registro->codpes_analise)
            <div> <b>Análisado por:</b> {{ $registro->codpes_analise }} </div>
        @endif
    </div>
</div>
@endsection