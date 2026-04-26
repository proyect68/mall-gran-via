from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session
from app.db.session import get_db
from app.schemas.auth import LoginRequest, LoginResponse
from app.services.auth_service import authenticate_user, create_access_token
from datetime import timedelta

router = APIRouter()


@router.post("/login", response_model=LoginResponse)
def login(
    request: LoginRequest,
    db: Session = Depends(get_db)
):
    """Autentica un usuario y devuelve un JWT token"""
    user = authenticate_user(db, request.email, request.password)
    
    if not user:
        raise HTTPException(
            status_code=status.HTTP_401_UNAUTHORIZED,
            detail="Email o contraseña incorrectos",
            headers={"WWW-Authenticate": "Bearer"},
        )
    
    # Crear token JWT
    access_token = create_access_token(
        data={"sub": user.id},
        expires_delta=timedelta(hours=24)
    )
    
    return LoginResponse(
        id=user.id,
        name=user.name,
        email=user.email,
        access_token=access_token,
        token_type="bearer"
    )


@router.post("/logout")
def logout():
    """Logout del usuario (lado del cliente elimina el token)"""
    return {"message": "Logout exitoso"}
