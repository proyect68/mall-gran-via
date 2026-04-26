import math
from sqlalchemy.orm import Session
from app.models.producto import Producto
from app.schemas.producto import ProductoRespuesta, ProductosListaRespuesta


class ProductoService:
    def __init__(self, db: Session):
        self.db = db
        self.por_pagina = 28

    def obtener_todos(self, pagina: int = 1, filtro_categoria: int | None = None) -> ProductosListaRespuesta:
        """Obtiene todos los productos con paginación"""
        query = self.db.query(Producto)
        
        if filtro_categoria:
            query = query.filter(Producto.categoria_id == filtro_categoria)
        
        total = query.count()
        total_paginas = max(1, math.ceil(total / self.por_pagina))
        pagina = max(1, min(pagina, total_paginas))
        
        start = (pagina - 1) * self.por_pagina
        productos = query.offset(start).limit(self.por_pagina).all()
        
        return ProductosListaRespuesta(
            productos=[ProductoRespuesta.model_validate(p) for p in productos],
            total=total,
            pagina=pagina,
            por_pagina=self.por_pagina,
            total_paginas=total_paginas
        )

    def obtener_por_id(self, producto_id: int) -> ProductoRespuesta | None:
        """Obtiene un producto por ID"""
        producto = self.db.query(Producto).filter(Producto.id == producto_id).first()
        if not producto:
            return None
        return ProductoRespuesta.model_validate(producto)

    def obtener_por_tienda(self, tienda: str, pagina: int = 1) -> ProductosListaRespuesta:
        """Obtiene productos de una tienda específica"""
        query = self.db.query(Producto).filter(Producto.tienda == tienda)
        
        total = query.count()
        total_paginas = max(1, math.ceil(total / self.por_pagina))
        pagina = max(1, min(pagina, total_paginas))
        
        start = (pagina - 1) * self.por_pagina
        productos = query.offset(start).limit(self.por_pagina).all()
        
        return ProductosListaRespuesta(
            productos=[ProductoRespuesta.model_validate(p) for p in productos],
            total=total,
            pagina=pagina,
            por_pagina=self.por_pagina,
            total_paginas=total_paginas
        )

    def obtener_ofertas(self, pagina: int = 1) -> ProductosListaRespuesta:
        """Obtiene solo productos con oferta"""
        query = self.db.query(Producto).filter(Producto.oferta.isnot(None))
        
        total = query.count()
        total_paginas = max(1, math.ceil(total / self.por_pagina))
        pagina = max(1, min(pagina, total_paginas))
        
        start = (pagina - 1) * self.por_pagina
        productos = query.offset(start).limit(self.por_pagina).all()
        
        return ProductosListaRespuesta(
            productos=[ProductoRespuesta.model_validate(p) for p in productos],
            total=total,
            pagina=pagina,
            por_pagina=self.por_pagina,
            total_paginas=total_paginas
        )
