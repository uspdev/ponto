@extends('main')

@section('content')

<div class="card">
  <div class="card-header font-weight-bold">
    {{ $monitor['codpes'] }} {{ $monitor['nompes'] }}
  </div>
  <div class="card-body">
    <div class="row">
      <div class="w-25 p-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Foto</h5>
            <img style="width: 100px; float: left;" src="data:image/png;base64, {{ \Uspdev\Wsfoto::obter($monitor['codpes']) }}" alt="foto">
          </div>
        </div>
      </div>
      <div class="w-75 p-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Ponto hoje {{ \Carbon\Carbon::today()->format('d/m/Y') }}</h5>
            <ul class="list-group list-group-flush">
              @foreach ($registros as $registro)
                  <li class="list-group-item">
                      {{ $registro->created_at->format('H:i') }}
                      @if($registro->type == 'in') (Entrada) @endif
                      @if($registro->type == 'out') (Saída) @endif
                  </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
