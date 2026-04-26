from fastapi import APIRouter, Depends, Query
from sqlalchemy.orm import Session
from app.db.session import get_db
from app.schemas.usuario import OfertaRespuesta
from app.services.usuario_service import OfertasService

router = APIRouter()


@router.get("", response_model=list[OfertaRespuesta])
def obtener_ofertas(
    pagina: int = Query(default=1, ge=1),
    db: Session = Depends(get_db)
):
    """Obtiene todos los productos con oferta"""
    service = OfertasService(db)
    return service.obtener_todas(pagina=pagina)
