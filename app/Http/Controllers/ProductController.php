<?php

// ProductController.php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Estilo;
use App\Models\Color;
use App\Models\TipoPrenda;

class ProductController extends Controller
{

    public function catalogo(Request $request)
    {
        $colores = Color::all();
        $estilos = Estilo::all();
        $tipos_prenda = TipoPrenda::all();

        $query = Producto::query();

        if ($request->has('sorting')) {
            $sorting = $request->input('sorting');
            switch ($sorting) {
                case 'price_asc':
                    $query->orderBy('precio', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('precio', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('nombre', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('nombre', 'desc');
                    break;

            }
        } else {
            $query->orderBy('nombre', 'asc');
        }

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

        if ($request->filled('color')) {
            $query->whereHas('colores', function ($query) use ($request) {
                $query->where('colores.id', $request->color);
            });
        }
        
        if ($request->filled('style')) {
            $query->whereHas('estilos', function ($query) use ($request) {
                $query->where('estilos.id', $request->style);
            });
        }
        
        if ($request->filled('type')) {
            $query->whereHas('tipos_prenda', function ($query) use ($request) {
                $query->where('tipos_prenda.id', $request->type);
            });
        }

        if ($request->has('search')) {
            $query->where('nombre', 'like', '%' . $request->input('search') . '%');
        }
        
        $hasFilters = $request->filled('availability') || $request->filled('color') || $request->filled('style') || $request->filled('type') || $request->has('sorting') || $request->has('search');

        $filteredProducts = $query->get();

        return view('productos.catalogo', compact('filteredProducts', 'colores', 'estilos', 'tipos_prenda', 'hasFilters'));

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
