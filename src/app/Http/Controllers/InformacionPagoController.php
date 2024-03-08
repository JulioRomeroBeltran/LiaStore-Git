<?php

namespace App\Http\Controllers;

use App\Models\InformacionPago;
use App\Models\UsuarioInformacionPago;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InformacionPagoController extends Controller
{
    public function mostrarInformacionPago()
    {
        $user = auth()->user();
        $informacionPago = $user->informacionPagos->sortByDesc(function ($infoPago) {
            return $infoPago->usuarioInformacionPago ? $infoPago->usuarioInformacionPago->principal : false;
        });
    
        return view('profile.partials.agregar-informacion-pago', ['user' => $user, 'informacionPago' => $informacionPago]);
    }

    public function store(Request $request)
    {
        $request->merge(['principal' => $request->has('principal')]);

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

        return redirect()->route('mostrar-informacion-pago')->with('success', 'Información de pago agregada correctamente.');
    }

    public function editar($id)
    {
        $informacionPago = InformacionPago::findOrFail($id);

        return view('profile.partials.editar-informacion-pago', compact('informacionPago'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->merge(['principal' => $request->has('principal')]);

        $request->validate([
            'numero_tarjeta' => 'required|string',
            'nombre_tarjeta' => 'required|string',
            'fecha_expiracion' => 'required|string',
            'codigo_seguridad' => 'required|string',
            'principal' => 'nullable|boolean',
        ]);

        try {
            $informacionPago = InformacionPago::findOrFail($id);
            $informacionPago->update([
                'numero_tarjeta' => $request->input('numero_tarjeta'),
                'nombre_tarjeta' => $request->input('nombre_tarjeta'),
                'fecha_expiracion' => $request->input('fecha_expiracion'),
                'codigo_seguridad' => $request->input('codigo_seguridad'),
                'principal' => $validatedData['principal'] ?? false,
            ]);

            if ($request->input('principal') ?? false) {
                UsuarioInformacionPago::where('user_id', auth()->id())->update(['principal' => false]);

                $informacionPago->usuarioInformacionPago()->update(['principal' => true]);
            }

            return redirect()->route('mostrar-informacion-pago')->with('success', 'Información de pago actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la información de pago: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $informacionPago = InformacionPago::findOrFail($id);

            $usuarioInformacionPago = $informacionPago->usuarioInformacionPago;

            if ($usuarioInformacionPago) {
                $usuarioInformacionPago->delete();
            }

            $informacionPago->delete();

            $user = auth()->user();
            $informacionPago = $user->informacionPago;

            return redirect()->route('mostrar-informacion-pago', ['informacionPago' => $informacionPago])->with('success', 'Información de pago eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar la información de pago: ' . $e->getMessage());
        }
    }

    public function marcarPrincipal($id)
    {
        $informacionPago = InformacionPago::findOrFail($id);

        UsuarioInformacionPago::where('user_id', auth()->id())->where('id', '!=', $id)->update(['principal' => false]);

        $informacionPago->usuarioInformacionPago()->update(['principal' => true]);

        return redirect()->back()->with('success', 'Información de pago marcada como principal correctamente.');
    }
}
