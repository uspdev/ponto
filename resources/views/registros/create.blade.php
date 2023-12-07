@extends('main')

@section('content')

<div class="card">
    <div class="card-header font-weight-bold">
        Registrar ponto
    </div>
    <div class="card-body">
        <div class="w-100 text-center mb-2">
            <span class="badge badge-pill badge-info mb-2" style="font-size: 1.2em;">
                {{ \Carbon\Carbon::now()->translatedFormat('l\, d \d\e F \d\e Y') }}</span>
            <span class="badge badge-pill badge-success" style="font-size: 1.2em;"><i class="fas fa-clock"></i>
                {{ \Carbon\Carbon::now()->format('H:i') }}</span>
        </div>
        @include('registros.partials.foto')
        <form method="POST" action="/registros" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm">
                    <input id="foto" type="hidden" name="foto">
                    <div class="contentarea">
                        <div class="camera">
                            <video id="video">Video stream not available.</video>
                        </div>
                        <div><button id="startbutton">Tirar Foto</button></div>

                        <canvas id="canvas"></canvas>
                        <div class="output">
                            <img id="photo" alt="The screen capture will appear in this box.">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="codpes"><b>Número USP</b></label>
                        <input type="number" class="" name="codpes" placeholder="Digite seu Nº USP" value="{{ Auth::user()->codpes }}">
                    </div>
                    <div class="form-group">
                        <label for="place_id"><b>Local</b></label>
                        <select name="place_id">
                            @if (count($places) > 1)
                                <option value="" selected="">Selecione o local ...</option>
                            @endif
                            @foreach ($places as $place)
                                <option value="{{ $place->id }}">
                                    {{ $place->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success"><i class="fa fa-user-clock"></i> Registrar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection