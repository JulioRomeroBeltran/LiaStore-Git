@extends('layouts.adminapp')

@section('content')
<div class="container mt-5">
    <h2>Editar producto</h2>

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

    {{-- Form to edit the product --}}
    <form action="{{ route('admin.products.update', $producto->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripcion</label>
            <textarea class="form-control" id="descripcion" name="descripcion">{{ old('descripcion', $producto->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="text" class="form-control" id="precio" name="precio" value="{{ old('precio', $producto->precio) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tallas</label><br>
            @foreach($tallas as $talla)
            <div class="form-check form-check-inline form-check-lg">
                <input type="checkbox" id="{{ $talla->id }}" name="tallas[]" value="{{ $talla->id }}" class="form-check-input" {{ in_array($talla->id, $producto->tallas->pluck('id')->toArray()) ? 'checked' : '' }}>
                <label for="{{ $talla->id }}" class="form-check-label"> {{ $talla->nombre }}</label>
            </div>
            @endforeach
        </div>

        <div class="mb-3">
            <label for="colores" class="form-label">Colores</label>
            <select class="form-select" id="colores" name="colores[]" >
                @foreach($colores as $color)
                <option value="{{ $color->id }}" {{ $producto->colores->contains($color->id) ? 'selected' : '' }}>{{ $color->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="estilos" class="form-label">Estilos</label>
            <select class="form-select" id="estilos" name="estilos[]" >
                @foreach($estilos as $estilo)
                <option value="{{ $estilo->id }}" {{ $producto->estilos->contains($estilo->id) ? 'selected' : '' }}>{{ $estilo->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tipos_prenda" class="form-label">Tipo de prenda</label>
            <select class="form-select" id="tipos_prenda" name="tipos_prenda[]">
                @foreach($tipos_prenda as $tipo)
                <option value="{{ $tipo->id }}" {{ $producto->tipos_prenda->contains($tipo->id) ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
        </div>

        <button type="submit" class="btn btn-dark">Actualizar producto</button>
    </form>
</div>
@endsection
