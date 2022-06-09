@extends('main')

@section('content')

<div class="card">
  <div class="card-header font-weight-bold">
    {{ $monitor['codpes'] }} {{ $monitor['nompes'] }}
  </div>
  <div class="card-body">
    <div class="card">
      <div class="card-header font-weight-bold">
        Foto
      </div>
      <div class="card-body">
        <img style="width: 100px; float: left;" src="data:image/png;base64, {{ \Uspdev\Wsfoto::obter($monitor['codpes']) }}" alt="foto">
      </div>
    </div>
  </div>
</div>

@endsection
