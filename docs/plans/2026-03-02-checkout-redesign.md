# Checkout Redesign — LiaStore

**Date:** 2026-03-02

## Problem

- `realizar-compra.blade.php` has no real design — bare Bootstrap, broken PayPal/Apple Pay images, forms stacked without visual hierarchy.
- Toast notification doesn't appear after adding a product to the cart.

## Approved Design

### Layout

Two-column Shopify-style checkout. No app navbar — standalone header with centered logo. White left panel, `#f9f9f9` right panel.

- Left column (col-md-7): numbered form sections
- Right column (col-md-5): sticky order summary

### Left Column Sections

1. **Dirección de envío** — recipient name, phone, street, city, state, zip, additional info
2. **Tipo de envío** — radio-style buttons for each shipping option
3. **Información de pago** — show saved card if exists, otherwise show card form fields

Footer: "← Volver al carrito" + "Confirmar pedido →" button (full-width dark)

### Right Column (sticky)

- Product list: thumbnail + name + quantity + price per item
- Divider
- Subtotal / Envío / Total rows
- Updates dynamically when shipping type is selected

### Style

- Section headers: numbered with dark circle badge
- Inputs: flat style, gray border, no Bootstrap `form-control` heavy styling
- Mobile: right panel (summary) stacks on top, form below
- No PayPal/Apple Pay buttons (images don't exist)

## Files to Change

1. `resources/views/realizar-compra.blade.php` — full rewrite
2. `resources/views/layouts/app.blade.php` — verify toast works (debug session flash)
