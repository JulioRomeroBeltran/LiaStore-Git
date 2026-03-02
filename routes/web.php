<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Providers\RouteServiceProvider; // Add this line to import RouteServiceProvider

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/iniciarsesion', function () {
    return view('iniciosesion');
});

Route::get('/gestionarperfil', function () {
    return view('gestperfil');
});

Route::get('/', function () {
    $productos  = \App\Models\Producto::inRandomOrder()->take(8)->get();
    $destacado  = \App\Models\Producto::whereNotNull('imagen')->latest()->first();
    $categorias = \App\Models\TipoPrenda::with(['productos' => function ($q) {
        $q->whereNotNull('imagen');
    }])->get()->filter(fn($c) => $c->productos->isNotEmpty())->values();
    return view('inicio', compact('productos', 'destacado', 'categorias'));
});

Route::get('/recuperar-contraseña', function () {
    return view('recuperarcontraseña');
});

Route::get('/passwproceso', function () {
    return view('PasswProceso');
});

Route::get('/passwconfirm', function () {
    return view('PasswConfirme');
});



Route::view('/contacto', 'contacto')->name('contacto');

use App\Http\Controllers\CartController;
use App\Http\Controllers\DireccionController;
use App\Http\Controllers\InformacionPagoController;
use App\Http\Controllers\PedidoController;



Route::get('/catalogo', [ProductController::class, 'catalogo'])->name('product.catalogo');
Route::get('/product/{productId}', [ProductController::class, 'show'])->name('product.show');
Route::get('/user/personal-info', [ProfileController::class, 'showPersonalInfo'])->name('user.personalInfo');
Route::get('/user/agregar-direccion', [ProfileController::class, 'showAgregarDireccionForm'])->name('agregar-direccion');


Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'showCart'])->name('cart.showCart');
    Route::post('/product/{productId}/add-to-cart', [CartController::class, 'addToCart'])->name('cart.addToCart');
    Route::delete('/remove/{productId}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::match(['post', 'patch'], '/updateQuantity/{productId}', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
});

Route::get('/infocliente', function () {
    return view('infocliente');
});

Route::get('/carritocompras', function () {
    return view('carritocompra');
});

Route::get('/register', function () {
    return view('register');
});


Route::get('/metodoenvios', function () {
    return view('metodoenvios');
});

Route::get('/inicio', function () {
    return view('inicio');
})->middleware(['auth', 'verified'])->name('inicio');

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('edit-profile');
    Route::patch('/update-profile', [ProfileController::class, 'update'])->name('update-profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/user/updatePersonalInfo', [ProfileController::class, 'updatePersonalInfo'])->name('user.updatePersonalInfo');
    Route::post('/direcciones', [DireccionController::class, 'store'])->name('direcciones.store');
    Route::get('/direcciones/{id}/editar', [DireccionController::class, 'editar'])->name('direcciones.editar');
    Route::put('/direcciones/{id}/actualizar', [DireccionController::class, 'actualizar'])->name('direcciones.actualizar');
    Route::delete('/direcciones/{id}', [DireccionController::class, 'destroy'])->name('direcciones.destroy');
    Route::post('/direcciones/marcarPrincipal/{id}', [DireccionController::class, 'marcarPrincipal'])->name('direcciones.marcarPrincipal');
    Route::get('/mostrar-direcciones', [DireccionController::class, 'mostrarDirecciones'])->name('mostrar-direcciones');
    Route::get('/mostrar-informacion-pago', [InformacionPagoController::class, 'mostrarInformacionPago'])->name('mostrar-informacion-pago');
    Route::post('/guardar-informacion-pago', [InformacionPagoController::class, 'store'])->name('informacion-pago.store');
    Route::get('/editar-informacion-pago/{id}', [InformacionPagoController::class, 'editar'])->name('informacion-pago.editar');
    Route::put('/actualizar-informacion-pago/{id}', [InformacionPagoController::class, 'actualizar'])->name('informacion-pago.actualizar');
    Route::delete('/eliminar-informacion-pago/{id}', [InformacionPagoController::class, 'destroy'])->name('informacion-pago.destroy');
    Route::post('/marcar-principal-informacion-pago/{id}', [InformacionPagoController::class, 'marcarPrincipal'])->name('informacion-pago.marcarPrincipal');
    Route::match(['get', 'post'], '/realizar-compra', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/cart/store/address', [CartController::class, 'storeAddress'])->name('cart.storeAddress');
    Route::post('/cart/store/payment-info', [CartController::class, 'storePaymentInfo'])->name('cart.storePaymentInfo');
    Route::get('/pedidos/confirmacion/{id}', [PedidoController::class, 'vistaConfirmacion'])->name('pedidos.confirmacion');
    Route::get('/pedidos/historial', [PedidoController::class, 'historialPedidos'])->name('pedidos.historial');
    Route::post('/procesar-pedido', [PedidoController::class, 'procesarPedido'])->name('procesar_pedido');

});


require __DIR__ . '/auth.php';

Route::get('/logout', [LoginController::class, 'logout']);


Route::get(RouteServiceProvider::LOGIN, [LoginController::class, 'showLoginForm'])->name('login');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/reset', function () {
    return view('auth.reset-password');
})->name('password.reset');

use App\Http\Controllers\HomeController;

Route::post('/contact', [HomeController::class, 'sendContactForm'])->name('contact.send');



use App\Http\Controllers\RecoveryController;
use App\Http\Controllers\Auth\PasswordController;

Route::get('/recover', [RecoveryController::class, 'showEmailInputForm'])->name('password.request');
Route::post('/check-email', [RecoveryController::class, 'checkEmail']);
Route::get('/email-sent', [RecoveryController::class, 'showEmailSentView'])->name('password.sent');

Route::get('/reset-password/{token}', [RecoveryController::class, 'showResetPasswordConfirmView'])->name('password.reset');
Route::get('/reset-password-confirm/{token}', [RecoveryController::class, 'showResetPasswordConfirmView'])->name('password.confirm');

Route::post('/password-change', [PasswordController::class, 'change'])->name('password.change');

use App\Http\Controllers\AdminController;

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/products', [AdminController::class, 'showProducts'])->name('admin.products.index');
    Route::get('/admin/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/admin/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/admin/products/edit/{id}', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::put('/admin/products/update/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::put('admin/products/{id}/update-inventory', [AdminController::class, 'updateInventory'])->name('admin.products.update-inventory');
    Route::delete('/admin/products/{id}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');


    Route::get('products', 'AdminController@products')->name('admin.products');
    Route::get('orders',[AdminController::class, 'mostrarOrdenes'])->name('admin.orders');
    Route::get('statistics', 'AdminController@statistics')->name('admin.statistics');
    Route::get('/asignar-admin', [AdminController::class, 'mostrarFormularioAsignarAdmin'])->name('mostrar-formulario-asignar-admin');
    Route::post('/asignar-admin', [AdminController::class, 'asignarAdmin'])->name('asignar-admin');


});
