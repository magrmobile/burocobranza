@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
        <div class="col">
            <h3 class="mb-0">Registrar Cartera</h3>
        </div>
        <div class="col text-right">
            <a href="{{ url('admin/route') }}" class="btn btn-sm btn-default">
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
    <form action="{{url('admin/route')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="name">Nombre</label>
            <input name="name" id="name" type="text" class="form-control form-control-sm">
        </div>
        <div class="form-group">
            <label for="address">Ciudad</label>
            <input name="address" id="address" type="text" class="form-control form-control-sm">
        </div>
        <div class="form-group">
            <label for="country">Pais</label>
            <select name="country" id="country" class="form-control form-control-sm">
                <option value="">Seleccionar Pais</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" @if(old('country') == $country->id) selected @endif>{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success btn-block btn-md">Guardar</button>
        </div>
    </form>
</div>
@endsection
