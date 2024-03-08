<?php

namespace App\Http\Controllers;

use App\Models\HistorialPedido;
use App\Models\Producto;
use App\Models\Inventario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;



class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['showProducts', 'createProduct']); // Adjust as needed
    }

    public function index()
    {
        $productos = Producto::all();
        return view('admin.products.index', compact('productos'));
    }

    public function mostrarOrdenes()
    {
        $todosLosPedidos = HistorialPedido::with('cliente')->get();

        return view('admin.historial-todos-pedidos', compact('todosLosPedidos'));
    }


    public function showProducts()
    {
        $productos = Producto::all();
        return view('admin.products.index', compact('productos'));
    }

    public function createProduct()
    {
        return view('admin.products.create');
    }


    public function storeProduct(Request $request)
    {

        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tallas' => 'nullable|array',
            'tallas.*' => ['required', Rule::in([1, 2, 3])],
        ]);


        $imagenPath = $request->file('imagen')->store('public');
        $imagenPath = str_replace('public/', '', $imagenPath);

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'imagen' => $imagenPath,
        ]);

        if ($request->has('tallas')) {
            $producto->tallas()->sync($request->tallas);
        }

        Inventario::create([
            'producto_id' => $producto->id,
            'cantidad_disponible' => 0, 
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Producto creado exitosamente.');
    }


    public function destroyProduct($id)
    {
        $product = Producto::find($id);

        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Producto no encontrado.');
        }

        $product->inventarios()->delete();

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado exitosamente.');
    }

    public function editProduct($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return redirect()->route('admin.products.index')->with('error', 'Producto no encontrado.');
        }

        return view('admin.products.product-edit', compact('producto'));
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tallas' => 'nullable|array',
            'tallas.*' => ['required', Rule::exists('tallas', 'id')], 
        ]);

        $producto = Producto::find($id);

        if (!$producto) {
            return redirect()->route('admin.products.index')->with('error', 'Producto no encontrado.');
        }

        if ($request->hasFile('imagen')) {
        }

        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
        ]);

        if ($request->has('tallas')) {
            $producto->tallas()->sync($request->tallas);
        }

        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function updateInventory(Request $request, $id)
    {
        $request->validate([
            'cantidad_disponible' => ['required', 'integer', 'min:0'],
        ]);

        $producto = Producto::find($id);

        if (!$producto) {
            return redirect()->route('admin.products.index')->with('error', 'Producto no encontrado.');
        }

        $inventario = Inventario::firstOrNew(['producto_id' => $producto->id]);

        $inventario->cantidad_disponible = $request->cantidad_disponible;
        $inventario->save();

        return redirect()->route('admin.products.index')->with('success', 'Cantidad disponible actualizada.');
    }
    public function catalogo(Request $request)
    {
        $query = Producto::query();

        if ($request->has('availability')) {
            if ($request->input('availability') === 'available') {
                $query->whereHas('inventario', function ($query) {
                    $query->where('cantidad_disponible', '>', 0);
                });
            } elseif ($request->input('availability') === 'unavailable') {
                $query->whereHas('inventario', function ($query) {
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

        $filteredProducts = $query->get();

        return view('catalogo', compact('filteredProducts'));
    }

    public function asignarAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->role = 'admin';
        $user->save();

        return redirect()->back()->with('success', 'Rol de administrador asignado exitosamente.');
    }
    public function mostrarFormularioAsignarAdmin()
    {
        return view('admin.asignar-admin');
    }
}
