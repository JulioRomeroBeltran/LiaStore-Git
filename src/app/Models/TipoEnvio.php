<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEnvio extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'costo'];

    protected $table = 'tipos_envio';
}
