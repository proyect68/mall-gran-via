from elasticsearch import Elasticsearch, helpers
from app.core.config import settings
import logging
import json

logger = logging.getLogger(__name__)

class ElasticsearchService:
    def __init__(self):
        # Conexión minimalista
        self.es = Elasticsearch(
            settings.elasticsearch_url,
            request_timeout=30,
            verify_certs=False
        )
        self.index_name = "idx_productos_v1" # Cambiamos nombre para evitar caché

    def create_index(self):
        """Intento de creación directa sin comprobaciones previas."""
        try:
            # 1. Verificar conexión básica
            info = self.es.info()
            logger.info(f"Conectado a Elastic: {info['version']['number']}")
            
            # 2. Intentar borrar si existe (a ciegas)
            try:
                self.es.indices.delete(index=self.index_name, ignore=[400, 404])
            except:
                pass

            # 3. Crear índice
            mappings = {
                "properties": {
                    "id": {"type": "integer"},
                    "nombre": {"type": "text", "analyzer": "spanish"},
                    "tienda": {"type": "keyword"},
                    "precio": {"type": "keyword"},
                    "es_servicio": {"type": "boolean"},
                    "oferta": {"type": "text", "analyzer": "spanish"}
                }
            }
            
            # Usar la API de ES8 de forma explícita
            self.es.indices.create(index=self.index_name, mappings=mappings)
            logger.info("Índice creado.")

        except Exception as e:
            logger.error(f"Fallo en create_index: {str(e)}")
            raise e

    def index_products(self, products_data: list):
        actions = []
        for p in products_data:
            if p.get('id') is None: continue
            actions.append({
                "_index": self.index_name,
                "_id": str(p['id']),
                "_source": {
                    "id": p['id'],
                    "nombre": p['nombre'],
                    "tienda": p['tienda'],
                    "precio": str(p['precio']),
                    "es_servicio": bool(p['es_servicio']),
                    "oferta": p.get('oferta') or ""
                }
            })
        if actions:
            helpers.bulk(self.es, actions)

    def search(self, query: str, limit: int = 100):
        if not query: return []
        try:
            body = {
                "query": {
                    "multi_match": {
                        "query": query,
                        "fields": ["nombre^3", "tienda^2", "oferta"],
                        "fuzziness": "AUTO"
                    }
                }
            }
            response = self.es.search(index=self.index_name, body=body, size=limit)
            return [hit['_source'] for hit in response['hits']['hits']]
        except:
            return []
