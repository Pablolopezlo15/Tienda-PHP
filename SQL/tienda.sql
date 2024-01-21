CREATE DATABASE tienda;
SET NAMES UTF8;
CREATE DATABASE IF NOT EXISTS tienda;
USE tienda;

DROP TABLE IF EXISTS usuarios;
CREATE TABLE IF NOT EXISTS usuarios(
    id              int(255) auto_increment not null,
    nombre          varchar(100) not null,
    apellidos       varchar(255),
    email           varchar(255) not null,
    password        varchar(255) not null,
    rol             varchar(20),
    CONSTRAINT pk_usuarios PRIMARY KEY(id),
    CONSTRAINT uq_email UNIQUE(email)
    )ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS categorias;
CREATE TABLE IF NOT EXISTS categorias(
    id              int(255) auto_increment not null,
    nombre          varchar(100) not null,
    CONSTRAINT pk_categorias PRIMARY KEY(id)
    )ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS productos;
CREATE TABLE IF NOT EXISTS productos(
    id              int(255) auto_increment not null,
    categoria_id    int(255) not null,
    nombre          varchar(100) not null,
    descripcion     text,
    precio          float(100,2) not null,
    stock           int(255) not null,
    oferta          varchar(2),
    fecha           date not null,
    imagen          varchar(255),
    CONSTRAINT pk_categorias PRIMARY KEY(id),
    CONSTRAINT fk_producto_categoria FOREIGN KEY(categoria_id) REFERENCES categorias(id)
    )ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS pedidos;
CREATE TABLE IF NOT EXISTS pedidos(
    id              int(255) auto_increment not null,
    usuario_id      int(255) not null,
    provincia       varchar(100) not null,
    localidad       varchar(100) not null,
    direccion       varchar(255) not null,
    coste           float(200,2) not null,
    estado          varchar(20) not null,
    fecha           date,
    hora            time,
    CONSTRAINT pk_pedidos PRIMARY KEY(id),
    CONSTRAINT fk_pedido_usuario FOREIGN KEY(usuario_id) REFERENCES usuarios(id)
    )ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS lineas_pedidos;
CREATE TABLE IF NOT EXISTS lineas_pedidos(
    id              int(255) auto_increment not null,
    pedido_id       int(255) not null,
    producto_id     int(255) not null,
    unidades        int(255) not null,
    CONSTRAINT pk_lineas_pedidos PRIMARY KEY(id),
    CONSTRAINT fk_linea_pedido FOREIGN KEY(pedido_id) REFERENCES pedidos(id),
    CONSTRAINT fk_linea_producto FOREIGN KEY(producto_id) REFERENCES productos(id)
    )ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


ALTER TABLE lineas_pedidos
DROP FOREIGN KEY fk_linea_producto,
ADD FOREIGN KEY (producto_id) REFERENCES productos (id) ON DELETE CASCADE;

ALTER TABLE productos
DROP FOREIGN KEY fk_producto_categoria,
ADD FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE;

INSERT INTO categorias (id, nombre) VALUES
(1, 'Hombre'),
(2, 'Mujer'),
(3, 'Niño'),
(4, 'Accesorios');

INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) VALUES
(1, 'Camiseta Nike DryFit', 'Camiseta deportiva con tecnología DryFit para hombre', 39.99, 50, NULL, '2024-01-16', 'nike_camiseta_hombre.jpg'),
(1, 'Pantalones Adidas Climacool', 'Pantalones deportivos con tecnología Climacool para hombre', 59.99, 30, '15%', '2024-01-16', 'adidas_pantalones_hombre.jpg'),
(1, 'Zapatillas Puma Running', 'Zapatillas de running cómodas de la marca Puma para hombre', 79.99, 20, NULL, '2024-01-16', 'puma_zapatillas_hombre.jpg'),
(2, 'Sudadera Nike Tech Fleece', 'Sudadera con tecnología Tech Fleece para mujer', 69.99, 40, NULL, '2024-01-16', 'nike_sudadera_mujer.jpg'),
(2, 'Leggings Adidas Alphaskin', 'Leggings deportivos ajustados de la marca Adidas para mujer', 49.99, 60, NULL, '2024-01-16', 'adidas_leggings_mujer.jpg'),
(2, 'Vestido Puma Urban', 'Vestido urbano de la marca Puma para mujer', 34.99, 25, NULL, '2024-01-16', 'puma_vestido_mujer.jpg'),
(3, 'Conjunto Nike Infantil', 'Conjunto de ropa deportiva Nike para niño', 44.99, 35, NULL, '2024-01-16', 'nike_conjunto_niño.jpg'),
(3, 'Camiseta Reebok Junior', 'Camiseta deportiva para niño de la marca Reebok', 19.99, 45, NULL, '2024-01-16', 'reebok_camiseta_niño.jpg'),
(3, 'Zapatos Adidas Velcro Kids', 'Zapatos con cierre de velcro para niño de la marca Adidas', 29.99, 15, NULL, '2024-01-16', 'adidas_zapatos_niño.jpg'),
(4, 'Gorra Nike Heritage 86', 'Gorra casual Nike Heritage 86', 24.99, 20, NULL, '2024-01-16', 'nike_gorra.jpg'),
(4, 'Mochila Adidas Originals', 'Mochila original de la marca Adidas', 39.99, 30, NULL, '2024-01-16', 'adidas_mochila.jpg'),
(4, 'Bufanda Puma Knit', 'Bufanda de punto de la marca Puma', 14.99, 50, NULL, '2024-01-16', 'puma_bufanda.jpg');
