from fastapi import APIRouter, Depends, HTTPException, Query, status
from sqlalchemy.orm import Session
from app.db.session import get_db
from app.schemas.usuario import TiendaRespuesta, OfertaRespuesta
from app.services.usuario_service import TiendaService, OfertasService

router = APIRouter()


@router.get("", response_model=list[TiendaRespuesta])
def obtener_tiendas(db: Session = Depends(get_db)):
    """Obtiene todas las tiendas disponibles"""
    service = TiendaService(db)
    return service.obtener_todas()


@router.get("/{nombre}", response_model=TiendaRespuesta)
def obtener_tienda(nombre: str, db: Session = Depends(get_db)):
    """Obtiene una tienda específica por nombre"""
    service = TiendaService(db)
    tienda = service.obtener_por_nombre(nombre)
    
    if not tienda:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="Tienda no encontrada"
        )
    
    return tienda
