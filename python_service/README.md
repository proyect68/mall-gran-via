# Python Service

Este servicio introduce `FastAPI` al proyecto sin reemplazar todavía a Laravel.

Objetivos iniciales:
- mantener Laravel como base principal
- extraer módulos intensivos en análisis a Python
- reutilizar PostgreSQL como única fuente de datos
- establecer una estructura reusable para futuros módulos

Estructura:
- `app/api`: endpoints
- `app/core`: configuración base
- `app/db`: conexión y base ORM
- `app/models`: modelos SQLAlchemy
- `app/schemas`: contratos de entrada y salida
- `app/services`: lógica de negocio

Primer módulo:
- `busqueda`: replica la lógica de búsqueda sobre `productos` y sirve como patrón para futuros módulos
