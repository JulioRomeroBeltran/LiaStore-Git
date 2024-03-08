<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Carrito;
use App\Models\InformacionPago;
use App\Models\Direccion;
use App\Models\UsuarioInformacionPago;
use App\Models\UsuarioDireccion;
use Illuminate\Support\Facades\Log;
use App\Models\TipoEnvio;

class CartController extends Controller
{
    public function addToCart(Request $request, $productId)
    {
        $product = Producto::find($productId);

        if (!$product) {
            return redirect()->route('product.catalogo')->with('error', 'Producto no encontrado');
        }

        $cart = $request->session()->get('cart', []);


        $userId = auth()->id() ?? null;


        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'user_id' => $userId,
                'product_id' => $product->id,
                'product' => [
                    'name' => $product->nombre,
                    'price' => $product->precio,
                    'imagen' => $product->imagen,
                ],
                'quantity' => 1,
            ];
        }


        if ($cart[$productId]['quantity'] === 0) {
            unset($cart[$productId]);
        }

        $request->session()->put('cart', $cart);


        $this->saveCartToDatabase($cart);
        return redirect()->route('product.show', $productId)->with('success', 'Producto agregado al carrito');
    }

    private function saveCartToDatabase($cart)
    {
        foreach ($cart as $productId => $item) {

            if (isset($item['user_id']) && $item['user_id'] !== null) {
                Carrito::updateOrCreate(
                    [
                        'user_id' => $item['user_id'],
                        'product_id' => $productId,
                    ],
                    [
                        'quantity' => $item['quantity'],
                    ]

                );
            }
        }
    }

    public function showCart(Request $request)
    {
        $userId = auth()->id();


        $cartItems = Carrito::with('product')
            ->where('user_id', $userId)
            ->where('quantity', '>', 0)
            ->get();

        $cartProductIds = $cartItems->pluck('product_id')->all();

        $otherProducts = Producto::whereNotIn('id', $cartProductIds)
            ->inRandomOrder()
            ->take(4)
            ->get();


        $informacionPago = InformacionPago::where('user_id', $userId)->get();


        $direcciones = Direccion::where('user_id', $userId)->get();

        $total = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item->product->precio ?? 0) * ($item->quantity ?? 0);
        }, 0);


        $request->session()->put('cart', $this->getCartFromDatabase($userId));

        return view('productos.cart', compact('cartItems', 'total', 'otherProducts', 'informacionPago', 'direcciones'));
    }


    private function getCartFromDatabase($userId)
    {
        $cartItems = Carrito::where('user_id', $userId)
            ->where('quantity', '>', 0)
            ->get();

        $cart = [];
        foreach ($cartItems as $item) {
            $cart[$item->product_id] = [
                'user_id' => $item->user_id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
            ];
        }

        return $cart;
    }


    public function removeItem($productId)
    {

        $userId = auth()->id();


        $cartItem = Carrito::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {

            $removedProduct = $cartItem->product->name;


            $cartItem->delete();


            $cartItems = session('cart', []);
            unset($cartItems[$productId]);
            session(['cart' => $cartItems]);

            return redirect()->route('cart.showCart')->with('success', 'Producto eliminado del carrito: ' . $removedProduct);
        }

        return redirect()->route('cart.showCart')->with('error', 'Producto no encontrado en el carrito.');
    }


    public function updateQuantity(Request $request, $productId)
    {

        $userId = auth()->user()->id;


        $cartItem = Carrito::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {

            $newQuantity = (int)$request->input('quantity');

            Log::info("New Quantity: " . $newQuantity);


            $cartItem->update(['quantity' => $newQuantity]);


            if ($newQuantity === 0) {
                Log::info("Condition for deletion met: true");
                $cartItem->delete();
            } else {
                Log::info("Condition for deletion met: false");
            }
        }


        return redirect()->route('cart.showCart');
    }

    public function checkout(Request $request)
    {
        
        $tiposEnvio = TipoEnvio::all();

        $userId = auth()->id();
        $cartItems = Carrito::with('product')
            ->where('user_id', $userId)
            ->where('quantity', '>', 0)
            ->get();

        $cartProductIds = $cartItems->pluck('product_id')->all();

        $otherProducts = Producto::whereNotIn('id', $cartProductIds)
            ->inRandomOrder()
            ->take(4)
            ->get();

        $informacionPago = InformacionPago::where('user_id', $userId)->get();

        $direcciones = Direccion::where('user_id', $userId)->get();

        $totalProductos = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item->product->precio ?? 0) * ($item->quantity ?? 0);
        }, 0);
    
        $tipoEnvioSeleccionado = $request->input('tipo_envio_seleccionado', 0);
    
        $costoEnvio = TipoEnvio::find($tipoEnvioSeleccionado)->costo ?? 0;
    
        $total = $totalProductos + $costoEnvio;
    
        $request->session()->put('cart', $this->getCartFromDatabase($userId));
        
    
        return view('realizar-compra', compact('cartItems', 'total', 'otherProducts', 'informacionPago', 'direcciones', 'tiposEnvio', 'costoEnvio', 'totalProductos'));
    }

    public function storePaymentInfo(Request $request)
    {
        dd('Entré al método storePaymentInfo', $request->all());
        $request->merge(['principal' => $request->has('principal')]);

        try {
            $validatedData = $request->validate([
                'numero_tarjeta' => 'required|string',
                'nombre_tarjeta' => 'required|string',
                'fecha_expiracion' => 'required|string',
                'codigo_seguridad' => 'required|string',
                'principal' => 'nullable|boolean',
            ]);

            $informacionPago = InformacionPago::create([
                'user_id' => auth()->id(),
                'numero_tarjeta' => $validatedData['numero_tarjeta'],
                'nombre_tarjeta' => $validatedData['nombre_tarjeta'],
                'fecha_expiracion' => $validatedData['fecha_expiracion'],
                'codigo_seguridad' => $validatedData['codigo_seguridad'],
                'principal' => $validatedData['principal'] ?? false,
            ]);

            UsuarioInformacionPago::where('user_id', auth()->id())->update(['principal' => false]);


            if ($validatedData['principal'] ?? false) {
                $informacionPago->usuarioInformacionPago()->create([
                    'principal' => true,
                    'user_id' => auth()->id(),
                ]);
            }


            return redirect()->route('checkout')->with('success', 'Información de pago agregada correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('checkout')->with('error', 'Hubo un problema al agregar la información de pago: ' . $e->getMessage());
        }
    }

    public function storeAddress(Request $request)
    {

        $validatedData = $request->validate([
            'recipient_name' => 'required|string',
            'recipient_phone' => 'required|string',
            'street' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required|string',
            'additional_info' => 'nullable|string',
        ]);


        $direccion = Direccion::create([
            'user_id' => auth()->id(),
            'recipient_name' => $validatedData['recipient_name'],
            'recipient_phone' => $validatedData['recipient_phone'],
            'calle' => $validatedData['street'],
            'ciudad' => $validatedData['city'],
            'estado' => $validatedData['state'],
            'codigo_postal' => $validatedData['zip'],
            'additional_info' => $validatedData['additional_info'],
        ]);

        UsuarioDireccion::where('user_id', auth()->id())->update(['active' => false]);

        $direccion->usuarioDireccion()->create([
            'active' => true,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('checkout')->with('success', 'Dirección agregada correctamente.');
    }
}
