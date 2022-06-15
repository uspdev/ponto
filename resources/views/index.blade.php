@extends('main')

@section('content')

<div class="card">
    <div class="card-header font-weight-bold">
        Registros
    </div>
    <div class="card-body">
        @foreach($places as $place)
        <div class="card mb-3">
            <div class="card-header">
                {{ $place->name }}
            </div>
            <ul class="list-group list-group-flush">
                @php
                    // Se logado
                    if (Auth::check()) {
                        // Traz todos os registros do dia no local
                        $registros = $place->registros->where('created_at', '>=', \Carbon\Carbon::today());
                    } else {
                        // Traz somente o último registro do dia no local
                        $registros = $place->registros->where('created_at', '>=', \Carbon\Carbon::today())->sortByDesc('id')->take(1);
                    }
                @endphp
                @forelse ($registros as $registro)
                    <li class="list-group-item">
                        {{-- Verifica se o registro é de entrada, do contrário no momento não tem monitor no local --}}
                        {{-- // TODO: Pode acontecer do monitor não ter esquecido de registrar a saída ou a entrada --}}
                        @if ($registro->type == 'in')
                            <i class="fas fa-sign-in-alt text-success"></i> {{ $registro->created_at->format('H:i') }} (Entrada)
                            - {{ \Uspdev\Replicado\Pessoa::obterNome($registro->codpes) }}
                        @elseif ($registro->type == 'out' && Auth::check())
                            <i class="fas fa-sign-in-alt text-danger"></i> {{ $registro->created_at->format('H:i') }} (Entrada)
                            - {{ \Uspdev\Replicado\Pessoa::obterNome($registro->codpes) }}
                        @else
                            Não há monitor(a) no local
                        @endif
                        {{-- Se foi parametrizado para mostrar foto do monitor --}}
                        @if (config('ponto.fotoMonitor') == 1)
                            <a href="#" data-toggle="modal" data-target="#modalFotoMonitor" title="Mostrar foto do monitor"
                                data-whatever="{{ \Uspdev\Replicado\Pessoa::obterNome($registro->codpes) }}, {{ \Uspdev\Wsfoto::obter($registro->codpes) }}">
                                <i class="fa fa-user-circle fa-lg text-info ml-1"></i>
                            </a>
                        @endif
                        @auth
                            {{-- Se logado mostrar a foto do registro --}}
                            <a href="#" data-toggle="modal" data-target="#modalFotoRegistro" title="Mostrar foto do registro"
                                data-whatever="{{ \Uspdev\Replicado\Pessoa::obterNome($registro->codpes) }}, '/registros/{{ $registro->id }}/picture'">
                                <i class="fa fa-camera fa-lg text-info ml-1"></i>
                            </a>
                        @endauth
                    </li>
                @empty
                    <li class="list-group-item">
                        Não há monitor(a) no local
                    </li>
                @endforelse
            </ul>
        </div>
        @endforeach
    </div>
</div>

@include('registros.partials.modal')

@include('monitores.partials.modal')

@endsection
