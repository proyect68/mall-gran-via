import logging
from sqlalchemy.orm import Session, joinedload
from app.models.producto import Producto
from app.models.user import User
from app.models.tienda import Tienda
from app.services.search_engine import SearchEngineService

logger = logging.getLogger(__name__)

class SearchService:
    def __init__(self, db: Session) -> None:
        self.db = db
        self.es_service = SearchEngineService()

    def search_admin(self, category: str, query: str):
        """Busca en los índices de administración."""
        print(f"DEBUG: SearchService recibiendo busqueda para {category} con query: '{query}'")
        res = self.es_service.search_admin(category, query)
        print(f"DEBUG: Resultados encontrados: {len(res)}")
        return res

    def sync_elasticsearch(self) -> dict:
        """Sincroniza Productos, Usuarios y Tiendas a Elasticsearch."""
        try:
            self.es_service.create_admin_indices()
            
            # 1. Sincronizar Productos
            productos_db = self.db.query(Producto).options(
                joinedload(Producto.categoria),
                joinedload(Producto.subcategoria)
            ).all()
            p_data = [{
                "id": p.id,
                "nombre": p.nombre,
                "tienda": p.tienda,
                "precio": p.precio,
                "es_servicio": p.es_servicio,
                "oferta": p.oferta,
                "estado": "Activo",
                "categoria": p.categoria.nombre if p.categoria else "",
                "subcategoria": p.subcategoria.nombre if p.subcategoria else ""
            } for p in productos_db]
            self.es_service.index_batch("productos", p_data)

            # 2. Sincronizar Usuarios
            usuarios_db = self.db.query(User).options(joinedload(User.rol)).all()
            u_data = [{
                "id": u.id,
                "name": f"{u.name} {u.apellido_paterno or ''} {u.apellido_materno or ''}".strip(),
                "email": u.email,
                "role": u.rol.nombre if u.rol else "cliente"
            } for u in usuarios_db]
            self.es_service.index_batch("usuarios", u_data)

            # 3. Sincronizar Tiendas
            tiendas_db = self.db.query(Tienda).all()
            t_data = [{
                "id": t.id_tienda,
                "nombre": t.nombre,
                "rif": getattr(t, 'rif', ''),
                "descripcion": t.descripcion,
                "estado": t.estado or "activo",
                "imagen": t.logo_url
            } for t in tiendas_db]
            self.es_service.index_batch("tiendas", t_data)
            
            return {
                "status": "success", 
                "total_productos": len(p_data),
                "total_usuarios": len(u_data),
                "total_tiendas": len(t_data)
            }
        except Exception as e:
            import traceback
            logger.error(f"Error sincronización: {str(e)}")
            return {
                "status": "error", 
                "message": str(e),
                "traceback": traceback.format_exc()
            }

    def buscar(self, query: str | None, pagina: int = 1, precio_minimo: float | None = None, 
               precio_maximo: float | None = None, tienda: str | None = None, 
               solo_ofertas: bool = False) -> dict:
        # Mantenemos la lógica de búsqueda de cliente aquí (simplificada para v2)
        if not query or len(query) < 2:
            return {"productos": [], "total_productos": 0, "mostrando_todo": True}
            
        resultados = self.es_service.search(query, limit=100)
        
        # Filtros manuales post-elastic (opcional)
        if precio_minimo:
            resultados = [r for r in resultados if float(str(r['precio']).replace('$','')) >= precio_minimo]
            
        return {
            "query": query,
            "productos": [r for r in resultados if not r.get('es_servicio')],
            "servicios": [r for r in resultados if r.get('es_servicio')],
            "total_productos": len(resultados),
            "pagina_actual": pagina,
            "total_paginas": 1,
            "mostrando_todo": False
        }
