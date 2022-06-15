@extends('main')

@section('content')

<div class="card">
  <div class="card-header font-weight-bold">
    {{ $monitor['codpes'] }} {{ $monitor['nompes'] }}
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-lg-auto p-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Foto</h5>
            <img style="width: 100px; float: left;" src="data:image/png;base64, {{ \Uspdev\Wsfoto::obter($monitor['codpes']) }}" alt="foto">
          </div>
        </div>
      </div>
      <div class="col-lg-3 p-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Contato</h5>
            @foreach ($emails as $email)
            <i class="fas fa-envelope"></i> {{ $email }}<br />
            @endforeach
            @foreach ($telefones as $telefone)
            <i class="fas fa-phone"></i> {{ $telefone }}<br />
            @endforeach
          </div>
        </div>
      </div>
      <div class="col-lg-7 p-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Registros: {{ \Carbon\Carbon::today()->translatedFormat('l, d \d\e F \d\e Y') }}</h5>
            <ul class="list-group list-group-flush">
              @foreach ($registros as $registro)
                  <li class="list-group-item">
                    <i class="fa fa-building fa-lg ml-1"></i> {{ \App\Models\Place::find($registro->place_id)->name }}
                    @if($registro->type == 'in')
                      <i class="fas fa-sign-in-alt text-success"></i> {{ $registro->created_at->format('H:i') }} (Entrada)
                      <a href="/registros/{{ $registro->id }}"><i class="fa fa-camera fa-lg text-info ml-1"></i></a>
                    @endif
                    @if($registro->type == 'out')
                        <i class="fas fa-sign-out-alt text-danger"></i> {{ $registro->created_at->format('H:i') }} (Saída)
                        <a href="/registros/{{ $registro->id }}"><i class="fa fa-camera fa-lg text-info ml-1"></i></a>
                    @endif
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
