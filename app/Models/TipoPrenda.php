<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPrenda extends Model
{
    use HasFactory;
    protected $table = 'tipos_prenda';
    protected $fillable = ['nombre'];

    public function productos()
    {
        return $this->belongsToMany(Producto::class,'producto_tipo_prenda');
    }
}
