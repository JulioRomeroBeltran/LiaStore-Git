<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialPedido extends Model
{
    use HasFactory;
    protected $table = 'historial_pedidos'; 

    protected $fillable = [
        'cliente_id',
        'detalles_pedido',
        'direccion_id',
        'total',
        'tipo_envio_id',
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function tipoEnvio()
    {
        return $this->belongsTo(TipoEnvio::class, 'tipo_envio_id');
    }

    public function direccion()
    {
        return $this->belongsTo(Direccion::class, 'direccion_id');
    }

}
