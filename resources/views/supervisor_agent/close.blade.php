@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-1">
        <div class="row align-items-center">
        <div class="col">
            <h3 class="mb-0">Cerrar Dia</h3>
        </div>
        <div class="col text-right">
            <a href="{{ url('supervisor/close') }}" class="btn btn-sm btn-default">
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
        <form method="POST" action="{{url('supervisor/close')}}/{{$user->id}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group">
                <label for="base_amount">Agente:</label>
                <input type="text" name="base_amount" value="{{$user->name}} {{$user->last_name}}" readonly class="form-control" id="base_amount" required>
            </div>
            <div class="form-group">
                <label for="base_amount">Base del cobro:</label>
                <input type="text" name="base_amount_total" value="{{$base}}" readonly class="form-control" id="base_amount" required>
            </div>
            <div class="form-group">
                <label for="base_amount">Recaudo:</label>
                <input type="text" name="today" value="{{$today_amount}}" readonly class="form-control" id="base_amount" required>
            </div>
            <div class="form-group">
                <label for="base_amount">Ventas:</label>
                <input type="text" name="today" value="{{$today_sell}}" readonly class="form-control" id="base_amount" required>
            </div>
            <div class="form-group">
                <label for="base_amount">Gastos:</label>
                <input type="text" name="today" value="{{$bills}}" readonly class="form-control" id="base_amount" required>
            </div>
            <div class="form-group">
                <label for="base_amount">Total Cuadre:</label>
                <input type="text" name="total_today" value="{{$total}}" readonly class="form-control" id="base_amount" required>
            </div>
            <div class="form-group">
                <label for="base_amount">Efectividad:</label>
                <input type="text" name="today" value="{{$average}}" readonly class="form-control" id="base_amount" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block btn-md">Cerrar</button>
            </div>
        </form>
    </div>
</div>
@endsection
