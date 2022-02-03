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
            <h3 class="mb-0">Consulta de Gastos</h3>
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
        <form class="form-inline" method="GET" {{url('supervisor/bill')}}>
            <div class="form-group">
                <label class="sr-only" for="date_start">Fecha Inicio</label>
                <div class="input-group mr-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                    </div>
                    <input class="form-control datepicker" placeholder="Fecha Inicio" type="text" name="date_start" id="date_start">
                </div>
            </div>
            <div class="form-group">
                <label class="sr-only" for="date_end">Fecha Final</label>
                <div class="input-group mr-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                    </div>
                    <input class="form-control datepicker" placeholder="Fecha Final" type="text" name="date_end" id="date_end">
                </div>
            </div>
            <div class="form-group mr-2">
                <select name="category" required id="category" class="form-control">
                    <option value="-1" selected>Categoria</option>
                    @foreach($list_categories  as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                    <option value="">Todos</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Buscar</button>
        </form>
    </div>
</div>
<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-items-center">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="sort" data-sort="created_at">Fecha</th>
                        <th scope="col" class="sort" data-sort="wallet_name">Cartera</th>
                        <th scope="col" class="sort" data-sort="amount">Valor</th>
                        <th scope="col">Detalle</th>
                        <th scope="col" class="sort" data-sort="category_name">Categoria</th>
                        <th scope="col" class="sort" data-sort="user_name">Agente</th>
                    </tr>
                </thead>
                <tbody class="list">
                @foreach($clients as $client)
                    <tr>
                        <td>{{$client->created_at}}</td>
                        <td>{{$client->wallet_name}}</td>
                        <td>{{$client->amount}}</td>
                        <td>{{$client->description}}</td>
                        <td>{{$client->category_name}}</td>
                        <td>{{$client->user_name}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <b>Total: </b><span class="text-success">{{$sum}}</span>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
@endsection