@extends('main')

@section('content')

<div class="card">
  <div class="card-header font-weight-bold">
    {{ $pessoa['codpes'] }} {{ $pessoa['nompes'] }}
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-lg-auto p-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Foto</h5>
            <img style="width: 100px; float: left;" src="data:image/png;base64, {{ \Uspdev\Wsfoto::obter($pessoa['codpes']) }}" alt="foto">
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

        <br>
        
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Filtrar período:</h5>
            <form method="GET">
              Início: <input name="in" value="{{ request()->in }}"><br>
              <br>
              Fim: <input name="out" value="{{ request()->out }}">
              <button type="submit" class="btn btn-success">Filtrar</button>   
          </div>
        </div>

        <br>

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Filtrar período:</h5>
            <b>Total no período: </b>{{ $total }} <br>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Dia</th>
                  <th scope="col">Ocorrência</th>
                </tr>
              </thead>
              <tbody>
                @foreach($computes as $day=>$values)
                  <tr>
                    <th scope="row">{{ $day }}</th>
                    <td>
                      @forelse($values as $entries)
                        @foreach($entries as $time=>$minutes)
                          {{ $time }}:
                          <b>
                            @if($minutes > 0) 
                              {{ \Carbon\CarbonInterval::minutes($minutes)->cascade()->locale('pt_Br')->forHumans() }}
                            @else 
                              Inválido
                            @endif
                          </b>
                          <br>
                        @endforeach
                      @empty 
                      sem registro 
                      @endforelse
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

      </div>
      <div class="col-lg-7 p-3">          
        <div class="card">
        <div class="card-body">
          <h5 class="card-title">Registros</h5>
          <ul class="list-group list-group-flush">
            @foreach ($registros as $registro)
              <li class="list-group-item">
                @if($registro->type == 'in')
                  <i class="fas fa-sign-in-alt text-success"></i> <a href="/registros/{{ $registro->id }}">{{ $registro->created_at->format('d/m/Y - H:i') }} (Entrada)</a>
                @endif
                @if($registro->type == 'out')
                    <i class="fas fa-sign-out-alt text-danger"></i> <a href="/registros/{{ $registro->id }}">{{ $registro->created_at->format('d/m/Y - H:i') }} (Saída)</a>
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
