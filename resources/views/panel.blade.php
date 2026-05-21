@extends('layouts.app')

@section('contenido')
<div class="text-center py-20">
    <h1 class="text-4xl font-bold text-[#0f172a]">
        ¡Bienvenido a VOLT, {{ auth()->user()->nombre }}!
    </h1>
    <p class="text-neutral-600 mt-4">
        Has iniciado sesión correctamente. Aquí construiremos tu panel principal.
    </p>
    <p class="text-sm text-neutral-400 mt-2">
        Tu rol: <strong>{{ auth()->user()->rol->nombre }}</strong>
    </p>
</div>
@endsection
