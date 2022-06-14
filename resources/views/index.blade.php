@extends('main')

@section('content')

<div class="card">
    <div class="card-header font-weight-bold">
        Registros
    </div>
    <div class="card-body">
        @foreach($places as $place)
        <div class="card">
        <div class="card-header">
            {{ $place->name }}
        </div>
        <ul class="list-group list-group-flush">
            @forelse($place->registros->where('created_at', '>=', \Carbon\Carbon::today()) as $registro)
                <li class="list-group-item">
                    @if($registro->type == 'in')
                        <i class="fas fa-sign-in-alt text-success"></i> {{ $registro->created_at->format('H:i') }} (Entrada)
                    @endif
                    @if($registro->type == 'out')
                        <i class="fas fa-sign-out-alt text-danger"></i> {{ $registro->created_at->format('H:i') }} (Saída)
                    @endif
                    - {{ \Uspdev\Replicado\Pessoa::obterNome($registro->codpes) }}
                </li>
            @empty
            <li class="list-group-item">Não há monitor(a) no local</li>
            @endforelse
        </ul>
        </div>
        <br>
    @endforeach
    </div>
</div>

@endsection