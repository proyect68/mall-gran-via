from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session
from app.db.session import get_db
from app.schemas.usuario import UserProfile
from app.services.usuario_service import UsuarioService
from app.services.auth_service import verify_token

router = APIRouter()


def get_current_user(token: str | None = None, db: Session = Depends(get_db)):
    """Obtiene el usuario actual desde el token JWT"""
    if not token:
        raise HTTPException(
            status_code=status.HTTP_401_UNAUTHORIZED,
            detail="No autorizado"
        )
    
    token_data = verify_token(token)
    if not token_data:
        raise HTTPException(
            status_code=status.HTTP_401_UNAUTHORIZED,
            detail="Token inválido o expirado"
        )
    
    return token_data["user_id"]


@router.get("/profile", response_model=UserProfile)
def obtener_perfil(
    user_id: int = Depends(get_current_user),
    db: Session = Depends(get_db)
):
    """Obtiene el perfil del usuario autenticado"""
    service = UsuarioService(db)
    perfil = service.obtener_perfil(user_id)
    
    if not perfil:
        raise HTTPException(
            status_code=status.HTTP_404_NOT_FOUND,
            detail="Usuario no encontrado"
        )
    
    return perfil
