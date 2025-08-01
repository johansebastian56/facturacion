-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-07-2025 a las 22:39:27
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `aceicar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id_facturas` int(12) NOT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `tipo_carro` varchar(50) NOT NULL,
  `placa` varchar(10) NOT NULL,
  `aceite` varchar(20) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `pago_cliente` decimal(10,2) DEFAULT NULL,
  `cambio` decimal(10,2) DEFAULT NULL,
  `metodo_pago` varchar(50) NOT NULL,
  `fk_id_usuarios` int(11) NOT NULL,
  `fk_id_inventario` int(11) NOT NULL,
  `fk_id_ventas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id_facturas`, `correo`, `tipo_carro`, `placa`, `aceite`, `cantidad`, `fecha`, `total`, `pago_cliente`, `cambio`, `metodo_pago`, `fk_id_usuarios`, `fk_id_inventario`, `fk_id_ventas`) VALUES
(1, 'sebaszambranoc3@gmail.com', 'sparkt', 'ght234', 'Mobil Super 1000 20w', 1, '2025-07-28', 30900.00, 32000.00, 1100.00, '0', 5, 5, 0),
(2, 'sebaszambranoc3@gmail.com', 'sparkt', 'ght234', 'Mobil Super 2000 5w ', 2, '2025-07-28', 63800.00, 65000.00, 1200.00, '0', 5, 6, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id_inventario` int(11) NOT NULL,
  `producto` varchar(100) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id_inventario`, `producto`, `tipo`, `cantidad`, `precio`, `fecha`, `estado`) VALUES
(1, 'Aceite SAE', '50 Mobil special HD cuarto', 49, 26900, '2025-07-27', ''),
(2, 'Aceite ', 'Mobil 5w 50 alto kilometraje – cuarto', 48, 27900, '2025-07-27', ''),
(3, 'Aceite', '10w 40 Lubritek – Cuarto', 37, 27900, '2025-07-27', ''),
(4, 'Aceite', 'Mobil 10w 30 – Super 2000 – cuarto', 29, 30900, '2025-07-27', ''),
(5, 'Aceite', 'Mobil Super 1000 20w 50', 49, 30900, '2025-07-27', ''),
(6, 'Aceite', 'Mobil Super 2000 5w 30 CUARTO', 28, 31900, '2025-07-27', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuarios` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `rol` enum('cliente','empleado','admin') NOT NULL DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuarios`, `nombre`, `apellido`, `correo`, `clave`, `telefono`, `rol`) VALUES
(1, 'aceicar', 'carros', 'aceite@gmail.com', '$2y$10$tf6asyxLwqsE56gvxtEmJOPHgyo4KlQcw8K0Pki8j15/oQfVHpjwS', '3228306119', 'cliente'),
(2, 'jorg', 'villamiza', 'jor@gmail.com', '$2y$10$r/c.rf1/yvL7cctV.iXe6ukvxXRnN9pyywNPuXIyvlVehb0kdvUmq', '3228306111', 'cliente'),
(3, 'juan', 'perez', 'juan@aceicar.com', '$2y$10$0Fklw40QE7Ar3reIFTIV2Oy3.10VKq9aV4sp2CIBQv6iJA7puV4F.', '	3228000000', 'empleado'),
(4, 'javi', '', 'javi@aceicar.com', '$2y$10$tTrhgkbR0CuPOVS1fngDAeBAcKqdiM4VSezRzshtRYWUnBRxS8cdW', NULL, 'admin'),
(5, 's', 'zz', 'sebaszambranoc3@gmail.com', '$2y$10$czUfz.ZNW8KW2UQeS9h3OOsnyXoW33PvmiItkXcCYktoYhKFZzX2G', '2222', 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_ventas` int(11) NOT NULL,
  `producto` varchar(100) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `cantidad_vendida` int(11) NOT NULL,
  `precio` decimal(10,3) NOT NULL,
  `total` decimal(10,3) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `metodo_pago` varchar(50) NOT NULL,
  `empleado` varchar(100) NOT NULL,
  `fk_id_empleado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_ventas`, `producto`, `tipo`, `cantidad_vendida`, `precio`, `total`, `fecha`, `hora`, `metodo_pago`, `empleado`, `fk_id_empleado`) VALUES
(1, 'Aceite', 'Mobil Super 1000 20w 50', 1, 30900.000, 30900.000, '2025-07-28', '14:45:02', 'Efectivo', 'javi', NULL),
(2, 'Aceite', 'Mobil Super 2000 5w 30 CUARTO', 2, 31900.000, 63800.000, '2025-07-28', '14:46:40', 'Efectivo', 'juan', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id_facturas`) USING BTREE,
  ADD KEY `fk_id_inventario` (`fk_id_inventario`) USING BTREE,
  ADD KEY `fk_id_usuarios` (`fk_id_usuarios`) USING BTREE;

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_inventario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuarios`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_ventas`),
  ADD KEY `fk_ventas_empleado` (`fk_id_empleado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id_facturas` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id_inventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_ventas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `fk_facturas_inventario` FOREIGN KEY (`fk_id_inventario`) REFERENCES `inventario` (`id_inventario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_facturas_usuarios` FOREIGN KEY (`fk_id_usuarios`) REFERENCES `usuarios` (`id_usuarios`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_ventas_empleado` FOREIGN KEY (`fk_id_empleado`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
