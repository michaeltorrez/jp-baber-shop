
-- TABLAS

-- usarios
CREATE TABLE usuario (
	id_usuario INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nombres VARCHAR(50) NOT NULL,
	apellidos VARCHAR(50) NOT NULL,
	correo VARCHAR(70) NOT NULL UNIQUE,
	usuario VARCHAR(30) NOT NULL UNIQUE,
	contrasena VARCHAR(100) NOT NULL,
	estado INT(1) NOT NULL
);

-- roles
CREATE TABLE rol (
	id_rol INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	descripcion VARCHAR(50) NOT NULL UNIQUE,
	estado INT(1) NOT NULL
);


-- asignar_rol
CREATE TABLE usuario_rol (
	id_usuario INT(10),
	id_rol INT(10),
	fecha_asignacion DATETIME,
	estado INT(1) NOT NULL,
	PRIMARY KEY (id_usuario, id_rol),
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
DROP PROCEDURE IF EXISTS ListarUsuarios $$
CREATE PROCEDURE ListarUsuarios()
BEGIN
	SELECT * FROM usuario WHERE usuario.estado = 1;
END;
$$

-- listar usuarios 2
DELIMITER $$
DROP PROCEDURE IF EXISTS ListarUsuarios2 $$
CREATE PROCEDURE ListarUsuarios2()
BEGIN
	SELECT id_usuario, usuario FROM usuario WHERE usuario.estado = 1;
END;
$$


-- obtener usuario por nombre de usuario
DELIMITER $$
CREATE PROCEDURE ObtenerUsuario(IN _usuario varchar(30))
BEGIN
	SELECT id_usuario, nombres, apellidos, usuario, contrasena
	FROM usuario
	WHERE usuario = _usuario AND estado = 1;
END;
$$

-- obtener roles de usuario
DELIMITER $$
CREATE PROCEDURE ObtenerRolesDeUsuario(IN _id_usuario varchar(30))
BEGIN
	SELECT r.descripcion
	FROM usuario_rol ur
	INNER JOIN usuario u ON u.id_usuario = ur.id_usuario
	INNER JOIN rol r ON r.id_rol = ur.id_rol
	WHERE u.usuario = _id_usuario AND u.estado = 1;
END;
$$


-- eliminar usuario
DELIMITER $$
CREATE PROCEDURE EliminarUsuario(in _id_usuario int(10))
BEGIN
	UPDATE usuario SET estado = 0 WHERE id_usuario = _id_usuario;
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
	INSERT INTO rol (descripcion, estado)
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
	SELECT * FROM rol WHERE estado = 1;
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
CREATE PROCEDURE EliminarRol(in _id_rol int(10))
BEGIN
	UPDATE rol SET estado = 0 WHERE id_rol = _id_rol;
END;
$$

-- ======================================== USUARIO ROL ========================================
-- asignar usuario-rol
DELIMITER $$
DROP PROCEDURE IF EXISTS AsignarUsuarioRol $$
CREATE PROCEDURE AsignarUsuarioRol(IN _id_usuario INT(10), IN _id_rol INT(10))
BEGIN
	INSERT INTO usuario_rol (id_usuario, id_rol, fecha_asignacion, estado)
	VALUES (_id_usuario, _id_rol, NOW(), 1);
END;
$$


-- listar usuario-rol
DELIMITER $$
DROP PROCEDURE IF EXISTS ListarUsuarioRol $$
CREATE PROCEDURE ListarUsuarioRol()
BEGIN
	SELECT ur.id_usuario, ur.id_rol, ur.fecha_asignacion, u.usuario, CONCAT(u.nombres, ' ', u.apellidos) AS nombre_completo, r.descripcion
	FROM usuario u
	INNER JOIN usuario_rol ur ON u.id_usuario = ur.id_usuario
	INNER JOIN rol r ON ur.id_rol = r.id_rol
	WHERE ur.estado = 1;
END;
$$


-- listar roles no asignados a un usuario
DELIMITER $$
DROP PROCEDURE IF EXISTS ListarRolesDisponibles $$
CREATE PROCEDURE ListarRolesDisponibles(IN _id_usuario varchar(30))
BEGIN
	SELECT id_rol, descripcion
	FROM rol
	WHERE id_rol NOT IN (
			SELECT id_rol
			FROM usuario_rol
			WHERE id_usuario = _id_usuario AND estado = 1
	) AND estado = 1;
END;
$$


-- eliminar asignación
DELIMITER $$
DROP PROCEDURE IF EXISTS EliminarAsignacion $$
CREATE PROCEDURE EliminarAsignacion(IN _id_usuario int(10),IN _id_rol int(10))
BEGIN
	UPDATE usuario_rol SET estado = 0 WHERE id_usuario = _id_usuario AND id_rol = _id_rol;
END;
$$