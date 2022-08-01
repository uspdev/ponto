@extends('main')
@section('content')
  <form method="POST" action="/ocorrencias/{{$ocorrencia->id}}">
    @csrf
    @method('patch')
    @include('ocorrencias.partials.form')
  </form>
@endsection