<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistorialPedido;
use App\Models\TipoEnvio;
use Illuminate\Support\Facades\Auth;
use App\Models\Carrito;
use App\Models\Producto;



class PedidoController extends Controller
{
    public function procesarPedido(Request $request)
    {

        try {
            $request->validate([
                'productos' => 'required|array',
                'productos.*.id' => 'required|numeric',
                'productos.*.nombre' => 'required|string',
                'productos.*.precio' => 'required|numeric',
                'productos.*.cantidad' => 'required|numeric',
                'direccion_id' => 'required|exists:direccion,id,user_id,' . auth()->id(),
                'tipo_envio_seleccionado' => 'required',
                'costo_envio_seleccionado' => 'sometimes|required|numeric', 

            ]);

            $productos = $request->input('productos');

      
            $costoEnvio = $request->input('costo_envio_seleccionado');

            $nuevoPedido = HistorialPedido::create([
                'cliente_id' => auth()->id(),
                'detalles_pedido' => $this->obtenerDetallesPedido($productos),
                'direccion_id' => $request->input('direccion_id'),
                'total' => $this->calcularTotal($productos, $costoEnvio), 
                'tipo_envio_id' => $request->input('tipo_envio_seleccionado'),
            ]);

            Carrito::where('user_id', auth()->id())->delete();

            return redirect()->route('pedidos.confirmacion', ['id' => $nuevoPedido->id])
                ->with('success', '¡Tu pedido se ha realizado con éxito!');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Hubo un problema al procesar tu pedido. Por favor, inténtalo de nuevo.');
        }
    }
    
    private function obtenerDetallesPedido($productos)
{
    $detalles = [];

    foreach ($productos as $producto) {
        
        if (isset($producto['id'])) {
            $detalles[] = [
                'id' => $producto['id'], // Agrega la 'id' aquí
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'cantidad' => $producto['cantidad'],
            ];
        } else {
            
        }
    }

    return json_encode($detalles);
}

    public function vistaConfirmacion($id)
    {
        $pedido = HistorialPedido::findOrFail($id);
    
        $productos = json_decode($pedido->detalles_pedido, true);

        if (is_array($productos) && !empty($productos)) {
            foreach ($productos as &$producto) {
                if (isset($producto['id'])) {
                    $productoModel = Producto::find($producto['id']);
                    $producto['imagen'] = $productoModel->imagen ?? null;
                } else {
                    $producto['imagen'] = null;
                }
            }
        }
    
        $total = $pedido->total;
    
        return view('confirmacion_pedido', [
            'pedido' => $pedido,
            'productos' => $productos,
            'total' => $total,
        ]);
    }

    public function historialPedidos()
    {
        $historialPedidos = HistorialPedido::where('cliente_id', Auth::id())->latest()->get();

        return view('historial_pedidos', ['historialPedidos' => $historialPedidos]);
    }
    public function calcularTotal($productos, $costoEnvio)
    {

        $totalCalculado = 0;

        foreach ($productos as $producto) {

            $precio = $producto['precio'];
            $cantidad = $producto['cantidad'];


            $subtotal = $precio * $cantidad;

            $totalCalculado += $subtotal;
        }

        $totalCalculado += $costoEnvio;

        return $totalCalculado;
    }
}
