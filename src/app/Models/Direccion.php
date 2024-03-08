<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Direccion extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'recipient_name', 'recipient_phone', 'calle', 'ciudad', 'estado', 'codigo_postal', 'additional_info'];
    protected $table = 'direccion';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function usuarioDireccion(): HasOne
    {
        return $this->hasOne(UsuarioDireccion::class, 'direccion_id', 'id');
    }
}
