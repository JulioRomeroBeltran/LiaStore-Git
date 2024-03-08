<?php

// ProductController.php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class ProductController extends Controller
{
    // ProductController.php

    public function catalogo(Request $request)
    {
        $query = Producto::query();

        // Filter by availability
        if ($request->has('availability')) {
            if ($request->input('availability') === 'available') {
                $query->whereHas('inventarios', function ($query) {
                    $query->where('cantidad_disponible', '>', 0);
                });
            } elseif ($request->input('availability') === 'unavailable') {
                $query->whereHas('inventarios', function ($query) {
                    $query->where('cantidad_disponible', '=', 0);
                });
            }
        }

        if ($request->has('price')) {
            if ($request->input('price') === 'low_to_high') {
                $query->orderBy('precio', 'asc');
            } elseif ($request->input('price') === 'high_to_low') {
                $query->orderBy('precio', 'desc');
            }
        }

        if ($request->has('alphabetical')) {
            if ($request->input('alphabetical') === 'a_to_z') {
                $query->orderBy('nombre', 'asc');
            } elseif ($request->input('alphabetical') === 'z_to_a') {
                $query->orderBy('nombre', 'desc');
            }
        }

        if ($request->has('search')) {
            $query->where('nombre', 'like', '%' . $request->input('search') . '%');
        }

        $filteredProducts = $query->get();

        return view('productos.catalogo', compact('filteredProducts'));
    }
    public function show($productId)
    {
        try {
            $producto = Producto::with('tallas')->findOrFail($productId);

            $otherProducts = Producto::where('id', '!=', $productId)->take(4)->get();

            return view('productos.producto', compact('producto', 'otherProducts'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('product.catalogo')->with('error', 'Producto no encontrado');
        }
    }
}
