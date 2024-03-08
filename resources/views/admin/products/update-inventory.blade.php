<!-- resources/views/admin/products/update-inventory.blade.php -->

@extends('layouts.adminapp')

@section('content')
    <div class="container mt-5">
        <h2>Update Inventory</h2>

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

        {{-- Form to update inventory --}}
        <form action="{{ route('admin.products.update-inventory', $producto->id) }}" method="post">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="cantidad_disponible" class="form-label">Cantidad Disponible</label>
                <input type="number" class="form-control" id="cantidad_disponible" name="cantidad_disponible" value="{{ $producto->inventario ? $producto->inventario->cantidad_disponible : 0 }}" required>
            </div>

            <button type="submit" class="btn btn-dark">Actualizar Cantidad Disponible</button>
        </form>
    </div>
@endsection
