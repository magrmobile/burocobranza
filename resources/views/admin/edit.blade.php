@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
        <div class="col">
            <h3 class="mb-0">Editar Usuario</h3>
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
        <form method="POST" action="{{url('admin/user')}}/{{$user->id}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" value="{{$user->username}}" class="form-control" id="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" value="{{$user->email}}"  class="form-control" id="email" required>
            </div>
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" name="name" value="{{$user->name}}"  class="form-control" id="name" required>
            </div>
            <div class="form-group">
                <label for="pwd">Contraseña:</label>
                <input type="password" name="pwd" class="form-control" id="pwd" required>
            </div>
            @if($user->level != 'admin')
            <div class="form-group">
                <label for="role">Rol:</label>
                <select name="role" class="form-control" id="role">
                    <option {{($user->role=='agent') ? 'selected':''}}  value="agent">Agente</option>
                    <option {{($user->role=='supervisor') ? 'selected':''}} value="supervisor">Supervisor</option>
                </select>
            </div>
            @endif

            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block btn-md">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection