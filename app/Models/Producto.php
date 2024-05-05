<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Producto extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion', 'precio', 'imagen'];

    public function inventarios(): HasMany
    {
        return $this->hasMany(Inventario::class);
    }

    public function tallas()
    {
        return $this->belongsToMany(Talla::class);
    }

    public function colores()
    {
        return $this->belongsToMany(Color::class, 'producto_color');
    }

    public function estilos()
    {
        return $this->belongsToMany(Estilo::class, 'producto_estilo');
    }

    public function tipos_prenda()
    {
        return $this->belongsToMany(TipoPrenda::class, 'producto_tipo_prenda');
    }
}
