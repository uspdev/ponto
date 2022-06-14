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
        {{-- // TODO: Na rota pictures os arquivos das fotos não podem ser públicos --}}
        <img src="pictures/{{ $registro->image }}" class="rounded img-thumbnail p-3 mt-3" alt="Foto">
    </div>
</div>

@endsection