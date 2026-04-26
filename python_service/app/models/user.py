from sqlalchemy import ForeignKey
from sqlalchemy.orm import Mapped, mapped_column, relationship
from typing import Optional, TYPE_CHECKING

from app.db.base import Base

if TYPE_CHECKING:
    from app.models.rol import Rol


class User(Base):
    __tablename__ = "users"

    id: Mapped[int] = mapped_column(primary_key=True)
    name: Mapped[str]
    email: Mapped[str]
    password: Mapped[str]
    email_verified_at: Mapped[Optional[str]] = mapped_column(nullable=True)
    remember_token: Mapped[Optional[str]] = mapped_column(nullable=True)
    created_at: Mapped[Optional[str]] = mapped_column(nullable=True)
    updated_at: Mapped[Optional[str]] = mapped_column(nullable=True)
    apellido_paterno: Mapped[Optional[str]] = mapped_column(nullable=True)
    apellido_materno: Mapped[Optional[str]] = mapped_column(nullable=True)
    rol_id: Mapped[Optional[int]] = mapped_column(ForeignKey("roles.id"), nullable=True)

    rol: Mapped[Optional["Rol"]] = relationship(back_populates="usuarios")
