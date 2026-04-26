from fastapi import FastAPI
import os

app = FastAPI(title="Mall Gran Via - Analytics Engine")

@app.get("/")
def read_root():
    return {"status": "online", "message": "Python API está conectada correctamente"}

@app.get("/test-data")
def test_data():
    # Aquí es donde luego haremos el análisis de datos real
    data = {"category": "Moda", "total_products": 150, "relevance_score": 0.95}
    return data
