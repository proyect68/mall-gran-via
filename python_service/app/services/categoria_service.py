from sqlalchemy.orm import Session
from app.models.categoria import Categoria
from app.models.producto import Producto
from app.schemas.categoria import CategoriaRespuesta


class CategoriaService:
    def __init__(self, db: Session):
        self.db = db

    def obtener_todas(self) -> list[CategoriaRespuesta]:
        """Obtiene todas las categorías con conteo de productos"""
        categorias = self.db.query(Categoria).all()
        resultado = []
        
        for cat in categorias:
            productos = self.db.query(Producto).filter(Producto.categoria_id == cat.id).all()
            tiendas = set()
            for prod in productos:
                if prod.tienda:
                    tiendas.add(prod.tienda)
            
            resultado.append(CategoriaRespuesta(
                id=cat.id,
                nombre=cat.nombre,
                imagen=cat.imagen,
                descripcion=cat.descripcion,
                productos_count=len(productos),
                tiendas_count=len(tiendas)
            ))
        
        return resultado

    def obtener_por_id(self, categoria_id: int) -> CategoriaRespuesta | None:
        """Obtiene una categoría por ID"""
        cat = self.db.query(Categoria).filter(Categoria.id == categoria_id).first()
        if not cat:
            return None
        
        productos = self.db.query(Producto).filter(Producto.categoria_id == cat.id).all()
        tiendas = set()
        for prod in productos:
            if prod.tienda:
                tiendas.add(prod.tienda)
        
        return CategoriaRespuesta(
            id=cat.id,
            nombre=cat.nombre,
            imagen=cat.imagen,
            descripcion=cat.descripcion,
            productos_count=len(productos),
            tiendas_count=len(tiendas)
        )
