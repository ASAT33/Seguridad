-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-12-2023 a las 21:34:23
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prestamos1`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_buscar_cliente` (IN `p_search` VARCHAR(255), IN `p_search_field` VARCHAR(255))   BEGIN
    SET @sql_query = CONCAT('SELECT * FROM cliente WHERE ', p_search_field, ' LIKE \'%', p_search, '%\'');
    PREPARE dynamic_query FROM @sql_query;
    EXECUTE dynamic_query;
    DEALLOCATE PREPARE dynamic_query;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_buscar_pago` (IN `p_search_value` VARCHAR(255), IN `p_search_field` VARCHAR(255))   BEGIN
    DECLARE dynamic_query VARCHAR(500);
    SET dynamic_query = CONCAT('SELECT * FROM pagos WHERE ', p_search_field, ' LIKE ?');

    -- Preparar la sentencia SQL dinámica
    PREPARE stmt FROM dynamic_query;

    -- Asignar el valor de búsqueda
    SET @search_value = CONCAT('%', p_search_value, '%');
    
    -- Ejecutar la sentencia SQL con el valor de búsqueda
    EXECUTE stmt USING @search_value;

    -- Liberar la sentencia preparada
    DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_buscar_prestamos` (IN `p_search` VARCHAR(255), IN `p_search_field` VARCHAR(255))   BEGIN
    SET @sql_query = CONCAT('SELECT * FROM prestamo WHERE ', p_search_field, ' LIKE \'%', p_search, '%\'');
    PREPARE dynamic_query FROM @sql_query;
    EXECUTE dynamic_query;
    DEALLOCATE PREPARE dynamic_query;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_clientes` ()   BEGIN
    SELECT * FROM cliente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insertar_pago` (IN `p_cedula_cliente` VARCHAR(255), IN `p_capital` DECIMAL(10,2), IN `p_interes` DECIMAL(5,2))   BEGIN
    DECLARE p_nombre_cliente VARCHAR(255);

    -- Obtener el nombre del cliente
    SELECT nombre INTO p_nombre_cliente FROM cliente WHERE REPLACE(id_cedula, '-', '') = REPLACE(p_cedula_cliente, '-', '');

    -- Insertar en la tabla de pagos
    INSERT INTO pagos (cedula_cliente, nombre_cliente, capital, interes, fecha)
    VALUES (p_cedula_cliente, p_nombre_cliente, p_capital, p_interes, NOW());
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insertar_prestamo` (IN `p_cedula_cliente` VARCHAR(255), IN `p_cantidad_prestada` DECIMAL(10,2), IN `p_interes` DECIMAL(5,2), IN `p_plazo` INT)   BEGIN
    DECLARE p_nombre_cliente VARCHAR(255);
    DECLARE p_int_calculado DECIMAL(10, 2);

    -- Obtener el nombre del cliente
    SELECT nombre INTO p_nombre_cliente FROM cliente WHERE id_cedula = p_cedula_cliente;

    -- Calcular el interés calculado
    SET p_int_calculado = p_cantidad_prestada * (p_interes / 100) * p_plazo;

    -- Insertar en la tabla de préstamos
    INSERT INTO prestamo (id_cedula, nombre_cliente, cantidad_prestada, interes, plazo, int_calculado)
    VALUES (p_cedula_cliente, p_nombre_cliente, p_cantidad_prestada, p_interes, p_plazo, p_int_calculado);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_pagos` ()   BEGIN
    SELECT * FROM pagos;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_prestamos` ()   BEGIN
    SELECT * FROM prestamo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_prestar` (IN `p_id_prestamo` INT, IN `p_nombre_cliente` VARCHAR(255), IN `p_cantidad_prestada` DECIMAL(10,2), IN `p_interes` DECIMAL(5,2), IN `p_plazo` INT)   BEGIN
    DECLARE v_id_cedula INT;

    -- Obtener el id_cedula del cliente
    SELECT id_cedula INTO v_id_cedula FROM cliente WHERE nombre = p_nombre_cliente;

    -- Insertar el préstamo
    INSERT INTO prestamo (id_prestamo, id_cedula, nombre_cliente, cantidad_prestada, interes, plazo, int_calculado)
    VALUES (p_id_prestamo, v_id_cedula, p_nombre_cliente, p_cantidad_prestada, p_interes, p_plazo, (p_cantidad_prestada * p_interes * p_plazo));
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_prueba` (IN `p_cedula_cliente` VARCHAR(255), IN `p_capital` DECIMAL(10,2), IN `p_interes` DECIMAL(5,2))   BEGIN
    DECLARE p_nombre_cliente VARCHAR(255);
    DECLARE p_interes_original DECIMAL(5, 2);
    DECLARE p_cantidad_original DECIMAL(10, 2);
    DECLARE p_nuevo_interes DECIMAL(5, 2);
    DECLARE p_nueva_cantidad DECIMAL(10, 2);

    -- Obtener el nombre del cliente
    SELECT nombre INTO p_nombre_cliente 
    FROM cliente 
    WHERE REPLACE(id_cedula, '-', '') = REPLACE(p_cedula_cliente, '-', '');

    -- Obtener el interés original
    SELECT int_calculado INTO p_interes_original 
    FROM prestamo 
    WHERE id_cedula = p_cedula_cliente;

    -- Obtener la cantidad prestada original
    SELECT cantidad_prestada INTO p_cantidad_original 
    FROM prestamo 
    WHERE id_cedula = p_cedula_cliente;

    -- Calcular el nuevo interés y cantidad prestada
    SET p_nuevo_interes = GREATEST(0, p_interes_original - p_interes);
    SET p_nueva_cantidad = GREATEST(0, p_cantidad_original - p_capital);

    -- Actualizar la tabla prestamo con el nuevo interés y cantidad prestada
    UPDATE prestamo 
    SET int_calculado = p_nuevo_interes, cantidad_prestada = p_nueva_cantidad 
    WHERE id_cedula = p_cedula_cliente;

    -- Insertar en la tabla de pagos si se encuentra el nombre del cliente
    IF p_nombre_cliente IS NOT NULL THEN
        INSERT INTO pagos (cedula_cliente, nombre_cliente, capital, interes, fecha)
        VALUES (p_cedula_cliente, p_nombre_cliente, p_capital, p_interes, NOW());
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_registrar` (IN `p_id_cedula` VARCHAR(255), IN `p_nombre` VARCHAR(255), IN `p_username` VARCHAR(255), IN `p_password` VARCHAR(255))   BEGIN
    INSERT INTO usuario (id_cedula, nombre, correo, contrasena) VALUES (p_id_cedula, p_nombre, p_username, p_password);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_registrar_cliente` (IN `p_id_cedula` VARCHAR(20), IN `p_nombre` VARCHAR(255), IN `p_telefono` VARCHAR(255), IN `p_correo` VARCHAR(255))   BEGIN
    -- Realizar cualquier validación adicional si es necesario

    -- Insertar el nuevo cliente en la base de datos
    INSERT INTO cliente (id_cedula, nombre, telefono, correo) VALUES (p_id_cedula, p_nombre, p_telefono, p_correo);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_verificar_login` (IN `p_username` VARCHAR(255))   BEGIN
    SELECT contrasena FROM usuario WHERE correo = p_username;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_verificar_usuario` (IN `p_username` VARCHAR(255))   BEGIN
    SELECT * FROM usuario WHERE correo = p_username;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cedula` varchar(15) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cedula`, `nombre`, `telefono`, `correo`) VALUES
('8-992-1814', 'Abdiel', '63', 'a@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `cedula_cliente` varchar(10) DEFAULT NULL,
  `nombre_cliente` varchar(255) DEFAULT NULL,
  `capital` decimal(10,2) DEFAULT 0.00,
  `interes` decimal(10,2) DEFAULT 0.00,
  `fecha` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE `prestamo` (
  `id_prestamo` int(11) NOT NULL,
  `id_cedula` varchar(15) DEFAULT NULL,
  `nombre_cliente` varchar(255) DEFAULT NULL,
  `cantidad_prestada` decimal(10,2) DEFAULT NULL,
  `interes` decimal(5,2) DEFAULT NULL,
  `plazo` int(11) DEFAULT NULL,
  `int_calculado` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_cedula` varchar(15) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_cedula`, `nombre`, `correo`, `contrasena`) VALUES
('8-985-7777', 'Abdiel', 'a89@gmail.com', '$2y$10$1L0W8ZfH6DxDV1OPUDL2J.12Q8jqtKoRp7KOXRXpQ87Zsit6zCe2m'),
('8-992-1819', 'Abdiel', 'a4@gmail.com', '$2y$10$vzVvng4S/cduAgi.XEgx8.ElsnMhmOTxZNlgwvhdO9p6g2bk5P.VK'),
('8555555', 'Abdiel', 'a123@gmail.com', '$2y$10$OU/U/Es4pr2cFhy5s5fgIuRgB9QksZtDM.pWGmGKs6PpUTMvgOVXK'),
('98', 'hola', 'a3@gmail.com', '$2y$10$xnGdQ71uquRANtBYS9mGFeV8yUYh9GknFy4/5mhxS0AdxaFPmfc1e');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cedula`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cedula_cliente` (`cedula_cliente`);

--
-- Indices de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`id_prestamo`),
  ADD UNIQUE KEY `id_cedula` (`id_cedula`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_cedula`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  MODIFY `id_prestamo` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`cedula_cliente`) REFERENCES `cliente` (`id_cedula`);

--
-- Filtros para la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD CONSTRAINT `prestamo_ibfk_1` FOREIGN KEY (`id_cedula`) REFERENCES `cliente` (`id_cedula`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
