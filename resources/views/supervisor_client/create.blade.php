@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-1">
        <div class="row align-items-center">
        <div class="col">
            <h3 class="mb-0">Editar Cliente</h3>
        </div>
        <div class="col text-right">
            <a href="{{ url('/') }}" class="btn btn-sm btn-default">
                Cancelar y volver
            </a>
        </div>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{url('supervisor/client')}}" class="supervisor-client" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="country">Pais</label>
                <select name="country" class="form-control" id="country">
                    <option selected>Selecionar ....</option>
                    @foreach($countries as $country)
                        <option value="{{$country->id}}">{{$country->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="wallet">Cartera</label>
                <select name="wallet" class="form-control" id="wallet">
                    <option selected>Selecionar ....</option>
                    @foreach($wallet as $w)
                        <option value="{{$w->id}}">{{$w->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="agent">Agente</label>
                <select name="agent" class="form-control" id="agent">
                    <option selected>Selecionar ....</option>
                    @foreach($agents as $a)
                        <option value="{{$a->id}}">{{$a->name}} {{$a->last_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="hidden btn btn-success btn-block btn-md">Guardar</button>
                <a id="link_client_audit" class="btn btn-success btn-block" disabled href="{{url('supervisor/client')}}">Auditar</a>
            </div>
        </form>
    </div>
</div>
@endsection
