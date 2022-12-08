@extends('main')
@section('content')
  <form method="POST" action="/grupos">
    @csrf
    @include('grupos.partials.form')
  </form>
@endsection