from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session
from app.db.session import get_db
from app.schemas.categoria import CategoriaRespuesta
from app.services.categoria_service import CategoriaService

router = APIRouter()


@router.get("", response_model=list[CategoriaRespuesta])
def obtener_categorias(db: Session = Depends(get_db)):
    """Obtiene todas las categorías con conteo de productos y tiendas"""
    service = CategoriaService(db)
    return service.obtener_todas()


@router.get("/{categoria_id}", response_model=CategoriaRespuesta)
def obtener_categoria(categoria_id: int, db: Session = Depends(get_db)):
    """Obtiene una categoría específica por ID"""
    service = CategoriaService(db)
    categoria = service.obtener_por_id(categoria_id)
    
    if not categoria:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="Categoría no encontrada"
        )
    
    return categoria
