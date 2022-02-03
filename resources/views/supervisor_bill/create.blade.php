@extends('layouts.panel')

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">
@endsection

@section('content')
<div class="card shadow">
    <div class="card-header border-1 bg-secondary">
        <div class="row align-items-center">
        <div class="col">
            <h3 class="mb-0">Ingresar Gastos</h3>
        </div>
        <div class="col text-right">
            <a href="{{ url('/') }}" class="btn btn-sm btn-default">
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
        <form method="POST" action="{{url('supervisor/bill')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Cartera:</label>
                <select name="id_wallet" id="" required class="form-control">
                    @foreach($wallet as $w)
                        <option value="{{$w->id}}">{{$w->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="name">Tipo de gasto:</label>
                <select name="bill" id="" required class="form-control">
                    @foreach($list_bill as $l)
                        <option value="{{$l->id}}">{{$l->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Valor</label>
                <input type="number" class="form-control" required id="amount" name="amount">
            </div>
            <div class="form-group">
                <label for="amount">Detalle</label>
                <textarea name="description" class="form-control" required id="" cols="30" maxlength="100" rows="5"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block btn-md">Guardar</button>
                <a href="{{url('supervisor/bill/')}}" class="btn btn-info btn-block btn-md">Consultar</a>
            </div>
        </form>
    </div>
</div>
@endsection
