<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsuarioDireccion extends Model
{
    use HasFactory;
    protected $table = 'usuario_direccion';
    protected $fillable = ['user_id', 'direccion_id', 'active'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function direccion(): BelongsTo
    {
        return $this->belongsTo(Direccion::class)->onDelete('cascade');
    }
}