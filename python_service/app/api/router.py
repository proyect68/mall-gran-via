from fastapi import APIRouter

from app.api.routes import busqueda, health, auth, categorias, productos, usuario, tiendas, ofertas


api_router = APIRouter()
api_router.include_router(health.router, prefix="/health", tags=["health"])
api_router.include_router(auth.router, prefix="/auth", tags=["auth"])
api_router.include_router(busqueda.router, prefix="/busqueda", tags=["busqueda"])
api_router.include_router(categorias.router, prefix="/categorias", tags=["categorias"])
api_router.include_router(productos.router, prefix="/productos", tags=["productos"])
api_router.include_router(usuario.router, prefix="/user", tags=["usuario"])
api_router.include_router(tiendas.router, prefix="/tiendas", tags=["tiendas"])
api_router.include_router(ofertas.router, prefix="/ofertas", tags=["ofertas"])
