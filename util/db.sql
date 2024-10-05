CREATE TABLE usuario (
    id serial PRIMARY KEY,
    nombre_completo VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    contrasena VARCHAR(30),
    email VARCHAR(100) NOT NULL UNIQUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_compras INT DEFAULT 0
);

-- Tabla para los productos
CREATE TABLE producto (
    id serial PRIMARY KEY,
    nombre_producto VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla para registrar las ventas
CREATE TABLE venta (
    id serial PRIMARY KEY,
    usuario_id INT,
    producto_id INT,
    cantidad INT NOT NULL,
    fecha_venta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id),
    FOREIGN KEY (producto_id) REFERENCES producto(id)
);

-- Tabla para gestionar las recompensas
CREATE TABLE recompensa (
    id serial PRIMARY KEY,
    usuario_id INT,
    descripcion VARCHAR(255),
    fecha_otorgada TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id)
);

-- Tabla para manejar el historial de stock (reservas y ventas)
CREATE TABLE stock_reserva (
    id serial PRIMARY KEY,
    producto_id INT,
    usuario_id INT,
    cantidad INT NOT NULL,
    estado boolean NOT NULL, --falso es apartado, verdadero es vendido
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (producto_id) REFERENCES producto(id),
    FOREIGN KEY (usuario_id) REFERENCES usuario(id)
);

-- Tabla para los administradores/publicación de productos
CREATE TABLE administrador (
    id serial PRIMARY KEY,
    nombre VARCHAR(100),
    contrasena VARCHAR(255) NOT NULL
);

--agregando la seguridad

-- Crear esquemas para usuario y administrador
CREATE SCHEMA ecommerce_admin;
CREATE SCHEMA ecommerce_usuario;

-- Mover las tablas a sus respectivos esquemas
ALTER TABLE usuario SET SCHEMA ecommerce_usuario;
ALTER TABLE producto SET SCHEMA ecommerce_admin;
ALTER TABLE venta SET SCHEMA ecommerce_admin;
ALTER TABLE recompensa SET SCHEMA ecommerce_admin;
ALTER TABLE stock_reserva SET SCHEMA ecommerce_admin;
ALTER TABLE administrador SET SCHEMA ecommerce_admin;

-- Crear roles
CREATE ROLE rol_admin;
CREATE ROLE rol_usuario;

-- Otorgar permisos a los roles
-- Administrador: acceso completo a ecommerce_admin
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA ecommerce_admin TO rol_admin;
GRANT USAGE, SELECT ON ALL SEQUENCES IN SCHEMA ecommerce_admin TO rol_admin;

-- Usuario: acceso limitado a ecommerce_usuario
GRANT USAGE ON SCHEMA ecommerce_usuario TO rol_usuario;
GRANT SELECT ON ALL TABLES IN SCHEMA ecommerce_usuario TO rol_usuario;

-- Crear vistas para restringir el acceso a los datos de usuarios
-- Vista para que el usuario solo vea su propio perfil
CREATE VIEW ecommerce_usuario.vista_usuario_perfil AS
SELECT id, nombre_completo, telefono, email, fecha_registro, total_compras
FROM ecommerce_usuario.usuario;

-- Vista para que el usuario solo vea sus compras
CREATE VIEW ecommerce_usuario.vista_usuario_compras AS
SELECT venta.id AS id_venta, producto.nombre_producto, venta.cantidad, venta.fecha_venta
FROM ecommerce_admin.venta
JOIN ecommerce_admin.producto ON venta.producto_id = producto.id
WHERE venta.usuario_id = (SELECT id FROM ecommerce_usuario.usuario WHERE email = current_user);

-- Otorgar permisos sobre las vistas
GRANT SELECT ON ecommerce_usuario.vista_usuario_perfil TO rol_usuario;
GRANT SELECT ON ecommerce_usuario.vista_usuario_compras TO rol_usuario;

-- Crear usuarios de base de datos y asignar roles
CREATE USER cliente_ecommerce WITH PASSWORD 'password_cliente';

-- Asignar roles
GRANT rol_admin TO admin_ecommerce;
GRANT rol_usuario TO cliente_ecommerce;

-- Revocar permisos innecesarios para mayor seguridad
REVOKE ALL PRIVILEGES ON SCHEMA ecommerce_usuario FROM rol_admin;
