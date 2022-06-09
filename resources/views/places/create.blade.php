@extends('main')

@section('content')

<div class="card">
    <div class="card-header font-weight-bold">
        Novo local
    </div>
    <div class="card-body">
        <form method="POST" action="/places" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label for="name"><b>Nome</b></label>
                        <input type="text" class="form-control" name="name" placeholder="" value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Criar</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>

@endsection