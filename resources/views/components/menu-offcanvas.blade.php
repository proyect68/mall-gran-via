<div class="offcanvas offcanvas-start menu-offcanvas" tabindex="-1" id="menuOffcanvas" aria-labelledby="menuOffcanvasLabel" style="background: #cac9ff !important;">
    <div class="offcanvas-header" style="background: #cac9ff; border-bottom: 1px solid rgba(55,53,175,0.2); color: #3735af;">
        <h5 class="offcanvas-title" id="menuOffcanvasLabel" style="color: #3735af; font-weight: 700;">Menú</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Cerrar" style="color: #3735af; opacity: 0.7;"></button>
    </div>
    <div class="offcanvas-body" style="background: #cac9ff; color: #3735af;">
        <ul class="list-unstyled">
            <li><a href="{{ route('dashboard') }}" class="d-block py-2" style="color: #3735af; text-decoration: none;"><img src="{{ asset('images/home_logo.png') }}" alt="" width="20" class="me-2" style="display: inline-block;">Volver al dashboard</a></li>
            <li><a href="/profile" class="d-block py-2" style="color: #3735af; text-decoration: none;"><img src="{{ asset('images/profile.png') }}" alt="" width="20" class="me-2" style="display: inline-block;">Mi perfil</a></li>
            <li><a href="{{ route('categories.index') }}" class="d-block py-2" style="color: #3735af; text-decoration: none;"><img src="{{ asset('images/categoria_logo.png') }}" alt="" width="20" class="me-2" style="display: inline-block;">Todas las categorías</a></li>
            <li><a href="{{ route('superofertas.index') }}" class="d-block py-2" style="color: #3735af; text-decoration: none;"><img src="{{ asset('images/superofertas_logo.png') }}" alt="" width="20" class="me-2" style="display: inline-block;">SuperOfertas</a></li>
            <li><a href="{{ route('stores.index') }}" class="d-block py-2" style="color: #3735af; text-decoration: none;"><img src="{{ asset('images/tienda_logo.png') }}" alt="" width="20" class="me-2" style="display: inline-block;">Ver tiendas</a></li>
            <li><a href="{{ route('search', ['q' => '']) }}" class="d-block py-2" style="color: #3735af; text-decoration: none;"><img src="{{ asset('images/busqueda_inteligente_logo.png') }}" alt="" width="20" class="me-2" style="display: inline-block;">Búsqueda inteligente</a></li>
            <li><a href="{{ route('wishlist.index') }}" class="d-block py-2" style="color: #3735af; text-decoration: none;"><img src="{{ asset('images/listadeseos_logo.png') }}" alt="" width="20" class="me-2" style="display: inline-block;">Lista de deseos</a></li>
            <li><a href="{{ route('history.index') }}" class="d-block py-2" style="color: #3735af; text-decoration: none;"><img src="{{ asset('images/historial_logo.png') }}" alt="" width="20" class="me-2" style="display: inline-block;">Historial</a></li>
            <li><a href="{{ route('notifications.index') }}" class="d-block py-2" style="color: #3735af; text-decoration: none;"><img src="{{ asset('images/notificacion_logo.png') }}" alt="" width="20" class="me-2" style="display: inline-block;">Notificaciones</a></li>
        </ul>
    </div>
</div>
