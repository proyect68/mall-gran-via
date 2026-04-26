import math
import re
from collections import defaultdict

from sqlalchemy.orm import Session, joinedload

from app.models.producto import Producto
from app.schemas.busqueda import BusquedaRespuesta, ProductoBusqueda, TiendaRelacionada


class SearchService:
    def __init__(self, db: Session) -> None:
        self.db = db

    def buscar(
        self,
        query: str | None,
        page: int,
        price_min: float | None,
        price_max: float | None,
        store_filter: str | None,
        offer_only: bool,
    ) -> BusquedaRespuesta:
        per_page = 28
        productos_db = (
            self.db.query(Producto)
            .options(joinedload(Producto.categoria), joinedload(Producto.subcategoria))
            .all()
        )

        todos = [self._to_schema(producto) for producto in productos_db]

        if not query or len(query.strip()) < 2:
            resultados = todos
        else:
            resultados = self._intelligent_search(todos, query)

        productos = [item for item in resultados if not item.es_servicio]
        servicios = [item for item in resultados if item.es_servicio]

        productos_filtrados = self._apply_filters(
            productos,
            price_min=price_min,
            price_max=price_max,
            store_filter=store_filter,
            offer_only=offer_only,
        )
        servicios_filtrados = self._apply_filters(
            servicios,
            price_min=price_min,
            price_max=price_max,
            store_filter=store_filter,
            offer_only=offer_only,
        )

        total_productos = len(productos_filtrados)
        total_servicios = len(servicios_filtrados)
        total_paginas_productos = max(1, math.ceil(total_productos / per_page)) if total_productos else 1
        total_paginas_servicios = max(1, math.ceil(total_servicios / per_page)) if total_servicios else 1
        pagina = max(1, min(page, total_paginas_productos))
        start = (pagina - 1) * per_page

        productos_paginados = productos_filtrados[start : start + per_page]
        servicios_paginados = servicios_filtrados[start : start + per_page]

        tiendas_relacionadas: list[TiendaRelacionada] = []
        if pagina == 1:
            agrupados: dict[str, list[ProductoBusqueda]] = defaultdict(list)
            for item in [*productos_filtrados, *servicios_filtrados]:
                agrupados[item.tienda].append(item)

            tiendas_relacionadas = [
                TiendaRelacionada(
                    nombre=nombre,
                    imagen="https://images.unsplash.com/photo-1555632238-c47966bcbe66?w=400&h=400&fit=crop&q=80",
                    cantidad_productos_relacionados=len(items),
                    productos=items[:3],
                )
                for nombre, items in agrupados.items()
            ]

        return BusquedaRespuesta(
            query=query,
            productos=productos_paginados,
            servicios=servicios_paginados,
            tiendas_relacionadas=tiendas_relacionadas,
            pagina_actual=pagina,
            total_paginas_productos=total_paginas_productos,
            total_paginas_servicios=total_paginas_servicios,
            total_productos=total_productos,
            total_servicios=total_servicios,
            precio_minimo=price_min,
            precio_maximo=price_max,
            tienda=store_filter,
            solo_ofertas=offer_only,
            mostrando_todo=not query or len(query.strip()) < 2,
        )

    def _apply_filters(
        self,
        items: list[ProductoBusqueda],
        price_min: float | None,
        price_max: float | None,
        store_filter: str | None,
        offer_only: bool,
    ) -> list[ProductoBusqueda]:
        resultado: list[ProductoBusqueda] = []
        for item in items:
            if price_min is not None and item.precio != "Consultar":
                if self._extract_price(item.precio) < price_min:
                    continue

            if price_max is not None and item.precio != "Consultar":
                if self._extract_price(item.precio) > price_max:
                    continue

            if store_filter and store_filter.lower() not in item.tienda.lower():
                continue

            if offer_only and not item.oferta:
                continue

            resultado.append(item)
        return resultado

    def _intelligent_search(self, productos: list[ProductoBusqueda], query: str) -> list[ProductoBusqueda]:
        query_lower = query.strip().lower()
        query_words = [word for word in query_lower.split() if word]

        relaciones = {
            "camisas": ["camisa"],
            "zapatos": ["zapato"],
            "auriculares": ["auricular"],
            "productos": ["producto"],
            "tiendas": ["tienda"],
            "ofertas": ["oferta", "promocion"],
        }

        expanded_keywords: dict[str, list[str]] = {}
        for word in query_words:
            expanded_keywords[word] = [word]
            if len(word) > 3:
                if word.endswith("s"):
                    expanded_keywords[word].append(word[:-1])
                else:
                    expanded_keywords[word].append(f"{word}s")
            if word in relaciones:
                expanded_keywords[word].extend(relaciones[word])

        scored: list[tuple[int, ProductoBusqueda]] = []
        for producto in productos:
            score = 0
            nombre = producto.nombre.lower()
            tienda = producto.tienda.lower()
            oferta = (producto.oferta or "").lower()

            for keywords in expanded_keywords.values():
                for keyword in keywords:
                    if keyword in nombre:
                        score += 50
                    if keyword in tienda:
                        score += 30
                    if keyword in oferta:
                        score += 10

            if score > 0:
                scored.append((score, producto))

        scored.sort(key=lambda item: item[0], reverse=True)
        return [producto for _, producto in scored]

    def _extract_price(self, price: str | None) -> float:
        if not price:
            return 0.0
        cleaned = re.sub(r"[^0-9.]", "", price)
        return float(cleaned) if cleaned else 0.0

    def _to_schema(self, producto: Producto) -> ProductoBusqueda:
        return ProductoBusqueda(
            id=producto.id,
            nombre=producto.nombre,
            tienda=producto.tienda,
            precio=producto.precio,
            precio_anterior=producto.precio_anterior,
            oferta=producto.oferta,
            color=producto.color,
            imagen=producto.imagen,
            expira=producto.expira,
            es_servicio=producto.es_servicio,
            categoria_id=producto.categoria_id,
            subcategoria_id=producto.subcategoria_id,
        )
