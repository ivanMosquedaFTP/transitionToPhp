CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    contrasena VARCHAR(50),
    email VARCHAR(100) NOT NULL UNIQUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_compras INT DEFAULT 0
);

-- Tabla para los productos
CREATE TABLE producto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_producto VARCHAR(100) NOT NULL,
    foto VARCHAR(255),
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla para registrar las ventas
CREATE TABLE venta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    producto_id INT,
    cantidad INT NOT NULL,
    monto double,
    fecha_venta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id),
    FOREIGN KEY (producto_id) REFERENCES producto(id)
);

-- Tabla para gestionar las recompensas
CREATE TABLE recompensa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    descripcion VARCHAR(255),
    fecha_otorgada TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id)
);

-- Tabla para manejar el historial de stock (reservas y ventas)
CREATE TABLE stock_reserva (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT,
    usuario_id INT,
    cantidad INT NOT NULL,
    estado BOOLEAN NOT NULL, -- 0 es apartado, 1 es vendido
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (producto_id) REFERENCES producto(id),
    FOREIGN KEY (usuario_id) REFERENCES usuario(id)
);

-- Tabla para los administradores/publicación de productos
CREATE TABLE administrador (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    contrasena VARCHAR(255) NOT NULL
);

-- ----------------------------------------------------------------------
-- EXECUTE UNTIL THE END OF THE PROJECT TO MANAGE SECURITY, NOT FOR NOW
-- ----------------------------------------------------------------------
CREATE USER 'cliente_coolHats'@'localhost' IDENTIFIED BY 'clienteCoolHats';

-- Otorgar permisos a los roles
GRANT SELECT, INSERT, UPDATE, DELETE ON `usuario` TO 'cliente_coolHats'@'localhost';
GRANT SELECT ON `venta` TO 'cliente_coolHats'@'localhost';
GRANT SELECT ON `producto` TO 'cliente_coolHats'@'localhost';

-- Crear vistas para restringir el acceso a los datos de usuarios
CREATE VIEW vista_usuario_perfil AS
SELECT id, nombre_completo, telefono, email, fecha_registro, total_compras
FROM usuario;

-- Vista para que el usuario solo vea sus compras
CREATE VIEW vista_usuario_compras AS
SELECT venta.id AS id_venta, producto.nombre_producto, venta.cantidad, venta.fecha_venta
FROM venta
JOIN producto ON venta.producto_id = producto.id
WHERE venta.usuario_id = (SELECT id FROM usuario WHERE email = USER());

-- Otorgar permisos sobre las vistas
GRANT SELECT ON vista_usuario_perfil TO 'cliente_coolHats'@'localhost';
GRANT SELECT ON vista_usuario_compras TO 'cliente_coolHats'@'localhost';

-- Revocar permisos innecesarios para mayor seguridad
REVOKE ALL PRIVILEGES ON `usuario` FROM 'admin_coolHats'@'localhost';