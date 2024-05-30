
-- TABLAS

-- usarios
CREATE TABLE db_jp_barber_shop.usuario (
	id_usuario INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nombres VARCHAR(50) NOT NULL,
	apellidos VARCHAR(50) NOT NULL,
	correo VARCHAR(70) NOT NULL UNIQUE,
	usuario VARCHAR(30) NOT NULL UNIQUE,
	contrasena VARCHAR(100) NOT NULL,
	estado INT(1) NOT NULL
);

-- roles
CREATE TABLE db_jp_barber_shop.rol (
	id_rol INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	descripcion VARCHAR(50) NOT NULL,
	estado INT(1) NOT NULL
);


-- asignar_rol
CREATE TABLE db_jp_barber_shop.usuario_rol (
	id_usuario_rol INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	id_usuario INT(10),
	id_rol INT(10),
	fecha_asignacion DATE,
	estado INT(1) NOT NULL,
	FOREIGN KEY fk_id_usuario(id_usuario) REFERENCES usuario(id_usuario),
	FOREIGN KEY fk_id_rol(id_rol) REFERENCES rol(id_rol)
);



-- PROCEDIMIENTOS ALMACENADOS

-- ======================================== USUARIOS ========================================
-- crear usuario
DELIMITER $$
CREATE PROCEDURE CrearUsuario(in _nombres varchar(50), in _apellidos varchar(50), in _correo varchar(50), in _usuario varchar(30), in _contrasena varchar(100))
BEGIN
	INSERT INTO usuario (nombres, apellidos, correo, usuario, contrasena, estado)
	VALUES (_nombres, _apellidos, _correo, _usuario, _contrasena, 1);
END;
$$


-- listar usuarios
DELIMITER $$
CREATE PROCEDURE ListarUsuarios()
BEGIN
	SELECT * FROM usuario WHERE usuario.estado = 1;
END;
$$


-- obtener usuario por nombre de usuario
DELIMITER $$
CREATE PROCEDURE ObtenerUsuario(IN _usuario varchar(30))
BEGIN
	SELECT id_usuario, nombres, apellidos, usuario, contrasena
	FROM usuario WHERE usuario = _usuario;
END;
$$


-- eliminar usuario
DELIMITER $$
CREATE PROCEDURE EliminarUsuario(in _id_usuario int(10))
BEGIN
	UPDATE usuario SET estado = 0 WHERE usuarios.id_usuario = _id_usuario;
END;
$$


-- obtener usuario por id
DELIMITER $$
CREATE PROCEDURE ObtenerUsuarioPorId(IN _id_usuario int)
BEGIN
	SELECT * FROM usuario WHERE usuario.id_usuario = _id_usuario AND usuario.estado = 1;
END;
$$


-- actualizar usuario
DELIMITER $$
CREATE PROCEDURE ActualizarUsuario(IN _id_usuario int, IN _nombres varchar(70), IN _apellidos varchar(70), IN _correo varchar(50), IN _usuario varchar(30), IN _contrasena varchar(100))
BEGIN
	UPDATE usuario u
	SET u.nombres = _nombres, u.apellidos = _apellidos, u.correo = _correo, u.usuario = _usuario, u.contrasena = _contrasena
	WHERE u.id_usuario = _id_usuario;
END;
$$


-- actualizar usuario sin contraseña
DELIMITER $$
CREATE PROCEDURE ActualizarUsuarioSinContrasena(IN _id_usuario int, IN _nombres varchar(70), IN _apellidos varchar(70), IN _correo varchar(50), IN _usuario varchar(30))
BEGIN
	UPDATE usuario u
	SET u.nombres = _nombres, u.apellidos = _apellidos, u.correo = _correo, u.usuario = _usuario
	WHERE u.id_usuario = _id_usuario;
END;
$$


-- Verificar si correo ya esta registrado en la base de datos
DELIMITER $$
CREATE PROCEDURE ExisteEmail(IN _correo varchar(70))
BEGIN
	SELECT * FROM usuario WHERE usuario.correo = _correo;
END;
$$


-- Verificar si nombre_usuario ya esta registrado en la base de datos
DELIMITER $$
CREATE PROCEDURE ExisteUsuario(IN _usuario varchar(30))
BEGIN
	SELECT * FROM usuario WHERE usuario.nombre_usuario = _usuario;
END;
$$

-- ======================================== ROLES ========================================
-- crear rol
DELIMITER $$
CREATE PROCEDURE CrearRol(in _descripcion varchar(50))
BEGIN
	INSERT INTO roles (descripcion, estado)
	VALUES (_descripcion, 1);
END;
$$

-- Verificar si el rol ya existe en la base de datos
DELIMITER $$
CREATE PROCEDURE ExisteRol(IN _descripcion varchar(50))
BEGIN
	SELECT * FROM roles WHERE roles.descripcion = _descripcion;
END;
$$

-- listar roles
DELIMITER $$
CREATE PROCEDURE ListarRoles()
BEGIN
	SELECT * FROM roles WHERE roles.estado = 1;
END;
$$

-- obtener rol por id
DELIMITER $$
CREATE PROCEDURE ObtenerRol(IN _id int)
BEGIN
	SELECT * FROM roles WHERE roles.id = _id;
END;
$$


-- actualizar rol
DELIMITER $$
CREATE PROCEDURE ActualizarRol(IN _id int, IN _descripcion varchar(50))
BEGIN
	UPDATE roles
	SET roles.descripcion = _descripcion
	WHERE roles.id = _id;
END;
$$

-- eliminar rol
DELIMITER $$
CREATE PROCEDURE EliminarRol(in _id int(10))
BEGIN
	UPDATE roles SET estado = 0 WHERE roles.id = _id;
END;
$$

-- ======================================== ASIGNAR ========================================
-- crear asignación
DELIMITER $$
CREATE PROCEDURE CrearAsignacion(IN _id_usuario INT(10), IN _id_rol INT(10))
BEGIN
	INSERT INTO asignar_rol (id_usuario, id_rol, fecha_asignacion, estado)
	VALUES (_id_usuario, _id_rol, NOW(), 1);
END;
$$


-- listar asignación
DELIMITER $$
CREATE PROCEDURE ListarAsignaciones()
BEGIN
	SELECT a.*, u.nombre_usuario, r.descripcion FROM asignar_rol a
	INNER JOIN usuarios u ON a.id_usuario = u.id
	INNER JOIN roles r ON a.id_rol = r.id
	WHERE a.estado = 1;
END;
$$
--listar modificado acomodado para no modificar tanto el codigo
DELIMITER $$
DROP PROCEDURE IF EXISTS ListarAsignaciones $$
CREATE PROCEDURE ListarAsignaciones()
BEGIN
	SELECT u.id AS id_usuario, u.nombres_apellidos, u.nombre_usuario , a.id, a.fecha_asignacion, r.id AS id_rol, r.descripcion
	FROM usuarios u
	LEFT JOIN asignar_rol a ON u.id = a.id_usuario
	LEFT JOIN roles r ON a.id_rol = r.id
	WHERE u.estado = 1;
END;
$$


-- eliminar asignación
DELIMITER $$
CREATE PROCEDURE EliminarAsignacion(in _id int(10))
BEGIN
	UPDATE asignar_rol SET estado = 0 WHERE asignar_rol.id = _id;
END;
$$