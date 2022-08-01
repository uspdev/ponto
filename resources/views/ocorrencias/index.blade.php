@extends('main')
@section('content')
  @forelse ($ocorrencias as $ocorrencia)
    @include('ocorrencias.partials.fields')
  @empty
    Não há ocorrências cadastradas.
  @endforelse
@endsection