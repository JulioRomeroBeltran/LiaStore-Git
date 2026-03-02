@extends('layouts.app')
@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset('css/inicio.css') }}">

{{-- ══ HERO ══════════════════════════════════════════════════════════ --}}
<section class="ls-hero">
    <span class="ls-hero__tag">Lia Store · Colección 2025</span>
    <div class="ls-hero__body">
        <h1 class="ls-hero__title">Moda<br>Exclusiva<br>Para Ti</h1>
        <div class="ls-hero__aside">
            <p class="ls-hero__sub">Cada prenda es única —<br>cuando se agota, no regresa.</p>
            <a href="/catalogo" class="ls-hero__btn">Ver Colección →</a>
        </div>
    </div>
</section>

{{-- ══ CATEGORÍAS ══════════════════════════════════════════════════════ --}}
@if($categorias->isNotEmpty())
<section class="ls-cats">
    @foreach($categorias->take(3) as $cat)
    @php $img = $cat->productos->first()->imagen ?? null; @endphp
    <a href="{{ route('product.catalogo', ['type' => $cat->id]) }}" class="ls-cat"
       style="{{ $img ? 'background-image:url('.asset('storage/'.$img).')' : '' }}">
        <div class="ls-cat__overlay">
            <span class="ls-cat__name">{{ $cat->nombre_tipo }}</span>
            <span class="ls-cat__cta">Explorar →</span>
        </div>
    </a>
    @endforeach
</section>
@endif

{{-- ══ NOVEDAD DESTACADA ════════════════════════════════════════════════ --}}
@if($destacado && $destacado->imagen)
<section class="ls-featured" style="background-image: url('{{ asset('storage/' . $destacado->imagen) }}')">
    <div class="ls-featured__overlay">
        <div class="ls-featured__content">
            <span class="ls-featured__tag">Nueva llegada</span>
            <h2 class="ls-featured__title">{{ $destacado->nombre }}</h2>
            <span class="ls-featured__price">${{ number_format($destacado->precio, 2) }} MXN</span>
            <a href="{{ route('product.show', $destacado->id) }}" class="ls-featured__btn">Ver producto →</a>
        </div>
    </div>
</section>
@endif

{{-- ══ COLECCIÓN ═══════════════════════════════════════════════════════ --}}
<section class="ls-products">
    <div class="ls-products__head">
        <h2 class="ls-products__title">Colección</h2>
        <a href="/catalogo" class="ls-products__link">Ver todo →</a>
    </div>
    <div class="row g-3 g-md-4">
        @forelse($productos as $producto)
        <div class="col-6 col-md-3">
            <a href="{{ route('product.show', $producto->id) }}" class="ls-card-link">
                <div class="ls-card">
                    <div class="ls-card__img">
                        @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
                        @endif
                        <div class="ls-card__overlay"><span>Ver producto</span></div>
                    </div>
                    <div class="ls-card__info">
                        <span class="ls-card__name">{{ $producto->nombre }}</span>
                        <span class="ls-card__price">${{ number_format($producto->precio, 2) }}</span>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <p class="text-center text-muted col-12">No hay productos disponibles.</p>
        @endforelse
    </div>
</section>

{{-- ══ HISTORIA DE LA MARCA ════════════════════════════════════════════ --}}
<section class="ls-brand">
    <div class="ls-brand__inner">
        <span class="ls-brand__tag">Nuestra historia</span>
        <h2 class="ls-brand__title">Moda que te<br>hace sentir única</h2>
        <p class="ls-brand__text">
            Lia Store nació en Guasave, Sinaloa, con una idea simple: que cada mujer
            merezca prendas cuidadosamente seleccionadas, de alta calidad y difíciles
            de encontrar en otro lugar. No seguimos tendencias masivas —
            elegimos piezas que duran y destacan.
        </p>
        <a href="{{ route('contacto') }}" class="ls-brand__link">Conocer más →</a>
    </div>
</section>

{{-- ══ TIENDA FÍSICA ═══════════════════════════════════════════════════ --}}
<section class="ls-store">
    <img src="{{ asset('Tiendafisica.png') }}" alt="Tienda física Lia Store" class="ls-store__bg">
    <div class="ls-store__overlay">
        <span class="ls-store__tag">Guasave, Sinaloa</span>
        <h2 class="ls-store__title">Visítanos en<br>Nuestra Tienda</h2>
        <p class="ls-store__sub">Conoce toda la colección en persona.</p>
        <a href="{{ route('contacto') }}" class="ls-store__btn">Contactar →</a>
    </div>
</section>

{{-- ══ NEWSLETTER ═══════════════════════════════════════════════════════ --}}
<section class="ls-newsletter">
    <span class="ls-newsletter__tag">Sé la primera en saberlo</span>
    <h2 class="ls-newsletter__title">Nuevas piezas, antes que nadie</h2>
    <p class="ls-newsletter__sub">Subscribete y recibe cada nueva llegada directamente en tu correo.</p>
    <form class="ls-newsletter__form" onsubmit="return false;">
        <input type="email" class="ls-newsletter__input" placeholder="tu@correo.com">
        <button type="submit" class="ls-newsletter__btn">Subscribirme</button>
    </form>
</section>

{{-- ══ FEATURES strip ════════════════════════════════════════════════════ --}}
<div class="ls-features">
    <div class="ls-features__item">
        <span class="ls-features__icon">✦</span>
        <span class="ls-features__title">Exclusividad</span>
    </div>
    <div class="ls-features__item">
        <span class="ls-features__icon">📍</span>
        <span class="ls-features__title">Guasave, Sinaloa</span>
    </div>
    <div class="ls-features__item">
        <span class="ls-features__icon">📦</span>
        <span class="ls-features__title">Envíos a México</span>
    </div>
</div>

{{-- ══ FOOTER ═══════════════════════════════════════════════════════════ --}}
<footer class="ls-footer">
    <div class="ls-footer__top">
        <div class="ls-footer__brand">
            <img src="{{ asset('logo.png') }}" alt="Lia Store" class="ls-footer__logo">
            <p class="ls-footer__tagline">Moda exclusiva para mujeres.<br>Guasave, Sinaloa, México.</p>
        </div>
        <nav class="ls-footer__nav">
            <div class="ls-footer__col">
                <h4 class="ls-footer__col-title">Tienda</h4>
                <a href="/" class="ls-footer__link">Inicio</a>
                <a href="{{ route('product.catalogo') }}" class="ls-footer__link">Catálogo</a>
                <a href="{{ route('cart.showCart') }}" class="ls-footer__link">Carrito</a>
            </div>
            <div class="ls-footer__col">
                <h4 class="ls-footer__col-title">Cuenta</h4>
                @auth
                <a href="{{ route('edit-profile') }}" class="ls-footer__link">Mi perfil</a>
                <a href="{{ route('pedidos.historial') }}" class="ls-footer__link">Mis pedidos</a>
                @else
                <a href="{{ route('login') }}" class="ls-footer__link">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="ls-footer__link">Registrarse</a>
                @endauth
            </div>
            <div class="ls-footer__col">
                <h4 class="ls-footer__col-title">Contacto</h4>
                <a href="{{ route('contacto') }}" class="ls-footer__link">Formulario de contacto</a>
                <span class="ls-footer__link ls-footer__link--text">Guasave, Sinaloa, MX</span>
            </div>
        </nav>
    </div>
    <div class="ls-footer__bottom">
        <span>© {{ date('Y') }} Lia Store. Todos los derechos reservados.</span>
    </div>
</footer>

@endsection
