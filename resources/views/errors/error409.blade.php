@extends('layouts.sessionApp')
@section('titulo')
    Error 409
@endsection

@section('contenido')
<hr>
<div class="d-flex align-items-center justify-content-center" style="height: 100vh; background-color: #f8f9fa;">
    <div class="text-center">
        <h1 class="display-4 font-weight-bold text-danger">Error 409</h1>
        <p class="lead">Token CSRF inválido. Por favor, recarga la página e intenta nuevamente.</p>
    </div>
</div>

@endsection