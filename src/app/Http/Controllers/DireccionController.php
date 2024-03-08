<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\UsuarioDireccion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DireccionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('profile.partials.agregar-direccion-form', ['user' => $user]);
    }
    public function mostrarDirecciones()
    {
        $user = auth()->user();
        $direcciones = $user->direcciones;
    
        $direcciones = $direcciones->sortByDesc('usuarioDireccion.active');
    
        return view('profile.partials.agregar-direccion-form', ['user' => $user, 'direcciones' => $direcciones]);
    }

    public function store(Request $request)
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

        return redirect()->route('mostrar-direcciones')->with('success', 'Dirección agregada correctamente.');
    }

    public function editar($id)
    {
        $direccion = Direccion::findOrFail($id);

        return view('profile.partials.editar-direccion', compact('direccion'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'recipient_name' => 'required|string',
            'recipient_phone' => 'required|string',
            'street' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required|string',
            'additional_info' => 'nullable|string',
        ]);

        try {
            $direccion = Direccion::findOrFail($id);
            $direccion->update([
                'recipient_name' => $request->input('recipient_name'),
                'recipient_phone' => $request->input('recipient_phone'),
                'calle' => $request->input('street'),
                'ciudad' => $request->input('city'),
                'estado' => $request->input('state'),
                'codigo_postal' => $request->input('zip'),
                'additional_info' => $request->input('additional_info'),
            ]);

            return redirect()->route('mostrar-direcciones')->with('success', 'Dirección actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la dirección: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $direccion = Direccion::findOrFail($id);
    
            $usuarioDireccion = $direccion->usuarioDireccion;
    
            if ($usuarioDireccion) {
                $usuarioDireccion->delete();
            }
    
            $direccion->delete();
    
            $user = auth()->user();
            $direcciones = $user->direcciones;
    
            return redirect()->route('direcciones.index', ['direcciones' => $direcciones])->with('success', 'Dirección eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar la dirección: ' . $e->getMessage());
        }
    }

    public function marcarPrincipal($id)
    {
        $direccion = Direccion::findOrFail($id);

        UsuarioDireccion::where('user_id', auth()->id())->update(['active' => false]);

        $direccion->usuarioDireccion()->update(['active' => true]);

        return redirect()->back()->with('success', 'Dirección marcada como principal correctamente.');
    }
}
