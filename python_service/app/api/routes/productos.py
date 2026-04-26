from fastapi import APIRouter, Depends, HTTPException, Query, status
from sqlalchemy.orm import Session
from app.db.session import get_db
from app.schemas.producto import ProductoRespuesta, ProductosListaRespuesta
from app.services.producto_service import ProductoService

router = APIRouter()


@router.get("", response_model=ProductosListaRespuesta)
def obtener_productos(
    pagina: int = Query(default=1, ge=1),
    categoria_id: int | None = Query(default=None),
    db: Session = Depends(get_db)
):
    """Obtiene todos los productos con paginación"""
    service = ProductoService(db)
    return service.obtener_todos(pagina=pagina, filtro_categoria=categoria_id)


@router.get("/ofertas", response_model=ProductosListaRespuesta)
def obtener_ofertas(
    pagina: int = Query(default=1, ge=1),
    db: Session = Depends(get_db)
):
    """Obtiene solo productos con oferta"""
    service = ProductoService(db)
    return service.obtener_ofertas(pagina=pagina)


@router.get("/tienda/{tienda}", response_model=ProductosListaRespuesta)
def obtener_por_tienda(
    tienda: str,
    pagina: int = Query(default=1, ge=1),
    db: Session = Depends(get_db)
):
    """Obtiene productos de una tienda específica"""
    service = ProductoService(db)
    return service.obtener_por_tienda(tienda=tienda, pagina=pagina)


@router.get("/{producto_id}", response_model=ProductoRespuesta)
def obtener_producto(producto_id: int, db: Session = Depends(get_db)):
    """Obtiene un producto específico por ID"""
    service = ProductoService(db)
    producto = service.obtener_por_id(producto_id)
    
    if not producto:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="Producto no encontrado"
        )
    
    return producto
