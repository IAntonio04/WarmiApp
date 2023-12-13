@extends('layouts.sessionApp')
@section('titulo', 'Gestión de Usuarios')

@section('contenido')
    <hr>
    <div class="d-md-flex justify-content-md-end">
        <form action="{{ route("gestionUsuarios") }}" method="GET" class="d-flex align-items-center">
            <input type="text" name="busqueda" class="form-control">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="mb-4">
        <div class="mb-4">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create">Registrar Usuario <i class="fas fa-plus-square"></i></button>
            <a class="btn btn-success" href="{{ route('gestionUsuarios') }}">Recargar <i class="fas fa-rotate-right"></i></a>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>USUARIO</th>
                <th>DNI</th>
                <th>CARGO</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->nombres }} {{ $usuario->apellidos }}</td>
                    <td>{{ $usuario->dni }}</td>
                    <td>{{ $usuario->cargo }}</td>
                    <td class="">
                        <button class="btn btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#edit{{ $usuario->id }}">Editar <i class="fas fa-edit"></i></button>
                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#delete{{ $usuario->id }}">Eliminar <i class="fas fa-times-circle"></i></button>
                    </td>
                </tr>
                @include('user.editarUsuario')
                @include('user.eliminarUsuario')
            @endforeach
        </tbody>
    </table>
    <tfoot>
        <tr>
            <td class="row" colspan="1"> {{ $usuarios->links() }} </td>
        </tr>
    </tfoot>
    </div>
</div>
@include('user.registrarUsuario')
@endsection
