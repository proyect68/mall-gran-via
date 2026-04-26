from sqlalchemy import Text
from sqlalchemy.orm import Mapped, mapped_column, relationship
from typing import Optional, TYPE_CHECKING

from app.db.base import Base

if TYPE_CHECKING:
    from app.models.producto import Producto
    from app.models.subcategoria import Subcategoria


class Categoria(Base):
    __tablename__ = "categorias"

    id: Mapped[int] = mapped_column(primary_key=True)
    nombre: Mapped[str]
    imagen: Mapped[Optional[str]] = mapped_column(nullable=True)
    descripcion: Mapped[Optional[str]] = mapped_column(Text, nullable=True)

    productos: Mapped[list["Producto"]] = relationship(back_populates="categoria")
    subcategorias: Mapped[list["Subcategoria"]] = relationship(back_populates="categoria")
