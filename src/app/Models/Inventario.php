<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;
    protected $table = 'inventario';
    protected $fillable = ['producto_id', 'cantidad_disponible'];
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
