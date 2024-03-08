<!-- resources/views/admin/products/index.blade.php -->

@extends('layouts.adminapp')

@section('content')
<div class="container mt-5">
    <h2>Lista de productos</h2>

    {{-- Display success message if any --}}
    @if(session('success'))
    <div class="alert alert-success mt-3" role="alert">
        {{ session('success') }}
    </div>
    @endif

    {{-- Table to display product list --}}
    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Cantidad Disponible</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productos as $producto)
            <tr>
                <td>{{ $producto->id }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->precio }}</td>
                <td>
                    @if($producto->imagen)
                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" style="max-width: 100px;">
                    @else
                    No Image
                    @endif
                </td>
                <td>
                    @if($producto->inventarios->isNotEmpty())
                    <form action="{{ route('admin.products.update-inventory', $producto->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="number" name="cantidad_disponible" value="{{ $producto->inventarios->first()->cantidad_disponible }}" required class="form-control-sm" style="width: 65px;">
                        <button type="submit" class="btn btn-dark btn-sm">Actualizar</button>
                    </form>
                    @else
                    Sin inventario
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.products.edit', $producto->id) }}" class="btn btn-primary btn-sm">Editar</a>
                    <form action="{{ route('admin.products.destroy', $producto->id) }}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estas seguro?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">No se encontraron productos.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Link to create a new product --}}
    <a href="{{ route('admin.products.create') }}" class="btn btn-dark">Agregar nuevo producto</a>
</div>
@endsection