@extends('layouts.panel')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{ asset('css/select2-bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
        <div class="col">
            <h3 class="mb-0">Registrar Paro</h3>
            <table style="font-size:10pt;width:100%">
                <tr>
                    <td>Inicio de Paro: </td>
                    <td>{{ $dateInit }}</td>
                    <td>Fin de Paro: </td>
                    <td>
                        <div class="clock">
                        {{ date('Y-m-d') }} <span id="hr">00</span><span>:</span><span id="min">00</span><span>:</span><span id="sec">00</span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col text-right">
            <a href="{{ url('stops') }}" class="btn btn-sm btn-default">
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
        <form action="{{ url('stops') }}" method="post">
            @csrf
            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="code">Codigo de Paro</label>
                <select name="code_id" id="code_id" class="form-control form-control-sm" required onchange="cargarFormulario()">
                    <option value="">Seleccionar Codigo de Paro</option>
                    @foreach($codes as $code)
                        <option value="{{ $code->id }}" @if(old('code') == $code->id) selected @endif>{{ $code->code." - ".$code->description }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="type_stop">Tipo de Paro</label>
                <input name="type_stop" id="type_stop" type="text" class="form-control form-control-sm" readonly>
            </div>
            </div>
            <div id="div_machine" class="form-group">
                <label for="machine_id">Maquina</label>
                <select name="machine_id" id="machine_id" class="form-control form-control-sm" data-live-search="true" onchange="cargarFormulario()">
                    <option value="">Seleccionar Maquina</option>
                    @foreach($machines as $machine)
                        <option value="{{ $machine->id }}" @if(old('machine_id') == $machine->id) selected @endif>{{ $machine->machine_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-row">
                <div id="div_product" class="form-group col-md-6" style="display:none;">
                    <label for="product_id">Producto</label>
                    <select name="product_id" id="product_id" class="form-control form-control-sm">
                        <option value="">Seleccionar Producto</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" @if(old('product_id') == $product->id) selected @endif>{{ $product->product_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="div_color" class="form-group col-md-6" style="display:none;">
                    <label for="color">Color</label>
                    <select name="color_id" id="color_id" class="form-control form-control-sm">
                        <option value="">Seleccionar Color</option>
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}" @if(old('color_id') == $color->id) selected @endif style="background-color:{{ $color->hex_code }}">{{ $color->name }}</option>
                        @endforeach
                    </select>
                    <!--<input type="color" class="form-control" name="color" id="color">-->
                </div>
            </div>
            <div class="form-row">
                <div id="div_conversion" class="form-group col-md-4" style="display:none;">
                    <label for="conversion_id">Conversi??n</label>
                    <select name="conversion_id" id="conversion_id" class="form-control form-control-sm" onchange="calcularConversion()">
                        <option value="">Seleccionar Conversi??n</option>
                        @foreach($conversions as $conversion)
                            <option value="{{ $conversion->id }}" @if(old('conversion_id') == $conversion->id) selected @endif>{{ $conversion->description }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="div_quantity" class="form-group col-md-4" style="display:none;">
                    <label for="quantity">Cantidad</label>
                    <input name="quantity" value="{{ old('quantity') }}" id="quantity" type="text" class="form-control form-control-sm" placeholder="Ingrese la Cantidad">
                </div>
                <div id="div_meters" class="form-group col-md-4" style="display:inline;">
                    <label for="meters">Metros Producidos</label>
                    <input name="meters" value="{{ old('meters') }}" id="meters" type="text" class="form-control form-control-sm" placeholder="Ingrese la cantidad de metros producidos">
                </div>
            </div>
            <div id="div_comment" class="form-group">
                <label for="comment">Observaciones</label>
                <input name="comment" value="{{ old('comment') }}" id="comment" class="form-control form-control-sm" placeholder="Ingresa un comentario">
            </div>
            <button class="btn btn-primary" type="submit">
                Guardar
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<!--<script src="{{ asset('/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>-->
<script src="{{ asset('/js/stops/create.js') }}"></script>
<script src="{{ asset('/js/stops/clock.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $('.colorpicker').colorpicker();
    $('#product_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Seleccionar Producto',
        allowClear: true,
        ajax: {
            url: '/ajax-autocomplete-search',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: $.map(data, function(item){
                        return {
                            text: item.product_name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
</script>
@endsection