from pydantic import BaseModel


class CategoriaBase(BaseModel):
    id: int
    nombre: str
    imagen: str | None = None
    descripcion: str | None = None


class CategoriaRespuesta(CategoriaBase):
    productos_count: int = 0
    tiendas_count: int = 0

    class Config:
        from_attributes = True
