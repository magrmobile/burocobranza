@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-1">
        <div class="row align-items-center">
        <div class="col">
            <h3 class="mb-0">Rastreo</h3>
        </div>
        <div class="col text-right">
            <a href="{{ url('supervisor/tracker') }}" class="btn btn-sm btn-default">
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
        <form method="GET" action="{{url('supervisor/tracker')}}/{{ app('request')->input('id_agent') }}" enctype="multipart/form-data">
            <div class="form-group">
                <label for="date_start">Fecha</label>
                <div class="input-group mr-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                    </div>
                    <input class="form-control datepicker" placeholder="Seleccionar Fecha" type="text" name="date_start" id="date_start">
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block btn-md">Buscar</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
@endsection
