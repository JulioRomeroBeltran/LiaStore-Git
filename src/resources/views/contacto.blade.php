@extends('layouts.app')

@section('content')

<div class="container mt-5">
  <h2 class="text-center mb-4">Contacto</h2>
  <div class="card p-4">
    @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('contact.send') }}" method="post">
      @csrf


      <div class="form-group row mb-3">
        <div class="col">
          <input type="text" class="form-control" id="Nombre" name="Nombre" placeholder="Nombre" required>
        </div>
        <div class="col">
          <input type="email" class="form-control" id="Correo" name="Correo" placeholder="Correo" required>
        </div>
      </div>

      <div class="form-group mb-3">
        <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Telefono" required>
      </div>

      <div class="form-group mb-3">
        <textarea class="form-control" id="descripcion" name="descripcion" rows="4" placeholder="Descripción..." required></textarea>
      </div>

      <button class="btn btn-dark btn-submit" type="submit">Enviar</button>
    </form>
  </div>
</div>

@endsection