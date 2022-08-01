@extends('main')
@section('content')
  <form method="POST" action="/ocorrencias">
    @csrf
    @include('ocorrencias.partials.form')
  </form>
@endsection