@extends('layouts.panel')

@section('styles')
<meta name="csrf_token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">
@endsection

@section('content')
<div class="card shadow">
    <div class="card-header border-1">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Deudas Acumuladas</h3>
            </div>
        </div>
    </div>
    
    @if(session('notification'))
    <div class="card-body">
        <div class="alert alert-success" role="alert">
            {{ session('notification') }}
        </div>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-striped dt-responsive nowrap" id="supervisor_debt_table" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombres</th>
                        <th>Deuda</th>
                        <th>Barrio</th>
                        <th>Fecha</th>
                        <th>Valor Neto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($debt as $d)
                        <tr>
                            <td>{{$d->name}} {{$d->last_name}}</td>
                            <td>{{$d->debt_id}}</td>
                            <td>{{$d->province}}</td>
                            <td>{{$d->created_at}}</td>
                            <td>{{$d->amount_neto}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" style="text-align:right"><b>Total: </b><span class="text-danger">{{$total_debt}}</span></p></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
</br>
<div class="card shadow">
    <div class="card-header border-1">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Pagos Recibidos</h3>
            </div>
        </div>
    </div>
    
    @if(session('notification'))
    <div class="card-body">
        <div class="alert alert-success" role="alert">
            {{ session('notification') }}
        </div>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-striped dt-responsive nowrap" id="supervisor_pay_table" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombres</th>
                        <th>Deuda</th>
                        <th>Cuota</th>
                        <th>Valor</th>
                        <th>Hora</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($summary as $sum)
                    <tr>
                        <td>{{$sum->name}} {{$sum->last_name}}</td>
                        <td>{{$sum->id_debt}}</td>
                        <td>{{$sum->number_index}}</td>
                        <td>{{$sum->amount}}</td>
                        <td>{{($sum->created_at)}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" style="text-align:right"><b>Total: </b><span class="text-success">{{$total_debt}}</span></p></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript">
    $('#supervisor_debt_table').DataTable({
        "language": {
            "lengthMenu": "Mostrar " + 
                `<select class='custom-select custom-select-sm form-control form-control-sm'>
                    <option value='10'>10</option>
                    <option value='25'>25</option>
                    <option value='50'>50</option>
                    <option value='100'>100</option>
                    <option value='-1'>All</option>
                </select>` 
                + " items por página",
            "zeroRecords": "Nada encontrado - disculpa",
            "loadingRecords": "Cargando...",
            "info": "Mostrando la página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "loading": "Cargando...",
            "paginate": {
                "previous": "<",
                "next": ">"
            }
        }
    });

    $('#supervisor_pay_table').DataTable({
        "language": {
            "lengthMenu": "Mostrar " + 
                `<select class='custom-select custom-select-sm form-control form-control-sm'>
                    <option value='10'>10</option>
                    <option value='25'>25</option>
                    <option value='50'>50</option>
                    <option value='100'>100</option>
                    <option value='-1'>All</option>
                </select>` 
                + " items por página",
            "zeroRecords": "Nada encontrado - disculpa",
            "loadingRecords": "Cargando...",
            "info": "Mostrando la página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "loading": "Cargando...",
            "paginate": {
                "previous": "<",
                "next": ">"
            }
        }
    });
</script>
@endsection
