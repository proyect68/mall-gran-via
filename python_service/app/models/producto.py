from sqlalchemy import Boolean, ForeignKey
from sqlalchemy.orm import Mapped, mapped_column, relationship
from typing import Optional, TYPE_CHECKING

from app.db.base import Base

if TYPE_CHECKING:
    from app.models.categoria import Categoria
    from app.models.subcategoria import Subcategoria


class Producto(Base):
    __tablename__ = "productos"

    id: Mapped[int] = mapped_column(primary_key=True)
    nombre: Mapped[str]
    tienda: Mapped[str]
    precio: Mapped[str]
    precio_anterior: Mapped[Optional[str]] = mapped_column(nullable=True)
    oferta: Mapped[Optional[str]] = mapped_column(nullable=True)
    color: Mapped[Optional[str]] = mapped_column(nullable=True)
    imagen: Mapped[Optional[str]] = mapped_column(nullable=True)
    expira: Mapped[Optional[str]] = mapped_column(nullable=True)
    es_servicio: Mapped[bool] = mapped_column(Boolean, default=False)
    categoria_id: Mapped[Optional[int]] = mapped_column(ForeignKey("categorias.id"), nullable=True)
    subcategoria_id: Mapped[Optional[int]] = mapped_column(ForeignKey("subcategorias.id"), nullable=True)

    categoria: Mapped[Optional["Categoria"]] = relationship("Categoria", back_populates="productos")
    subcategoria: Mapped[Optional["Subcategoria"]] = relationship("Subcategoria", back_populates="productos")
