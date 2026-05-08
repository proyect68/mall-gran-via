from sqlalchemy import Text
from sqlalchemy.orm import Mapped, mapped_column
from typing import Optional

from app.db.base import Base


class Tienda(Base):
    __tablename__ = "tiendas"

    id_tienda: Mapped[int] = mapped_column(primary_key=True)
    nombre: Mapped[str]
    logo_url: Mapped[Optional[str]] = mapped_column(nullable=True)
    descripcion: Mapped[Optional[str]] = mapped_column(Text, nullable=True)
    horario: Mapped[Optional[str]] = mapped_column(nullable=True)
    estado: Mapped[Optional[str]] = mapped_column(nullable=True, default="activo")
