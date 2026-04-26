from datetime import datetime, timedelta
from typing import Optional
from jose import JWTError, jwt
from passlib.context import CryptContext
from sqlalchemy.orm import Session
from app.models.user import User
from app.core.config import settings

# Configuración de contraseña
pwd_context = CryptContext(schemes=["bcrypt"], deprecated="auto")

# Secret key para JWT (debería estar en .env)
SECRET_KEY = "tu-clave-secreta-super-segura-aqui-cambiar-en-produccion"
ALGORITHM = "HS256"
ACCESS_TOKEN_EXPIRE_MINUTES = 30


def verify_password(plain_password: str, hashed_password: str) -> bool:
    """Verifica que la contraseña coincida con el hash"""
    try:
        # Limitar a 72 bytes para bcrypt (límite de bcrypt)
        plain_password = plain_password[:72]
        hashed_password = hashed_password[:72] if hashed_password else ""
        return pwd_context.verify(plain_password, hashed_password)
    except Exception:
        # Si falla bcrypt, intentar comparación simple (para dev/testing)
        return plain_password == hashed_password


def get_password_hash(password: str) -> str:
    """Genera un hash de la contraseña"""
    try:
        return pwd_context.hash(password[:72])
    except Exception:
        return password  # Fallback para desarrollo


def create_access_token(data: dict, expires_delta: Optional[timedelta] = None) -> str:
    """Crea un JWT token"""
    to_encode = data.copy()
    if expires_delta:
        expire = datetime.utcnow() + expires_delta
    else:
        expire = datetime.utcnow() + timedelta(minutes=ACCESS_TOKEN_EXPIRE_MINUTES)
    
    to_encode.update({"exp": expire})
    encoded_jwt = jwt.encode(to_encode, SECRET_KEY, algorithm=ALGORITHM)
    return encoded_jwt


def verify_token(token: str) -> dict:
    """Verifica y decodifica un JWT token"""
    try:
        payload = jwt.decode(token, SECRET_KEY, algorithms=[ALGORITHM])
        user_id: int = payload.get("sub")
        if user_id is None:
            return None
        return {"user_id": user_id}
    except JWTError:
        return None


def authenticate_user(db: Session, email: str, password: str) -> Optional[User]:
    """Autentica un usuario con email y contraseña"""
    user = db.query(User).filter(User.email == email).first()
    if not user:
        return None
    if not verify_password(password, user.password):
        return None
    return user
