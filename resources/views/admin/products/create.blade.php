{{-- resources/views/admin/products/create.blade.php --}}

@extends('layouts.adminapp')

@section('content')
<div class="container mt-5">
    <h2>Agregar nuevo producto</h2>

    {{-- Display validation errors if any --}}
    @if($errors->any())
    <div class="alert alert-danger mt-3" role="alert">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Form to create a new product --}}
    <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descipcion</label>
            <textarea class="form-control" id="descripcion" name="descripcion">{{ old('descripcion') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="text" class="form-control" id="precio" name="precio" value="{{ old('precio') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tallas</label><br>
            <div class="form-check form-check-inline form-check-lg">
                <input type="checkbox" id="ch" name="tallas[]" value="1" class="form-check-input">
                <label for="ch" class="form-check-label"> CH</label>
            </div>
            <div class="form-check form-check-inline form-check-lg">
                <input type="checkbox" id="m" name="tallas[]" value="2" class="form-check-input">
                <label for="m" class="form-check-label"> M</label>
            </div>
            <div class="form-check form-check-inline form-check-lg">
                <input type="checkbox" id="g" name="tallas[]" value="3" class="form-check-input">
                <label for="g" class="form-check-label"> G</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-dark">Agregar producto</button>
    </form>
</div>
@endsection