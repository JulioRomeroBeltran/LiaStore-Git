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
}
