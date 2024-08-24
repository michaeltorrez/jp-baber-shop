
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



-- servicio
CREATE TABLE servicio (
	id_servicio INT AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(255) NOT NULL,
	descripcion TEXT,
	precio DECIMAL(10, 2) NOT NULL,
	imagen VARCHAR(255),
	estado INT(1) NOT NULL
);


-- categoria
CREATE TABLE categoria (
	id_categoria INT AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(255) NOT NULL,
	descripcion TEXT,
	estado INT(1) NOT NULL
);

-- producto
CREATE TABLE producto (
	id_producto INT AUTO_INCREMENT PRIMARY KEY,
	id_categoria INT NOT NULL,
	nombre VARCHAR(255) NOT NULL,
	descripcion TEXT,
	marca VARCHAR(50),
	precio DECIMAL(10, 2) NOT NULL,
	stock INT NOT NULL,
	imagen VARCHAR(255),
	estado INT(1) NOT NULL,
	FOREIGN KEY fk_id_categoria(id_categoria) REFERENCES categoria(id_categoria)
);


-- cliente
CREATE TABLE cliente (
	id_cliente INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nombres VARCHAR(50) NOT NULL,
	apellidos VARCHAR(50) NOT NULL,
	correo VARCHAR(70) NOT NULL UNIQUE,
	direccion TEXT,
	telefono varchar(20) DEFAULT NULL,
	estado INT(1) NOT NULL
);


-- venta
CREATE TABLE venta (
	id_venta INT AUTO_INCREMENT PRIMARY KEY,
	id_usuario INT(10),
	id_cliente INT(10),
	fecha_hora DATETIME NOT NULL,
	total_venta DECIMAL(10, 2) NOT NULL,
	estado INT(1) NOT NULL,
	FOREIGN KEY fk_id_usuario_venta(id_usuario) REFERENCES usuario(id_usuario),
	FOREIGN KEY fk_id_cliente(id_cliente) REFERENCES cliente(id_cliente)
);

-- detalle_venta
CREATE TABLE detalle_venta_producto (
	id_detalle_venta_producto INT AUTO_INCREMENT PRIMARY KEY,
	id_venta INT,
	id_producto INT,
	cantidad INT,
	subtotal DECIMAL(10, 2),
	estado INT(1),
	FOREIGN KEY fk_id_venta(id_venta) REFERENCES venta(id_venta),
	FOREIGN KEY fk_id_producto(id_producto) REFERENCES producto(id_producto)
)


CREATE TABLE detalle_venta_servicio (
	id_detalle_venta_servicio INT AUTO_INCREMENT PRIMARY KEY,
	id_venta INT,
	id_servicio INT,
	cantidad INT,
	subtotal DECIMAL(10, 2),
	estado INT(1),
	FOREIGN KEY fk_id_venta_ds(id_venta) REFERENCES venta(id_venta),
	FOREIGN KEY fk_id_servicio(id_servicio) REFERENCES servicio(id_servicio)
)



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
	SELECT * FROM usuario WHERE estado = 1;
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


DELIMITER $$
DROP PROCEDURE IF EXISTS ExisteUsuarioRol $$
CREATE PROCEDURE ExisteUsuarioRol (
	IN _id_usuario INT,
	IN _id_rol INT,
	OUT p_existe BOOLEAN
)
BEGIN
	SELECT COUNT(*) > 0 INTO p_existe
	FROM usuario_rol
	WHERE id_usuario = _id_usuario AND id_rol = _id_rol;
END
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
CREATE PROCEDURE ListarRolesDisponibles(IN _id_usuario int(10),IN _id_rol int(10))
BEGIN
	SELECT id_rol, descripcion
	FROM rol
	WHERE id_rol NOT IN (
			SELECT id_rol
			FROM usuario_rol
			WHERE id_usuario = _id_usuario AND id_rol = _id_rol AND estado = 1
	) AND estado = 1;
END;
$$

DELIMITER $$
DROP PROCEDURE IF EXISTS ListarRolesDisponibles $$
CREATE PROCEDURE ListarRolesDisponibles(IN _id_usuario int(10))
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



-- ======================================== SERVICIOS ========================================
-- crear servicio
DELIMITER $$
DROP PROCEDURE IF EXISTS AgregarServicio $$
CREATE PROCEDURE AgregarServicio(
	IN _nombre VARCHAR(255),
	IN _descripcion TEXT,
	IN _precio DECIMAL(10, 2),
	IN _imagen VARCHAR(255),
	OUT _id INT
)
BEGIN
	INSERT INTO servicio (nombre, descripcion, precio, imagen, estado)
  VALUES (_nombre, _descripcion, _precio, _imagen, 1);
	SET _id = LAST_INSERT_ID();
END;
$$



-- listar servicios
DELIMITER $$
DROP PROCEDURE IF EXISTS ListarServicios $$
CREATE PROCEDURE ListarServicios()
BEGIN
	SELECT * FROM servicio WHERE estado = 1;
END;
$$

-- eliminar servicio
DELIMITER $$
DROP PROCEDURE IF EXISTS EliminarServicio $$
CREATE PROCEDURE EliminarServicio(IN _id_servicio INT)
BEGIN
	UPDATE servicio SET estado = 0 WHERE id_servicio = _id_servicio;
END;
$$


-- obtener servicio por id
DELIMITER $$
DROP PROCEDURE IF EXISTS ObtenerServicioPorId $$
CREATE PROCEDURE ObtenerServicioPorId(IN _id_servicio int)
BEGIN
	SELECT * FROM servicio WHERE id_servicio = _id_servicio AND estado = 1;
END;
$$

-- actualizar servicio
DELIMITER $$
DROP PROCEDURE IF EXISTS ActualizarServicio $$
CREATE PROCEDURE ActualizarServicio(
	IN _id_servicio int,
	IN _nombre varchar(255),
	IN _descripcion TEXT,
	IN _precio DECIMAL
)
BEGIN
	UPDATE servicio
	SET nombre = _nombre, descripcion = _descripcion, precio = _precio
	WHERE id_servicio = _id_servicio;
END;
$$



-- ======================================== CATEGORIAS ========================================

-- listar categorias
DELIMITER $$
DROP PROCEDURE IF EXISTS ListarCategorias $$
CREATE PROCEDURE ListarCategorias()
BEGIN
	SELECT * FROM categoria WHERE estado = 1;
END;
$$




-- ======================================== PRODUCTOS ========================================
-- crear producto
DELIMITER $$
DROP PROCEDURE IF EXISTS AgregarProducto $$
CREATE PROCEDURE AgregarProducto(
	IN _id_categoria INT(10),
	IN _nombre VARCHAR(255),
	IN _descripcion TEXT,
	IN _marca VARCHAR(50),
	IN _precio DECIMAL(10, 2),
	IN _stock INT,
	IN _imagen VARCHAR(255),
	OUT _id INT
)
BEGIN
	INSERT INTO producto (id_categoria, nombre, descripcion, marca, precio, stock, imagen, estado)
  VALUES (_id_categoria, _nombre, _descripcion, _marca, _precio, _stock, _imagen, 1);
	SET _id = LAST_INSERT_ID();
END;
$$


-- actualizar path de imagen
DELIMITER $$
DROP PROCEDURE IF EXISTS ActualizarImagen $$
CREATE PROCEDURE ActualizarImagen(IN _id_producto INT, IN _imagen VARCHAR(255))
BEGIN
	UPDATE producto SET imagen = _imagen WHERE id_producto = _id_producto;
END;
$$


-- listar productos
DELIMITER $$
DROP PROCEDURE IF EXISTS ListarProductos $$
CREATE PROCEDURE ListarProductos()
BEGIN
	SELECT * FROM producto WHERE estado = 1;
END;
$$

-- eliminar producto
DELIMITER $$
DROP PROCEDURE IF EXISTS EliminarProducto $$
CREATE PROCEDURE EliminarProducto(IN _id_producto INT)
BEGIN
	UPDATE producto SET estado = 0 WHERE id_producto = _id_producto;
END;
$$


-- obtener producto por id
DELIMITER $$
DROP PROCEDURE IF EXISTS ObtenerProductoPorId $$
CREATE PROCEDURE ObtenerProductoPorId(IN _id_producto int)
BEGIN
	SELECT * FROM producto WHERE id_producto = _id_producto AND estado = 1;
END;
$$


-- actualizar producto
DELIMITER $$
DROP PROCEDURE IF EXISTS ActualizarProducto $$
CREATE PROCEDURE ActualizarProducto(
	IN _id_producto int,
	IN _nombre varchar(255),
	IN _descripcion TEXT,
	IN _marca varchar(50),
	IN _precio DECIMAL,
	IN _stock INT
)
BEGIN
	UPDATE producto
	SET nombre = _nombre, descripcion = _descripcion, marca = _marca, precio = _precio, stock = _stock
	WHERE id_producto = _id_producto;
END;
$$


-- ======================================== CLIENTE ========================================
-- crear cliente
DELIMITER $$
DROP PROCEDURE IF EXISTS AgregarCliente $$
CREATE PROCEDURE AgregarCliente(
	IN _nombres VARCHAR(50),
	IN _apellidos VARCHAR(50),
	IN _correo VARCHAR(70),
	IN _direccion TEXT,
	IN _telefono VARCHAR(20)
)
BEGIN
	INSERT INTO cliente (nombres, apellidos, correo, direccion, telefono, estado)
  VALUES (_nombres, _apellidos, _correo, _direccion, _telefono, 1);
END;
$$


-- listar clientes
DELIMITER $$
DROP PROCEDURE IF EXISTS ListarClientes $$
CREATE PROCEDURE ListarClientes()
BEGIN
	SELECT * FROM cliente WHERE estado = 1;
END;
$$

-- eliminar cliente
DELIMITER $$
DROP PROCEDURE IF EXISTS EliminarCliente $$
CREATE PROCEDURE EliminarCliente(IN _id_cliente INT)
BEGIN
	UPDATE cliente SET estado = 0 WHERE id_cliente = _id_cliente;
END;
$$


-- obtener cliente por id
DELIMITER $$
DROP PROCEDURE IF EXISTS ObtenerClientePorId $$
CREATE PROCEDURE ObtenerClientePorId(IN _id_cliente int)
BEGIN
	SELECT * FROM cliente WHERE id_cliente = _id_cliente AND estado = 1;
END;
$$


-- actualizar producto
DELIMITER $$
DROP PROCEDURE IF EXISTS ActualizarCliente $$
CREATE PROCEDURE ActualizarCliente(
	IN _id_cliente INT(10),
	IN _nombres VARCHAR(50),
	IN _apellidos VARCHAR(50),
	IN _correo VARCHAR(70),
	IN _direccion TEXT,
	IN _telefono VARCHAR(20)
)
BEGIN
	UPDATE cliente
	SET nombres = _nombres, apellidos = _apellidos, correo = _correo, direccion = _direccion, telefono = _telefono
	WHERE id_cliente = _id_cliente;
END;
$$


-- ======================================== VENTA ========================================
-- obtener nro de venta
DELIMITER $$
DROP PROCEDURE IF EXISTS ObtenerCantidadVentas $$
CREATE PROCEDURE ObtenerCantidadVentas()
BEGIN
	SELECT COUNT(*) FROM venta WHERE estado = 1;
END;
$$


-- registrarr venta
DELIMITER $$
DROP PROCEDURE IF EXISTS RegistrarVenta $$
CREATE PROCEDURE RegistrarVenta(
	IN _id_usuario INT,
	IN _id_cliente INT,
	IN _total_venta DECIMAL(10,2),
	OUT _id INT
)
BEGIN
	INSERT INTO venta (id_usuario, id_cliente, fecha_hora, total_venta, estado)
	VALUES (_id_usuario, _id_cliente, NOW(), _total_venta, 1);

	SET _id = LAST_INSERT_ID();
END $$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS AgregarDetalleVentaProducto $$
CREATE PROCEDURE AgregarDetalleVentaProducto(
	IN p_id_venta INT,
	IN p_id_producto INT,
	IN p_cantidad INT,
	IN p_subtotal DECIMAL(10,2)
)
BEGIN
	INSERT INTO detalle_venta_producto (id_venta, id_producto, cantidad, subtotal, estado)
	VALUES (p_id_venta, p_id_producto, p_cantidad, p_subtotal, 1);
END $$
DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS AgregarDetalleVentaServicio $$
CREATE PROCEDURE AgregarDetalleVentaServicio(
	IN _id_venta INT,
	IN _id_servicio INT,
	IN _cantidad INT,
	IN _subtotal DECIMAL(10,2)
)
BEGIN
	INSERT INTO detalle_venta_servicio (id_venta, id_producto, cantidad, subtotal, estado)
	VALUES (_id_venta, _id_servicio, _cantidad, _subtotal, 1);
END $$
DELIMITER ;



DELIMITER //
CREATE TRIGGER actualizar_stock AFTER INSERT ON detalle_venta_producto
FOR EACH ROW
BEGIN
    -- Restar la cantidad vendida del stock del producto correspondiente
    UPDATE producto
    SET stock = stock - NEW.cantidad
    WHERE id_producto = NEW.id_producto;
END //
DELIMITER ;


-- listar ventas
DELIMITER $$
DROP PROCEDURE IF EXISTS ListarVentas $$
CREATE PROCEDURE ListarVentas()
BEGIN
	SELECT v.id_venta, v.fecha_hora, v.total_venta, CONCAT(c.nombres, ' ', c.apellidos) as cliente, u.usuario
	FROM venta v
	INNER JOIN cliente c ON v.id_cliente = c.id_cliente
	INNER JOIN usuario u ON v.id_usuario = u.id_usuario
	WHERE v.estado = 1;
END;
$$