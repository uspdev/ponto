@extends('main')
@section('content')
@forelse ($ocorrencias as $ocorrencia)
@include('ocorrencias.partials.result')
@empty
Não há ocorrências resolvidas.
@endforelse
@endsection