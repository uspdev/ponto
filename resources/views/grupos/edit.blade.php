@extends('main')
@section('content')
  <form method="POST" action="/grupos/{{$grupo->id}}">
    @csrf
    @method('patch')
    @include('grupos.partials.form')
  </form>
@endsection