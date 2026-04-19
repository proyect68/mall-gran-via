-- Assignations for products to subcategorias

-- Get product counts before assignment
SELECT COUNT(*) as total_products, 
       COUNT(CASE WHEN subcategoria_id IS NULL THEN 1 END) as unassigned 
FROM products;

-- Moda y accesorios
UPDATE products 
SET subcategoria_id = (SELECT id FROM subcategorias WHERE nombre = 'Ropa casual' LIMIT 1)
WHERE category_id = (SELECT id FROM categories WHERE name = 'Moda y accesorios' LIMIT 1)
AND (LOWER(name) LIKE '%ropa casual%' OR LOWER(name) LIKE '%ropa deportiva%')
AND subcategoria_id IS NULL;

-- Tecnologia y electronica - Celulares
UPDATE products 
SET subcategoria_id = (SELECT id FROM subcategorias WHERE nombre = 'Celulares' LIMIT 1)
WHERE category_id = (SELECT id FROM categories WHERE name = 'Tecnologia y electronica' LIMIT 1)
AND (LOWER(name) LIKE '%celular%' OR LOWER(name) LIKE '%smartphone%' OR LOWER(name) LIKE '%telefono%' OR LOWER(name) LIKE '%iphone%')
AND subcategoria_id IS NULL;

-- Tecnologia y electronica - Tablets
UPDATE products 
SET subcategoria_id = (SELECT id FROM subcategorias WHERE nombre = 'Tablets' LIMIT 1)
WHERE category_id = (SELECT id FROM categories WHERE name = 'Tecnologia y electronica' LIMIT 1)
AND (LOWER(name) LIKE '%tablet%' OR LOWER(name) LIKE '%ipad%')
AND subcategoria_id IS NULL;

-- Tecnologia y electronica - Laptops
UPDATE products 
SET subcategoria_id = (SELECT id FROM subcategorias WHERE nombre = 'Laptops' LIMIT 1)
WHERE category_id = (SELECT id FROM categories WHERE name = 'Tecnologia y electronica' LIMIT 1)
AND (LOWER(name) LIKE '%laptop%' OR LOWER(name) LIKE '%computadora%' OR LOWER(name) LIKE '%notebook%')
AND subcategoria_id IS NULL;

-- Tecnologia y electronica - Gaming
UPDATE products 
SET subcategoria_id = (SELECT id FROM subcategorias WHERE nombre = 'Gaming' LIMIT 1)
WHERE category_id = (SELECT id FROM categories WHERE name = 'Tecnologia y electronica' LIMIT 1)
AND (LOWER(name) LIKE '%gaming%' OR LOWER(name) LIKE '%ps5%' OR LOWER(name) LIKE '%xbox%' OR LOWER(name) LIKE '%switch%' OR LOWER(name) LIKE '%joystick%')
AND subcategoria_id IS NULL;

-- Electrodomesticos - Lavadoras
UPDATE products 
SET subcategoria_id = (SELECT id FROM subcategorias WHERE nombre = 'Lavadoras' LIMIT 1)
WHERE category_id = (SELECT id FROM categories WHERE name = 'Electrodomesticos' LIMIT 1)
AND LOWER(name) LIKE '%lavadora%'
AND subcategoria_id IS NULL;

-- Electrodomesticos - Refrigeradores
UPDATE products 
SET subcategoria_id = (SELECT id FROM subcategorias WHERE nombre = 'Refrigeradores' LIMIT 1)
WHERE category_id = (SELECT id FROM categories WHERE name = 'Electrodomesticos' LIMIT 1)
AND (LOWER(name) LIKE '%refrigerador%' OR LOWER(name) LIKE '%nevera%')
AND subcategoria_id IS NULL;

-- Hogar y decoracion - Muebles
UPDATE products 
SET subcategoria_id = (SELECT id FROM subcategorias WHERE nombre = 'Muebles' LIMIT 1)
WHERE category_id = (SELECT id FROM categories WHERE name = 'Hogar y decoracion' LIMIT 1)
AND (LOWER(name) LIKE '%mueble%' OR LOWER(name) LIKE '%silla%' OR LOWER(name) LIKE '%mesa%' OR LOWER(name) LIKE '%cama%' OR LOWER(name) LIKE '%sofa%')
AND subcategoria_id IS NULL;

-- Belleza y cuidado personal - Maquillaje
UPDATE products 
SET subcategoria_id = (SELECT id FROM subcategorias WHERE nombre = 'Maquillaje' LIMIT 1)
WHERE category_id = (SELECT id FROM categories WHERE name = 'Belleza y cuidado personal' LIMIT 1)
AND (LOWER(name) LIKE '%maquillaje%' OR LOWER(name) LIKE '%lipstick%' OR LOWER(name) LIKE '%rimmel%')
AND subcategoria_id IS NULL;

-- Belleza y cuidado personal - Perfumes
UPDATE products 
SET subcategoria_id = (SELECT id FROM subcategorias WHERE nombre = 'Perfumes' LIMIT 1)
WHERE category_id = (SELECT id FROM categories WHERE name = 'Belleza y cuidado personal' LIMIT 1)
AND (LOWER(name) LIKE '%perfume%' OR LOWER(name) LIKE '%colonia%' OR LOWER(name) LIKE '%fragancia%')
AND subcategoria_id IS NULL;

-- Comida y restaurantes - Comida rapida
UPDATE products 
SET subcategoria_id = (SELECT id FROM subcategorias WHERE nombre = 'Comida rapida' LIMIT 1)
WHERE category_id = (SELECT id FROM categories WHERE name = 'Comida y restaurantes' LIMIT 1)
AND (LOWER(name) LIKE '%hamburguesa%' OR LOWER(name) LIKE '%pizza%' OR LOWER(name) LIKE '%papas fritas%' OR LOWER(name) LIKE '%pollo%')
AND subcategoria_id IS NULL;

-- Comida y restaurantes - Restaurantes
UPDATE products 
SET subcategoria_id = (SELECT id FROM subcategorias WHERE nombre = 'Restaurantes' LIMIT 1)
WHERE category_id = (SELECT id FROM categories WHERE name = 'Comida y restaurantes' LIMIT 1)
AND (LOWER(name) LIKE '%plato%' OR LOWER(name) LIKE '%ensalada%' OR LOWER(name) LIKE '%carne%' OR LOWER(name) LIKE '%pescado%')
AND subcategoria_id IS NULL;

-- Servicios - Gimnasios
UPDATE products 
SET subcategoria_id = (SELECT id FROM subcategorias WHERE nombre = 'Gimnasios' LIMIT 1)
WHERE category_id = (SELECT id FROM categories WHERE name = 'Servicios' LIMIT 1)
AND (LOWER(name) LIKE '%gimnasio%' OR LOWER(name) LIKE '%gym%' OR LOWER(name) LIKE '%entrenamiento%')
AND subcategoria_id IS NULL;

-- Assign remaining products to first subcategory of their category
UPDATE products p
SET subcategoria_id = (
    SELECT id FROM subcategorias 
    WHERE categoria_id = (SELECT id FROM categories WHERE id = p.category_id)
    LIMIT 1
)
WHERE p.category_id IS NOT NULL
AND p.subcategoria_id IS NULL;

-- Verify results
SELECT 
    c.name as categoria,
    sc.nombre as subcategoria,
    COUNT(p.id) as total_productos
FROM products p
JOIN categories c ON p.category_id = c.id
JOIN subcategorias sc ON p.subcategoria_id = sc.id
GROUP BY c.name, sc.nombre
ORDER BY c.name, sc.nombre;
