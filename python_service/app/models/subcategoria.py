from sqlalchemy import ForeignKey, Text
from sqlalchemy.orm import Mapped, mapped_column, relationship
from typing import Optional, TYPE_CHECKING

from app.db.base import Base

if TYPE_CHECKING:
    from app.models.categoria import Categoria
    from app.models.producto import Producto


class Subcategoria(Base):
    __tablename__ = "subcategorias"

    id: Mapped[int] = mapped_column(primary_key=True)
    nombre: Mapped[str]
    imagen: Mapped[Optional[str]] = mapped_column(nullable=True)
    descripcion: Mapped[Optional[str]] = mapped_column(Text, nullable=True)
    categoria_id: Mapped[int] = mapped_column(ForeignKey("categorias.id"))

    categoria: Mapped["Categoria"] = relationship(back_populates="subcategorias")
    productos: Mapped[list["Producto"]] = relationship(back_populates="subcategoria")
