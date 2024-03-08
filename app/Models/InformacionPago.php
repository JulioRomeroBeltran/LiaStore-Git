<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InformacionPago extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'numero_tarjeta', 'nombre_tarjeta', 'fecha_expiracion', 'codigo_seguridad'];
    protected $table = 'informacion_pago';

    protected $casts = [
        'principal' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

   public function usuarioInformacionPago()
    {
        return $this->hasOne(UsuarioInformacionPago::class, 'informacion_pago_id', 'id');
    }
}
