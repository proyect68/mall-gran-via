<div class="offcanvas offcanvas-end filter-offcanvas" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel" style="width: 340px !important;">
    <div class="offcanvas-header" style="background: #cac9ff; border-bottom: 1px solid rgba(55,53,175,0.2); color: #3735af;">
        <h5 class="offcanvas-title" id="filterOffcanvasLabel" style="color: #3735af; font-weight: 700;">Filtros de búsqueda</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Cerrar" style="color: #3735af; opacity: 0.7;"></button>
    </div>
    <div class="offcanvas-body filter-panel" style="background: #cac9ff; padding: 24px;">
        <form id="searchFilterForm" novalidate>
            <div id="filterError" class="text-danger small mb-3"></div>
            <div class="filter-field" style="margin-bottom: 22px;">
                <label for="priceMin" style="display: block; font-weight: 700; margin-bottom: 10px; color: #3735af;">Precio mínimo</label>
                <input type="number" id="priceMin" placeholder="Desde" class="form-control" min="0" max="999999" maxlength="7" style="width: 100%; border-radius: 14px; padding: 12px 14px; border: 1px solid #d8d9ef; color: #3735af; background: #ffffff;" />
            </div>
            <div class="filter-field" style="margin-bottom: 22px;">
                <label for="priceMax" style="display: block; font-weight: 700; margin-bottom: 10px; color: #3735af;">Precio máximo</label>
                <input type="number" id="priceMax" placeholder="Hasta" class="form-control" min="0" max="999999" maxlength="7" style="width: 100%; border-radius: 14px; padding: 12px 14px; border: 1px solid #d8d9ef; color: #3735af; background: #ffffff;" />
            </div>
            <div class="filter-field" style="margin-bottom: 22px;">
                <label for="storeFilter" style="display: block; font-weight: 700; margin-bottom: 10px; color: #3735af;">Tienda específica</label>
                <input type="text" id="storeFilter" list="storesList" placeholder="Ej: Moda Express" class="form-control" autocomplete="off" style="width: 100%; border-radius: 14px; padding: 12px 14px; border: 1px solid #d8d9ef; color: #3735af; background: #ffffff;" />
                <datalist id="storesList">
                    @foreach ($availableStores ?? [] as $storeName)
                        <option value="{{ $storeName }}"></option>
                    @endforeach
                </datalist>
            </div>
            <div class="filter-field" style="margin-bottom: 22px;">
                <label class="form-label fw-bold mb-3" style="display: block; font-weight: 700; margin-bottom: 10px; color: #3735af;">Mostrar solo resultados con ofertas</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="offerOnly" name="offerOnly" value="on">
                </div>
            </div>
            <!-- Hidden inputs para mantener filtros en URLs -->
            <input type="hidden" id="hiddenPriceMin" name="priceMin" />
            <input type="hidden" id="hiddenPriceMax" name="priceMax" />
            <input type="hidden" id="hiddenStoreFilter" name="storeFilter" />
            <input type="hidden" id="hiddenOfferOnly" name="offerOnly" />
            <div class="filter-actions" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 10px;">
                <button type="button" id="clearFiltersBtn" class="btn btn-outline-secondary" style="color: #3735af; border-color: #3735af; background: transparent;">Descartar</button>
                <button type="button" id="applyFiltersBtn" class="btn btn-primary" style="background: #3735af; border-color: #3735af; color: #ffffff;">Aplicar</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Validar que el offcanvas existe antes de continuar
    const filterOffcanvasDom = document.getElementById('filterOffcanvas');
    if (!filterOffcanvasDom) {
        console.error('Filter offcanvas element not found');
    }

    // Filtro validación y guardado
    const availableStores = @json($availableStores ?? []);
    const priceMinInput = document.getElementById('priceMin');
    const priceMaxInput = document.getElementById('priceMax');
    const storeFilterInput = document.getElementById('storeFilter');
    const offerOnlySwitch = document.getElementById('offerOnly');
    const filterError = document.getElementById('filterError');
    const applyFiltersBtn = document.getElementById('applyFiltersBtn');
    const clearFiltersBtn = document.getElementById('clearFiltersBtn');
    
    const hiddenPriceMin = document.getElementById('hiddenPriceMin');
    const hiddenPriceMax = document.getElementById('hiddenPriceMax');
    const hiddenStoreFilter = document.getElementById('hiddenStoreFilter');
    const hiddenOfferOnly = document.getElementById('hiddenOfferOnly');

    // Validar que todos los elementos existen
    if (!priceMinInput || !priceMaxInput || !storeFilterInput || !offerOnlySwitch) {
        console.error('Some filter input elements not found');
    }
    if (!applyFiltersBtn || !clearFiltersBtn) {
        console.error('Filter buttons not found');
    }

    // Restaurar filtros guardados al cargar la página
    const restoreSavedFilters = () => {
        const savedFilters = JSON.parse(localStorage.getItem('searchFilters') || '{}');
        if (savedFilters.priceMin) priceMinInput.value = savedFilters.priceMin;
        if (savedFilters.priceMax) priceMaxInput.value = savedFilters.priceMax;
        if (savedFilters.storeFilter) storeFilterInput.value = savedFilters.storeFilter;
        if (savedFilters.offerOnly) offerOnlySwitch.checked = true;
    };

    // Guardar filtros en localStorage
    const saveFilters = () => {
        const filters = {
            priceMin: priceMinInput.value,
            priceMax: priceMaxInput.value,
            storeFilter: storeFilterInput.value,
            offerOnly: offerOnlySwitch.checked
        };
        localStorage.setItem('searchFilters', JSON.stringify(filters));
    };

    // Función para mostrar mensaje de éxito
    const showSuccessMessage = (message = 'Filtros aplicados con éxito') => {
        // Remover mensaje anterior si existe
        const existingMessage = document.querySelector('.filter-success-message');
        if (existingMessage) existingMessage.remove();
        
        const successMsg = document.createElement('div');
        successMsg.className = 'filter-success-message';
        successMsg.innerHTML = `<i class="bi bi-check-circle me-2"></i>${message}`;
        document.body.appendChild(successMsg);
        
        // Remover después de 3 segundos
        setTimeout(() => successMsg.remove(), 3000);
    };

    const clearError = () => {
        filterError.innerHTML = '';
    };

    const validateFilters = () => {
        clearError();
        const minValue = priceMinInput.value.trim();
        const maxValue = priceMaxInput.value.trim();
        const storeValue = storeFilterInput.value.trim();
        const errors = [];

        if (minValue !== '' && maxValue !== '') {
            const minNum = parseFloat(minValue);
            const maxNum = parseFloat(maxValue);

            if (isNaN(minNum) || isNaN(maxNum)) {
                errors.push('Los valores de precio deben ser números válidos.');
            } else {
                if (minNum < 0 || maxNum < 0) {
                    errors.push('Los precios no pueden ser negativos.');
                }
                if (minNum > maxNum) {
                    errors.push('El precio mínimo no debe ser mayor al precio máximo.');
                }
            }
        }

        if (storeValue !== '' && !availableStores.includes(storeValue)) {
            errors.push(`La tienda "${storeValue}" no está registrada en nuestro sistema.`);
        }

        if (errors.length > 0) {
            const errorList = errors.map(error => `<li>${error}</li>`).join('');
            filterError.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 12px;">
                <strong>¡Oops!</strong> Parece que ocurrieron algunos errores:
                <ul class="mb-0 mt-2">${errorList}</ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>`;
            return false;
        }
        return true;
    };

    const filterOffcanvas = document.getElementById('filterOffcanvas');

    // Restaurar filtros al cargar la página
    restoreSavedFilters();

    // Restaurar filtros cuando se abre el offcanvas
    filterOffcanvas.addEventListener('show.bs.offcanvas', () => {
        restoreSavedFilters();
    });

    // Botón Aplicar filtros
    applyFiltersBtn.addEventListener('click', () => {
        if (validateFilters()) {
            const minValue = priceMinInput.value.trim();
            const maxValue = priceMaxInput.value.trim();
            const storeValue = storeFilterInput.value.trim();
            const offerChecked = offerOnlySwitch.checked ? 'on' : '';
            
            hiddenPriceMin.value = minValue;
            hiddenPriceMax.value = maxValue;
            hiddenStoreFilter.value = storeValue;
            hiddenOfferOnly.value = offerChecked;
            
            // Guardar filtros en localStorage
            saveFilters();
            
            // Mostrar mensaje de éxito
            showSuccessMessage('Filtros aplicados con éxito');
            
            // Cerrar offcanvas
            const offcanvas = bootstrap.Offcanvas.getInstance(filterOffcanvas);
            if (offcanvas) offcanvas.hide();
        }
    });

    // Botón Descartar filtros
    clearFiltersBtn.addEventListener('click', () => {
        clearError();
        priceMinInput.value = '';
        priceMaxInput.value = '';
        storeFilterInput.value = '';
        offerOnlySwitch.checked = false;
        
        hiddenPriceMin.value = '';
        hiddenPriceMax.value = '';
        hiddenStoreFilter.value = '';
        hiddenOfferOnly.value = '';
        
        // Limpiar localStorage
        localStorage.removeItem('searchFilters');
        
        // Mostrar mensaje de éxito
        showSuccessMessage('Filtros descartados');
        
        // Cerrar offcanvas
        const offcanvas = bootstrap.Offcanvas.getInstance(filterOffcanvas);
        if (offcanvas) offcanvas.hide();
    });

    // Evitar que se ingrese cero al inicio del número en campos de precio
    priceMinInput.addEventListener('input', function() {
        if (this.value.length > 1 && this.value.charAt(0) === '0') {
            this.value = this.value.substring(1);
        }
        // Limitar a 7 caracteres (máximo 999999)
        if (this.value.length > 7) {
            this.value = this.value.substring(0, 7);
        }
    });

    priceMaxInput.addEventListener('input', function() {
        if (this.value.length > 1 && this.value.charAt(0) === '0') {
            this.value = this.value.substring(1);
        }
        // Limitar a 7 caracteres (máximo 999999)
        if (this.value.length > 7) {
            this.value = this.value.substring(0, 7);
        }
    });

</script>
