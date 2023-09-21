USE scandiweb_products;

INSERT INTO products (sku, name, price, description_id)
VALUES ('SKU001', 'chair', 10.99, NULL),
       ('SKU002', 'sofa', 20.99, NULL),
       ('SKU003', 'table', 15.49, NULL),
       ('SKU004', 'door', 12.99, NULL),
       ('SKU005', 'Acme DISC', 8.79, NULL),
       ('SKU006', 'Acme DISC', 25.99, NULL),
       ('SKU007', 'Acme DISC', 9.99, NULL),
       ('SKU008', 'Acme DISC', 18.49, NULL),
       ('SKU009', 'War and Peace', 14.99, NULL),
       ('SKU010', 'War and Peace', 11.29, NULL),
       ('SKU011', 'War and Peace', 14.99, NULL),
       ('SKU012', 'War and Peace', 14.99, NULL);

INSERT INTO product_attributes (product_id, attribute, value)
VALUES (1, 'Dimension', '24x45x15'),
       (2, 'Dimension', '24x45x15'),
       (3, 'Dimension', '24x45x15'),
       (4, 'Dimension', '24x45x15'),
       (5, 'Size', '700MB'),
       (6, 'Size', '700MB'),
       (7, 'Size', '700MB'),
       (8, 'Size', '700MB'),
       (9, 'Weight', '2KG'),
       (10, 'Weight', '2KG'),
       (11, 'Weight', '2KG'),
       (12, 'Weight', '2KG');

UPDATE products
SET description_id = (
    SELECT id
    FROM product_attributes
    WHERE product_attributes.product_id = products.id
);