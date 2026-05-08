import os
from elasticsearch import Elasticsearch, helpers
import logging

logger = logging.getLogger(__name__)

class SearchEngineService:
    def __init__(self):
        self.es = Elasticsearch(os.getenv("ELASTICSEARCH_URL", "http://elasticsearch:9200"))
        self.index_name = "idx_mall_v1"
        self.indices = {
            "productos": "idx_products_admin_v1",
            "usuarios": "idx_users_admin_v1",
            "tiendas": "idx_stores_admin_v1"
        }

    def create_admin_indices(self):
        """Crea índices con analizadores de autocompletado para búsqueda parcial."""
        settings = {
            "analysis": {
                "filter": {
                    "autocomplete_filter": {
                        "type": "edge_ngram",
                        "min_gram": 1,
                        "max_gram": 20
                    }
                },
                "analyzer": {
                    "autocomplete_analyzer": {
                        "type": "custom",
                        "tokenizer": "standard",
                        "filter": ["lowercase", "autocomplete_filter"]
                    }
                }
            }
        }

        for name, index in self.indices.items():
            if not self.es.indices.exists(index=index):
                body = {
                    "settings": settings,
                    "mappings": {
                        "properties": {
                            "id": {"type": "keyword"}, # Buscable por ID exacto
                            "nombre": {"type": "text", "analyzer": "autocomplete_analyzer", "search_analyzer": "standard"},
                            "name": {"type": "text", "analyzer": "autocomplete_analyzer", "search_analyzer": "standard"},
                            "email": {"type": "text", "analyzer": "autocomplete_analyzer", "search_analyzer": "standard"},
                            "role": {"type": "text", "analyzer": "standard"}, # Rol exacto para evitar ruido
                            "tienda": {"type": "text", "analyzer": "autocomplete_analyzer"},
                            "categoria": {"type": "text", "analyzer": "autocomplete_analyzer"},
                            "rif": {"type": "text", "analyzer": "autocomplete_analyzer"},
                            "descripcion": {"type": "text", "analyzer": "spanish"}
                        }
                    }
                }
                self.es.indices.create(index=index, body=body)
                logger.info(f"Índice {index} creado con autocompletado.")

    def index_batch(self, category: str, data: list):
        index = self.indices.get(category)
        if not index: return
        
        actions = [
            {
                "_index": index,
                "_id": str(item["id"]),
                "_source": item
            }
            for item in data
        ]
        if actions:
            helpers.bulk(self.es, actions)

    def search_admin(self, category: str, query: str, limit: int = 50):
        index = self.indices.get(category)
        if not index or not query: return []
        
        fields = []
        if category == "productos": fields = ["id", "nombre^3", "tienda", "categoria"]
        elif category == "usuarios": fields = ["id", "name^3", "email"] # Quitamos 'role' para evitar el ruido que mencionaste
        elif category == "tiendas": fields = ["nombre^3", "rif", "descripcion"]

        body = {
            "query": {
                "multi_match": {
                    "query": query,
                    "fields": fields,
                    "type": "best_fields",
                    "fuzziness": "AUTO"
                }
            },
            "size": limit
        }
        
        try:
            res = self.es.search(index=index, body=body)
            return [hit["_source"] for hit in res["hits"]["hits"]]
        except Exception as e:
            logger.error(f"Error en búsqueda: {e}")
            return []
