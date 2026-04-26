from fastapi import APIRouter, Depends, Query
from sqlalchemy.orm import Session

from app.db.session import get_db
from app.schemas.busqueda import BusquedaRespuesta
from app.services.busqueda_service import SearchService


router = APIRouter()


@router.get("", response_model=BusquedaRespuesta)
def buscar(
    q: str | None = Query(default=None),
    pagina: int = Query(default=1, ge=1),
    precio_minimo: float | None = Query(default=None, ge=0),
    precio_maximo: float | None = Query(default=None, ge=0),
    tienda: str | None = Query(default=None),
    solo_ofertas: bool = Query(default=False),
    db: Session = Depends(get_db),
) -> BusquedaRespuesta:
    servicio = SearchService(db)
    return servicio.buscar(
        query=q,
        page=pagina,
        price_min=precio_minimo,
        price_max=precio_maximo,
        store_filter=tienda,
        offer_only=solo_ofertas,
    )
