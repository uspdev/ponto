@extends('main')

@section('content')

<div class="card">
    <div class="card-header font-weight-bold">
        Registro
    </div>
    <div class="card-body">
        @if ($registro->type == 'in')
            <i class="fas fa-sign-in-alt text-success"></i> {{ $registro->created_at->format('H:i') }} (Entrada)
        @endif
        @if ($registro->type == 'out')
            <i class="fas fa-sign-in-alt text-danger"></i> {{ $registro->created_at->format('H:i') }} (Saída)
        @endif
        <br />
        <img style="width: 100px; float: left;" src="/storage/app/{{ $registro->image }}" alt="foto">
    </div>
</div>

@endsection