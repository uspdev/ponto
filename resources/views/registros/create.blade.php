@extends('main')

@section('content')

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
                <input type="number" class="" name="codpes" placeholder="" value="{{ old('codpes') }}">   
            </div>

            <div class="form-group">
                <select name="place_id">
                    <option value="" selected=""> - Selecione Local -</option>
                    @foreach ($places as $place)
                        <option value="{{ $place->id }}">
                            {{ $place->name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-success">Registrar</button> 
            </div>

        </div>
    </div>

</form>
@endsection