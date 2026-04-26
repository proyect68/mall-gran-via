from pydantic import BaseModel


class UserProfile(BaseModel):
    id: int
    name: str
    email: str
    apellido_paterno: str | None = None
    apellido_materno: str | None = None
    created_at: str | None = None

    class Config:
        from_attributes = True


class WishlistItem(BaseModel):
    id: int
    nombre: str
    precio: str
    imagen: str | None = None
    tienda: str

    class Config:
        from_attributes = True


class TiendaRespuesta(BaseModel):
    nombre: str
    productos_count: int = 0
    servicios_count: int = 0

    class Config:
        from_attributes = True


class OfertaRespuesta(BaseModel):
    id: int
    nombre: str
    precio: str
    precio_anterior: str | None = None
    oferta: str | None = None
    imagen: str | None = None
    tienda: str

    class Config:
        from_attributes = True
