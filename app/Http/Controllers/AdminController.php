<?php

namespace App\Http\Controllers;

use App\Models\HistorialPedido;
use App\Models\Producto;
use App\Models\Inventario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\Color;
use App\Models\Estilo;
use App\Models\TipoPrenda;
use App\Models\Talla;



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
        $colores = Color::all();
        $estilos = Estilo::all();
        $tipos_prenda = TipoPrenda::all();
        $tallas = Talla::all();

        return view('admin.products.create', compact('colores', 'estilos', 'tipos_prenda', 'tallas'));
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
            'colores' => 'nullable|array',
            'colores.*' => ['required', Rule::exists('colores', 'id')],
            'estilos' => 'nullable|array',
            'estilos.*' => ['required', Rule::exists('estilos', 'id')],
            'tipos_prenda' => 'nullable|array',
            'tipos_prenda.*' => ['required', Rule::exists('tipos_prenda', 'id')],
        ]);


        $imagenPath = $request->file('imagen')->store('public');
        $imagenPath = str_replace('public/', '', $imagenPath);

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'imagen' => $imagenPath,
        ]);

        $this->syncRelations($producto, $request);


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
        $colores = Color::all();
        $estilos = Estilo::all();
        $tipos_prenda = TipoPrenda::all();
        $tallas = Talla::all();

        if (!$producto) {
            return redirect()->route('admin.products.index')->with('error', 'Producto no encontrado.');
        }


        return view('admin.products.product-edit', compact('producto', 'colores', 'estilos', 'tipos_prenda', 'tallas'));
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tallas' => 'nullable|array',
            'tallas.*' => ['required', Rule::in([1, 2, 3])],
            'colores' => 'nullable|array',
            'colores.*' => ['required', Rule::exists('colores', 'id')],
            'estilos' => 'nullable|array',
            'estilos.*' => ['required', Rule::exists('estilos', 'id')],
            'tipos_prenda' => 'nullable|array',
            'tipos_prenda.*' => ['required', Rule::exists('tipos_prenda', 'id')],
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

        $this->syncRelations($producto, $request);


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

    private function syncRelations($producto, $request)
    {
        $relaciones = ['tallas', 'colores', 'estilos', 'tipos_prenda'];

        foreach ($relaciones as $relacion) {
            if ($request->has($relacion)) {
                $producto->{$relacion}()->sync($request->{$relacion});
            }
        }
    }
}
