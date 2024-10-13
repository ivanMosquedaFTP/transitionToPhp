CREATE TABLE permiso(
    id_permiso INT AUTO_INCREMENT PRIMARY KEY, 
    permiso VARCHAR(30) NOT NULL
);

CREATE TABLE rol(
    id_rol INT AUTO_INCREMENT PRIMARY KEY, 
    rol VARCHAR(30) NOT NULL
);

CREATE TABLE rol_permiso(
    id_rol INT NOT NULL, 
    id_permiso INT NOT NULL, 
    PRIMARY KEY (id_rol, id_permiso), 
    FOREIGN KEY (id_rol) REFERENCES rol(id_rol), 
    FOREIGN KEY (id_permiso) REFERENCES permiso(id_permiso)
);

CREATE TABLE usuario_rol(
    id_usuario INT NOT NULL, 
    id_rol INT NOT NULL, 
    PRIMARY KEY (id_usuario, id_rol), 
    FOREIGN KEY (id_usuario) REFERENCES usuario(id), 
    FOREIGN KEY (id_rol) REFERENCES rol(id_rol)
);