@extends('layouts.app')

@section('content')
<style>
    .co-page { min-height: calc(100vh - 60px); }

    /* ── Columns ───────────────────────────────────────── */
    .co-left  { padding: 48px 52px 80px; border-right: 1px solid #ebebeb; }
    .co-right { padding: 40px 44px; background: #f7f7f7; }
    .co-sticky { position: sticky; top: 80px; }

    /* ── Section headers ───────────────────────────────── */
    .co-section { margin-bottom: 36px; }
    .co-section-title {
        display: flex; align-items: center; gap: 10px;
        font-size: 0.78rem; font-weight: 700;
        letter-spacing: 0.1em; text-transform: uppercase;
        color: #111; margin-bottom: 20px;
    }
    .co-section-num {
        width: 22px; height: 22px; border-radius: 50%;
        background: #111; color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.7rem; font-weight: 700; flex-shrink: 0;
    }

    /* ── Inputs ────────────────────────────────────────── */
    .co-field { margin-bottom: 12px; }
    .co-label { display: block; font-size: 0.75rem; color: #888; margin-bottom: 4px; }
    .co-input {
        width: 100%; border: 1px solid #ddd; border-radius: 4px;
        padding: 10px 13px; font-size: 0.875rem;
        outline: none; transition: border-color 0.18s; background: #fff;
    }
    .co-input:focus { border-color: #111; }
    .co-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .co-row-3 { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 12px; }

    /* ── Saved address cards ───────────────────────────── */
    .co-addr-label { display: block; cursor: pointer; margin-bottom: 10px; }
    .co-addr-label input[type="radio"] { display: none; }
    .co-addr-card {
        border: 1.5px solid #ddd; border-radius: 6px;
        padding: 14px 16px; display: flex; align-items: flex-start;
        gap: 12px; transition: border-color 0.18s, background 0.18s;
    }
    .co-addr-label input:checked + .co-addr-card,
    .co-addr-card.active {
        border-color: #111; background: #fafafa;
    }
    .co-addr-radio {
        width: 18px; height: 18px; border-radius: 50%;
        border: 2px solid #ccc; flex-shrink: 0; margin-top: 2px;
        display: flex; align-items: center; justify-content: center;
        transition: border-color 0.18s;
    }
    .co-addr-label input:checked + .co-addr-card .co-addr-radio { border-color: #111; }
    .co-addr-radio::after {
        content: ''; width: 8px; height: 8px; border-radius: 50%;
        background: #111; display: none;
    }
    .co-addr-label input:checked + .co-addr-card .co-addr-radio::after { display: block; }
    .co-addr-text { font-size: 0.875rem; line-height: 1.5; color: #333; }
    .co-addr-name { font-weight: 600; margin-bottom: 2px; }
    .co-addr-badge {
        display: inline-block; font-size: 0.68rem; font-weight: 700;
        letter-spacing: 0.06em; background: #111; color: #fff;
        padding: 2px 7px; border-radius: 20px; margin-left: 6px;
        vertical-align: middle; text-transform: uppercase;
    }

    /* ── Shipping options ──────────────────────────────── */
    .co-ship-opt {
        border: 1.5px solid #ddd; border-radius: 6px;
        padding: 14px 16px; cursor: pointer; margin-bottom: 10px;
        display: flex; align-items: center; justify-content: space-between;
        transition: border-color 0.18s, background 0.18s;
    }
    .co-ship-opt.active { border-color: #111; background: #fafafa; }
    .co-ship-left { display: flex; align-items: center; gap: 12px; }
    .co-ship-dot {
        width: 18px; height: 18px; border-radius: 50%;
        border: 2px solid #ccc; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        transition: border-color 0.18s;
    }
    .co-ship-opt.active .co-ship-dot { border-color: #111; }
    .co-ship-dot::after {
        content: ''; width: 8px; height: 8px; border-radius: 50%;
        background: #111; display: none;
    }
    .co-ship-opt.active .co-ship-dot::after { display: block; }
    .co-ship-name { font-size: 0.875rem; font-weight: 500; }
    .co-ship-price { font-size: 0.875rem; color: #555; }

    /* ── Payment info ──────────────────────────────────── */
    .co-card-saved {
        border: 1.5px solid #ddd; border-radius: 6px;
        padding: 14px 16px; margin-bottom: 10px; font-size: 0.875rem;
    }
    .co-card-saved-num { font-weight: 600; margin-bottom: 2px; }

    /* ── Actions ───────────────────────────────────────── */
    .co-back {
        font-size: 0.82rem; color: #777; text-decoration: none;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .co-back:hover { color: #111; }
    .co-btn {
        background: #111; color: #fff; border: none;
        padding: 13px 28px; font-size: 0.875rem;
        letter-spacing: 0.04em; cursor: pointer;
        border-radius: 4px; transition: background 0.18s;
    }
    .co-btn:hover { background: #333; }
    .co-btn-full { width: 100%; padding: 15px; font-size: 0.9rem; border-radius: 4px; }

    /* ── Order summary ─────────────────────────────────── */
    .co-summary-title {
        font-size: 0.78rem; font-weight: 700;
        letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 20px;
    }
    .co-item { display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid #e8e8e8; }
    .co-item:last-of-type { border-bottom: none; }
    .co-item-img {
        width: 60px; height: 60px; object-fit: cover;
        border-radius: 4px; border: 1px solid #e0e0e0; flex-shrink: 0;
    }
    .co-item-info { flex: 1; min-width: 0; }
    .co-item-name { font-size: 0.875rem; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .co-item-sub  { font-size: 0.78rem; color: #888; }
    .co-item-price { font-size: 0.875rem; font-weight: 600; white-space: nowrap; }

    .co-totals { margin-top: 20px; }
    .co-total-row {
        display: flex; justify-content: space-between;
        font-size: 0.85rem; color: #666; padding: 5px 0;
    }
    .co-total-row.co-grand {
        font-weight: 700; font-size: 1rem; color: #111;
        border-top: 1px solid #ddd; padding-top: 14px; margin-top: 8px;
    }
    .co-hint { font-size: 0.75rem; color: #aaa; margin-top: 6px; }

    /* ── Mobile ────────────────────────────────────────── */
    @media (max-width: 767px) {
        .co-left  { padding: 28px 20px 60px; border-right: none; border-top: 1px solid #ebebeb; }
        .co-right { padding: 24px 20px; }
        .co-row-2, .co-row-3 { grid-template-columns: 1fr; }
        .co-sticky { position: static; }
    }
</style>

<div class="container-fluid px-0">
    <div class="row g-0 co-page">

        {{-- ══ LEFT: Forms ══════════════════════════════════════════════ --}}
        <div class="col-md-7 co-left">

            {{-- ── 1. Dirección de envío ────────────────────────────── --}}
            <div class="co-section">
                <div class="co-section-title">
                    <span class="co-section-num">1</span>
                    Dirección de envío
                </div>

                @if($direcciones && $direcciones->count() > 0)
                    @foreach($direcciones as $dir)
                    <label class="co-addr-label">
                        <input type="radio" name="dir_sel" value="{{ $dir->id }}"
                               {{ $loop->first ? 'checked' : '' }}
                               onchange="setDireccion({{ $dir->id }})">
                        <div class="co-addr-card">
                            <div class="co-addr-radio"></div>
                            <div class="co-addr-text">
                                <div class="co-addr-name">
                                    {{ $dir->recipient_name }}
                                    @if($dir->usuarioDireccion && $dir->usuarioDireccion->active)
                                        <span class="co-addr-badge">Principal</span>
                                    @endif
                                </div>
                                {{ $dir->calle }}, {{ $dir->ciudad }},
                                {{ $dir->estado }} {{ $dir->codigo_postal }}
                                @if($dir->recipient_phone)
                                    · {{ $dir->recipient_phone }}
                                @endif
                            </div>
                        </div>
                    </label>
                    @endforeach
                @else
                    <form method="post" action="{{ route('cart.storeAddress') }}">
                        @csrf
                        <div class="co-row-2">
                            <div class="co-field">
                                <label class="co-label">Nombre del destinatario</label>
                                <input class="co-input" type="text" name="recipient_name" required>
                            </div>
                            <div class="co-field">
                                <label class="co-label">Teléfono</label>
                                <input class="co-input" type="tel" name="recipient_phone" required>
                            </div>
                        </div>
                        <div class="co-field">
                            <label class="co-label">Calle</label>
                            <input class="co-input" type="text" name="street" required>
                        </div>
                        <div class="co-row-3">
                            <div class="co-field">
                                <label class="co-label">Ciudad</label>
                                <input class="co-input" type="text" name="city" required>
                            </div>
                            <div class="co-field">
                                <label class="co-label">Estado</label>
                                <input class="co-input" type="text" name="state" required>
                            </div>
                            <div class="co-field">
                                <label class="co-label">Código postal</label>
                                <input class="co-input" type="text" name="zip" required>
                            </div>
                        </div>
                        <div class="co-field">
                            <label class="co-label">Información adicional (opcional)</label>
                            <input class="co-input" type="text" name="additional_info">
                        </div>
                        <button type="submit" class="co-btn mt-2">Guardar dirección</button>
                    </form>
                @endif
            </div>

            {{-- ── 2. Tipo de envío ─────────────────────────────────── --}}
            <div class="co-section">
                <div class="co-section-title">
                    <span class="co-section-num">2</span>
                    Tipo de envío
                </div>

                @foreach($tiposEnvio as $tipo)
                <div class="co-ship-opt {{ $loop->first ? 'active' : '' }}"
                     onclick="selectShipping(this, {{ $tipo->id }}, {{ $tipo->costo }})">
                    <div class="co-ship-left">
                        <div class="co-ship-dot"></div>
                        <span class="co-ship-name">{{ $tipo->nombre }}</span>
                    </div>
                    <span class="co-ship-price">${{ number_format($tipo->costo, 2) }} MXN</span>
                </div>
                @endforeach
            </div>

            {{-- ── 3. Información de pago ───────────────────────────── --}}
            <div class="co-section">
                <div class="co-section-title">
                    <span class="co-section-num">3</span>
                    Información de pago
                </div>

                @if($informacionPago && $informacionPago->count() > 0)
                    @foreach($informacionPago as $pago)
                    <div class="co-card-saved">
                        <div class="co-card-saved-num">
                            •••• •••• •••• {{ substr($pago->numero_tarjeta, -4) }}
                            @if($pago->usuarioInformacionPago && $pago->usuarioInformacionPago->principal)
                                <span class="co-addr-badge">Principal</span>
                            @endif
                        </div>
                        <div style="font-size:0.8rem;color:#888;">{{ $pago->nombre_tarjeta }} · Vence {{ $pago->fecha_expiracion }}</div>
                    </div>
                    @endforeach
                @else
                    <form id="informacion-pago-form" method="post" action="{{ route('cart.storePaymentInfo') }}">
                        @csrf
                        <div class="co-field">
                            <label class="co-label">Número de tarjeta</label>
                            <input class="co-input" type="text" name="numero_tarjeta" placeholder="1234 5678 9012 3456" required>
                        </div>
                        <div class="co-field">
                            <label class="co-label">Nombre en la tarjeta</label>
                            <input class="co-input" type="text" name="nombre_tarjeta" required>
                        </div>
                        <div class="co-row-2">
                            <div class="co-field">
                                <label class="co-label">Fecha de expiración</label>
                                <input class="co-input" type="text" name="fecha_expiracion" placeholder="MM/AA" required>
                            </div>
                            <div class="co-field">
                                <label class="co-label">CVV</label>
                                <input class="co-input" type="text" name="codigo_seguridad" placeholder="•••" required>
                            </div>
                        </div>
                        <input type="hidden" name="principal" value="1">
                        <button type="submit" class="co-btn mt-2">Guardar tarjeta</button>
                    </form>
                @endif
            </div>

            <a href="{{ route('cart.showCart') }}" class="co-back">← Volver al carrito</a>
        </div>

        {{-- ══ RIGHT: Order summary ══════════════════════════════════════ --}}
        <div class="col-md-5 co-right">
            <div class="co-sticky">

                <div class="co-summary-title">Resumen del pedido</div>

                @if($cartItems && $cartItems->count() > 0)
                <form action="{{ route('procesar_pedido') }}" method="post">
                    @csrf

                    {{-- Product list --}}
                    @foreach($cartItems as $item)
                    <div class="co-item">
                        <img src="{{ asset('storage/' . $item->product->imagen) }}"
                             alt="{{ $item->product->nombre }}" class="co-item-img">
                        <div class="co-item-info">
                            <div class="co-item-name">{{ $item->product->nombre }}</div>
                            <div class="co-item-sub">Cantidad: {{ $item->quantity }}</div>
                        </div>
                        <div class="co-item-price">${{ number_format($item->product->precio * $item->quantity, 2) }}</div>

                        <input type="hidden" name="productos[{{ $item->product->id }}][id]"       value="{{ $item->product->id }}">
                        <input type="hidden" name="productos[{{ $item->product->id }}][nombre]"   value="{{ $item->product->nombre }}">
                        <input type="hidden" name="productos[{{ $item->product->id }}][precio]"   value="{{ $item->product->precio }}">
                        <input type="hidden" name="productos[{{ $item->product->id }}][cantidad]" value="{{ $item->quantity }}">
                    </div>
                    @endforeach

                    {{-- Hidden fields --}}
                    <input type="hidden" name="direccion_id"            id="direccion_id"            value="{{ $direcciones->first()?->id ?? '' }}">
                    <input type="hidden" name="tipo_envio_seleccionado" id="tipo_envio_seleccionado" value="{{ $tiposEnvio->first()?->id ?? '' }}">
                    <input type="hidden" name="costo_envio_seleccionado" id="costo_envio_seleccionado" value="{{ $tiposEnvio->first()?->costo ?? 0 }}">

                    {{-- Totals --}}
                    <div class="co-totals">
                        <div class="co-total-row">
                            <span>Subtotal</span>
                            <span>${{ number_format($totalProductos, 2) }}</span>
                        </div>
                        <div class="co-total-row">
                            <span>Envío</span>
                            <span id="costoEnvioDisplay">${{ number_format($tiposEnvio->first()?->costo ?? 0, 2) }}</span>
                        </div>
                        <div class="co-total-row co-grand">
                            <span>Total</span>
                            <span id="totalDisplay">${{ number_format($totalProductos + ($tiposEnvio->first()?->costo ?? 0), 2) }}</span>
                        </div>
                    </div>

                    <button type="submit" class="co-btn co-btn-full mt-4">Confirmar pedido →</button>
                    <p class="co-hint text-center">Al confirmar, aceptas nuestros términos de compra.</p>
                </form>

                @else
                    <p style="font-size:0.9rem;color:#888;">No hay productos en el carrito.</p>
                @endif

            </div>
        </div>

    </div>
</div>

<script>
    var subtotalVal = {{ $totalProductos }};

    function selectShipping(el, id, cost) {
        document.querySelectorAll('.co-ship-opt').forEach(o => o.classList.remove('active'));
        el.classList.add('active');
        document.getElementById('tipo_envio_seleccionado').value  = id;
        document.getElementById('costo_envio_seleccionado').value = cost;
        document.getElementById('costoEnvioDisplay').textContent  = '$' + parseFloat(cost).toFixed(2);
        document.getElementById('totalDisplay').textContent       = '$' + (subtotalVal + parseFloat(cost)).toFixed(2);
    }

    function setDireccion(id) {
        document.getElementById('direccion_id').value = id;
    }
</script>

@endsection
