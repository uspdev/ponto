@extends('main')

@section('content')

@section('styles')
@parent
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">
@endsection

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
            <img style="width: 100px;" class="mb-3" src="data:image/png;base64, {{ \Uspdev\Wsfoto::obter($monitor['codpes']) }}" alt="foto">
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
      <div class="col-lg-auto p-3">
        <div class="card">
          <div class="card-body">

            <h5 class="card-title">Escolher período</h5>
            <div class="form-group form-inline">
              <div class="input-group">
                <input type="text" class="input-sm form-control datepickerStart" name="startDate" value="{{ date('d/m/Y') }}" />
                <input type="text" class="input-sm form-control datepickerEnd" name="endDate" value="{{ date('d/m/Y') }}" />
              </div>
            </div>

            <h5 class="card-title">Registros: {{ \Carbon\Carbon::today()->translatedFormat('l, d \d\e F \d\e Y') }}</h5>
            <ul class="list-group list-group-flush">
              @foreach ($registros as $registro)
                  <li class="list-group-item">
                    <i class="fa fa-building fa-lg ml-1"></i> {{ \App\Models\Place::find($registro->place_id)->name }}
                    {{ $registro->created_at->format('d/m/Y') }}
                    @if($registro->type == 'in')
                      <i class="fas fa-sign-in-alt text-success"></i> {{ $registro->created_at->format('H:i') }} (Entrada)
                      <a href="/registros/{{ $registro->id }}"><i class="fa fa-eye fa-lg text-info ml-1"></i></a>
                    @endif
                    @if($registro->type == 'out')
                        <i class="fas fa-sign-out-alt text-danger"></i> {{ $registro->created_at->format('H:i') }} (Saída)
                        <a href="/registros/{{ $registro->id }}"><i class="fa fa-eye fa-lg text-info ml-1"></i></a>
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

@section('javascripts_bottom')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<script type="text/javascript">
  $(function() {
    $('.datepickerStart').datepicker({
      format: "dd/mm/yyyy",
      startDate: "today",
      todayBtn: "linked",
      clearBtn: true,
      language: "pt-BR",
      orientation: "bottom auto",
      keyboardNavigation: false,
      calendarWeeks: true,
      todayHighlight: true
    });
    $('.datepickerEnd').datepicker({
      format: "dd/mm/yyyy",
      startDate: "today",
      todayBtn: "linked",
      clearBtn: true,
      language: "pt-BR",
      orientation: "bottom auto",
      keyboardNavigation: false,
      calendarWeeks: true,
      todayHighlight: true
    });
  });
</script>
@endsection