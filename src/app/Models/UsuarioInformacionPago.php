<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class UsuarioInformacionPago extends Model
{
    use HasFactory;
    protected $table = 'usuario_informacion_pago';
    protected $fillable = ['user_id', 'informacion_pago_id', 'principal'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function informacionPago(): BelongsTo
    {
        return $this->belongsTo(InformacionPago::class);
    }
}
