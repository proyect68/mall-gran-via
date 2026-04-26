from pydantic import BaseModel


class ProductoBusqueda(BaseModel):
    id: int
    nombre: str
    tienda: str
    precio: str
    precio_anterior: str | None = None
    oferta: str | None = None
    color: str | None = None
    imagen: str | None = None
    expira: str | None = None
    es_servicio: bool
    categoria_id: int | None = None
    subcategoria_id: int | None = None


class TiendaRelacionada(BaseModel):
    nombre: str
    imagen: str
    cantidad_productos_relacionados: int
    productos: list[ProductoBusqueda]
    estado: str = "Abierto"


class BusquedaRespuesta(BaseModel):
    query: str | None = None
    productos: list[ProductoBusqueda]
    servicios: list[ProductoBusqueda]
    tiendas_relacionadas: list[TiendaRelacionada]
    pagina_actual: int
    total_paginas_productos: int
    total_paginas_servicios: int
    total_productos: int
    total_servicios: int
    precio_minimo: float | None = None
    precio_maximo: float | None = None
    tienda: str | None = None
    solo_ofertas: bool = False
    mostrando_todo: bool = False
