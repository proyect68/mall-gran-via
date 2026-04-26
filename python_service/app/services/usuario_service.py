from sqlalchemy.orm import Session
from app.models.user import User
from app.models.producto import Producto
from app.schemas.usuario import UserProfile, TiendaRespuesta, OfertaRespuesta


class UsuarioService:
    def __init__(self, db: Session):
        self.db = db

    def obtener_perfil(self, user_id: int) -> UserProfile | None:
        """Obtiene el perfil de un usuario"""
        user = self.db.query(User).filter(User.id == user_id).first()
        if not user:
            return None
        return UserProfile.model_validate(user)


class TiendaService:
    def __init__(self, db: Session):
        self.db = db

    def obtener_todas(self) -> list[TiendaRespuesta]:
        """Obtiene todas las tiendas únicas"""
        tiendas = self.db.query(Producto.tienda).distinct().all()
        resultado = []
        
        for (tienda_nombre,) in tiendas:
            if not tienda_nombre:
                continue
                
            productos = self.db.query(Producto).filter(
                Producto.tienda == tienda_nombre,
                Producto.es_servicio == False
            ).count()
            
            servicios = self.db.query(Producto).filter(
                Producto.tienda == tienda_nombre,
                Producto.es_servicio == True
            ).count()
            
            resultado.append(TiendaRespuesta(
                nombre=tienda_nombre,
                productos_count=productos,
                servicios_count=servicios
            ))
        
        return resultado

    def obtener_por_nombre(self, nombre: str) -> TiendaRespuesta | None:
        """Obtiene una tienda por nombre"""
        existe = self.db.query(Producto).filter(Producto.tienda == nombre).first()
        if not existe:
            return None
        
        productos = self.db.query(Producto).filter(
            Producto.tienda == nombre,
            Producto.es_servicio == False
        ).count()
        
        servicios = self.db.query(Producto).filter(
            Producto.tienda == nombre,
            Producto.es_servicio == True
        ).count()
        
        return TiendaRespuesta(
            nombre=nombre,
            productos_count=productos,
            servicios_count=servicios
        )


class OfertasService:
    def __init__(self, db: Session):
        self.db = db

    def obtener_todas(self, pagina: int = 1) -> list[OfertaRespuesta]:
        """Obtiene todos los productos con oferta"""
        por_pagina = 28
        start = (pagina - 1) * por_pagina
        
        productos = self.db.query(Producto).filter(
            Producto.oferta.isnot(None)
        ).offset(start).limit(por_pagina).all()
        
        return [OfertaRespuesta.model_validate(p) for p in productos]
