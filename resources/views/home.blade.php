@extends('layouts.panel')

@section('admin-section')
<div class="card-columns">
    <!--<a href="{{url('admin/user/create')}}">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Crear Usuario</h5>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-orange text-white rounded-circle shadow">
                            <i class="ni ni-circle-08"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>-->
    <a href="{{url('admin/user')}}">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Listar Usuarios</h5>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-orange text-white rounded-circle shadow">
                            <i class="ni ni-bullet-list-67"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <!--<a href="{{url('admin/route/create')}}">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Crear Cartera</h5>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                            <i class="ni ni-briefcase-24"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>-->
    <a href="{{url('admin/route')}}">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Listar Carteras</h5>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                            <i class="ni ni-bullet-list-67"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <a href="{{url('admin/client')}}">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Listar Clientes</h5>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-blue text-white rounded-circle shadow">
                            <i class="ni ni-bullet-list-67"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <a href="{{url('admin/upload')}}">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Cargar Clientes</h5>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-blue text-white rounded-circle shadow">
                            <i class="ni ni-cloud-upload-96"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
@endsection

@section('supervisor-section')
<div class="card-columns">
    <a href="{{url('supervisor/agent')}}">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Asignar Base</h5>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-red text-white rounded-circle shadow">
                            <i class="fas fa-user-tag"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <a href="{{url('supervisor/close')}}">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Cierre Diario</h5>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-orange text-white rounded-circle shadow">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <a href="{{url('supervisor/client')}}">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Editar Cliente</h5>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                            <i class="fas fa-user-edit"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <a href="{{url('supervisor/tracker')}}">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Rastrear Agente</h5>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-blue text-white rounded-circle shadow">
                            <i class="fas fa-street-view"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <a href="{{url('supervisor/review/create')}}">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Revision Cartera</h5>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-default text-white rounded-circle shadow">
                            <i class="ni ni-briefcase-24"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <a href="{{url('supervisor/statistics')}}">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Estadistica</h5>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-blue text-white rounded-circle shadow">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <a href="{{url('supervisor/cash')}}">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Caja</h5>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-blue text-white rounded-circle shadow">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <a href="{{url('supervisor/bill/create')}}">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Gastos</h5>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-blue text-white rounded-circle shadow">
                            <i class="fas fa-money-bill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
@endsection

@section('agent-section')
<div class="card-columns">
    <a href="{{url('supervisor/agent')}}">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Iniciar Base</h5>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-red text-white rounded-circle shadow">
                            <i class="ni ni-button-play"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <a href="{{url('client')}}">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Mostrar Clientes</h5>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-orange text-white rounded-circle shadow">
                            <i class="fas fa-user-friends"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <a href="{{url('payment')}}">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Registrar Pago</h5>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                            <i class="fas fa-user-edit"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <a href="{{url('history')}}">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Historia Cierre</h5>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-blue text-white rounded-circle shadow">
                            <i class="fas fa-street-view"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <a href="{{url('transaction')}}">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Transacciones</h5>
                    </div>
                    <div class="col-auto">
                        <div class="icon icon-shape bg-default text-white rounded-circle shadow">
                            <i class="ni ni-briefcase-24"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
@endsection

@section('agent-resume')
    <div class="col-12 pb-2">
        <small>Los montos siguientes son el total del día actual</small>
    </div>
    <div class="col-md-4 col-sm-6">
        <a href="{{url('client/create')}}">
            <div class="widget stats-widget widget-resume">
                <div class="widget-body clearfix h-100 bg-white">
                    <div class="pull-left">
                        <h3 class="widget-title text-dark">DISPONIBLE (CAJA)</h3>
                        <h3 class="widget-title text-dark">
                            <b>{{$base_agent - $total_bill}}</b>
                            @if($total_summary>0)
                                <span>+</span>
                                <span class=""> {{$total_summary}}</span>
                                <span class="text-success">= {{($base_agent - $total_bill) + $total_summary}}</span>
                            @endif

                        </h3>
                    </div>
                    <span class="pull-right big-icon text-danger watermark"><i class="fa fa-arrow-down"></i></span>
                </div>
            </div><!-- .widget -->
        </a>

    </div>
    <div class="col-md-4 col-sm-6">
        <a href="{{url('transaction')}}">
            <div class="widget stats-widget widget-resume">
                <div class="widget-body h-100 clearfix bg-white">
                    <div class="pull-left">
                        <h3 class="widget-title text-dark">RECAUDADO</h3>
                        <h3 class="widget-title text-dark"><b>{{$total_summary}}</b></h3>
                    </div>
                    <span class="pull-right big-icon text-success watermark"><i class="fa fa-arrow-up"></i></span>
                </div>
            </div><!-- .widget -->
        </a>

    </div>
    <div class="col-md-4 col-sm-6">
        <a href="{{url('bill')}}">
            <div class="widget stats-widget widget-resume">
                <div class="widget-body h-100 clearfix bg-white">
                    <div class="pull-left">
                        <h3 class="widget-title text-dark">GASTOS</h3>
                        <h3 class="widget-title text-dark"><b>{{$total_bill}}</b></h3>
                    </div>
                    <span class="pull-right big-icon text-warning watermark"><i class="fa fa-arrow-right"></i></span>
                </div>
            </div><!-- .widget -->
        </a>

    </div>
    <div class="clearfix"></div>
    <div class="row m-0 d-block col-12 pb-4">
        <hr>
    </div>
@endsection

@section('content')
<!--<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">Gestion de Cobranza</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                Bienvenido al Sistema de Gestion de Cobranza
            </div>
        </div>
    </div>
</div>-->
<div class="container-fluid">
    @if(!$close_day)
        <section class="app-content">
            @if(in_array(Auth::user()->role,['agent']))
                <div class="row">
                    @yield('agent-resume')
                    @yield('agent-section')
                </div>

            @elseif(in_array(Auth::user()->role,['supervisor']))
                <div class="row">
                    @yield('supervisor-section')
                </div>
            @elseif(in_array(Auth::user()->role,['admin']))
                <div class="row">
                    <div class="col-12 row m-0 p-0">
                        @yield('admin-section')
                        <hr>
                    </div>

                    {{--                        <div class="col-12 row m-0 p-0">--}}
                    {{--                            <div class="d-block col-12">--}}
                    {{--                                <h6 class="font-weight-bold p-1">Agente</h6>--}}
                    {{--                            </div>--}}
                    {{--                            @yield('agent-section')--}}
                    {{--                            <hr>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="col-12 row m-0 p-0">--}}
                    {{--                            <div class="d-block col-12">--}}
                    {{--                                <h6 class="font-weight-bold p-1">Supervisor</h6>--}}
                    {{--                            </div>--}}
                    {{--                            @yield('supervisor-section')--}}
                    {{--                            <hr>--}}

                    {{--                        </div>--}}


                </div>
            @else
                <div>No tienes permisos</div>
            @endif
        </section>
    @else
        <section class="app-content">
            <div class="col-12 text-center p-4">
                <b>Cierre del día realizado. Vuelve mañana</b>
            </div>
        </section>
    @endif
</div>
@endsection
