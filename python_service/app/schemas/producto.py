from pydantic import BaseModel


class ProductoBase(BaseModel):
    id: int
    nombre: str
    tienda: str
    precio: str
    precio_anterior: str | None = None
    oferta: str | None = None
    color: str | None = None
    imagen: str | None = None
    expira: str | None = None
    es_servicio: bool = False
    categoria_id: int | None = None
    subcategoria_id: int | None = None


class ProductoRespuesta(ProductoBase):
    class Config:
        from_attributes = True


class ProductosListaRespuesta(BaseModel):
    productos: list[ProductoRespuesta]
    total: int
    pagina: int
    por_pagina: int
    total_paginas: int
