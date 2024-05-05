<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estilo extends Model
{
    use HasFactory;
    protected $table = 'estilos';
    protected $fillable = ['nombre'];

    public function productos()
    {
        return $this->belongsToMany(Producto::class);
    }
}
