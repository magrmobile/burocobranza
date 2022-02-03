@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-1">
        <div class="row align-items-center">
        <div class="col">
            <h3 class="mb-0">Asignar Monto Base</h3>
        </div>
        <div class="col text-right">
            <a href="{{ url('supervisor/agent') }}" class="btn btn-sm btn-default">
                Cancelar y volver
            </a>
        </div>
        </div>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{url('supervisor/agent')}}/{{$id}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group">
                <label for="name">Nombres:</label>
                <input type="text" name="name" value="{{$name}} {{$last_name}}" class="form-control" id="name" required>
            </div>
            <div class="form-group">
                <label for="name">Cartera:</label>
                <input type="text" name="name" value="{{$wallet_name}}" class="form-control" id="name" required>
            </div>
            <div class="form-group">
                <label for="base_number_current">Base actual:</label>
                <input type="number" name="base_number_current" value="{{$base_current}}"  readonly class="form-control" id="base_number_current" required>
            </div>
            <div class="form-group">
                <label for="base_number">Base:</label>
                <input type="number" name="base_number" class="form-control" id="base_number" required>
                <p class="text-muted">La nueva base se sumara con la base actual</p>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block btn-md">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection
