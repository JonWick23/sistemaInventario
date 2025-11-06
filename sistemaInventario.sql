-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 06-11-2025 a las 21:08:43
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistemaInventario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Clientes`
--

CREATE TABLE `Clientes` (
  `id_clientes` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `direccion` varchar(250) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `codigo_postal` varchar(45) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `estatus` enum('Activo','Inactivo') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Compras`
--

CREATE TABLE `Compras` (
  `id_compras` int(11) NOT NULL,
  `Provedores_id_provedores` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `total` float DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_compra` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `OtrosMovimientos`
--

CREATE TABLE `OtrosMovimientos` (
  `id_otrosMovimientos` int(11) NOT NULL,
  `Productos_id_producto` int(11) NOT NULL,
  `nombre_prod` varchar(100) DEFAULT NULL,
  `tipo_mov` varchar(45) DEFAULT NULL,
  `descripcion` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Productos`
--

CREATE TABLE `Productos` (
  `id_productos` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `categoria` varchar(45) DEFAULT NULL,
  `cantidad` varchar(50) DEFAULT NULL,
  `precio_compra` float DEFAULT NULL,
  `precio_venta` float DEFAULT NULL,
  `proveedor` varchar(100) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `ubicacion` varchar(100) DEFAULT NULL,
  `estado` enum('Disponible','Agotado','Baja') DEFAULT NULL,
  `codigo_articulo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Productos_Compras`
--

CREATE TABLE `Productos_Compras` (
  `Productos_id_productos` int(11) NOT NULL,
  `Compras_id_compras` int(11) NOT NULL,
  `cantidad_pd_cp` float DEFAULT NULL,
  `precio_pd_cp` float DEFAULT NULL,
  `subtotal` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Provedores`
--

CREATE TABLE `Provedores` (
  `id_provedores` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `rfc` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `direccion` varchar(300) DEFAULT NULL,
  `promotor` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Provedores_Productos`
--

CREATE TABLE `Provedores_Productos` (
  `Provedores_id_provedores` int(11) NOT NULL,
  `Productos_id_producto` int(11) NOT NULL,
  `detalle` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Ventas`
--

CREATE TABLE `Ventas` (
  `id_ventas` int(11) NOT NULL,
  `iva` float DEFAULT NULL,
  `subtotal` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `Clientes_id_clientes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Ventas_Productos`
--

CREATE TABLE `Ventas_Productos` (
  `id_detalle` int(11) NOT NULL,
  `Ventas_id_ventas` int(11) NOT NULL,
  `Productos_id_productos` int(11) NOT NULL,
  `cantidad` float DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `subtotal` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Clientes`
--
ALTER TABLE `Clientes`
  ADD PRIMARY KEY (`id_clientes`);

--
-- Indices de la tabla `Compras`
--
ALTER TABLE `Compras`
  ADD PRIMARY KEY (`id_compras`),
  ADD KEY `fk_Compras_Provedores1_idx` (`Provedores_id_provedores`);

--
-- Indices de la tabla `OtrosMovimientos`
--
ALTER TABLE `OtrosMovimientos`
  ADD PRIMARY KEY (`id_otrosMovimientos`),
  ADD KEY `fk_OtrosMovimientos_Productos1_idx` (`Productos_id_producto`);

--
-- Indices de la tabla `Productos`
--
ALTER TABLE `Productos`
  ADD PRIMARY KEY (`id_productos`),
  ADD UNIQUE KEY `codigo_articulo` (`codigo_articulo`);

--
-- Indices de la tabla `Productos_Compras`
--
ALTER TABLE `Productos_Compras`
  ADD PRIMARY KEY (`Productos_id_productos`,`Compras_id_compras`),
  ADD KEY `fk_Productos_has_Compras_Compras1_idx` (`Compras_id_compras`),
  ADD KEY `fk_Productos_has_Compras_Productos1_idx` (`Productos_id_productos`);

--
-- Indices de la tabla `Provedores`
--
ALTER TABLE `Provedores`
  ADD PRIMARY KEY (`id_provedores`);

--
-- Indices de la tabla `Provedores_Productos`
--
ALTER TABLE `Provedores_Productos`
  ADD PRIMARY KEY (`Provedores_id_provedores`,`Productos_id_producto`),
  ADD KEY `fk_Provedores_has_Productos_Productos1_idx` (`Productos_id_producto`),
  ADD KEY `fk_Provedores_has_Productos_Provedores1_idx` (`Provedores_id_provedores`);

--
-- Indices de la tabla `Ventas`
--
ALTER TABLE `Ventas`
  ADD PRIMARY KEY (`id_ventas`),
  ADD KEY `fk_Ventas_Clientes1_idx` (`Clientes_id_clientes`);

--
-- Indices de la tabla `Ventas_Productos`
--
ALTER TABLE `Ventas_Productos`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `fk_Ventas_has_Productos_Productos1_idx` (`Productos_id_productos`),
  ADD KEY `fk_Ventas_has_Productos_Ventas1_idx` (`Ventas_id_ventas`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Clientes`
--
ALTER TABLE `Clientes`
  MODIFY `id_clientes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Compras`
--
ALTER TABLE `Compras`
  MODIFY `id_compras` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `OtrosMovimientos`
--
ALTER TABLE `OtrosMovimientos`
  MODIFY `id_otrosMovimientos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Productos`
--
ALTER TABLE `Productos`
  MODIFY `id_productos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Provedores`
--
ALTER TABLE `Provedores`
  MODIFY `id_provedores` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Ventas`
--
ALTER TABLE `Ventas`
  MODIFY `id_ventas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Ventas_Productos`
--
ALTER TABLE `Ventas_Productos`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Compras`
--
ALTER TABLE `Compras`
  ADD CONSTRAINT `fk_Compras_Provedores1` FOREIGN KEY (`Provedores_id_provedores`) REFERENCES `Provedores` (`id_provedores`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `OtrosMovimientos`
--
ALTER TABLE `OtrosMovimientos`
  ADD CONSTRAINT `fk_OtrosMovimientos_Productos1` FOREIGN KEY (`Productos_id_producto`) REFERENCES `Productos` (`id_productos`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Productos_Compras`
--
ALTER TABLE `Productos_Compras`
  ADD CONSTRAINT `fk_Productos_has_Compras_Compras1` FOREIGN KEY (`Compras_id_compras`) REFERENCES `Compras` (`id_compras`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Productos_has_Compras_Productos1` FOREIGN KEY (`Productos_id_productos`) REFERENCES `Productos` (`id_productos`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Provedores_Productos`
--
ALTER TABLE `Provedores_Productos`
  ADD CONSTRAINT `fk_Provedores_has_Productos_Productos1` FOREIGN KEY (`Productos_id_producto`) REFERENCES `Productos` (`id_productos`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Provedores_has_Productos_Provedores1` FOREIGN KEY (`Provedores_id_provedores`) REFERENCES `Provedores` (`id_provedores`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Ventas`
--
ALTER TABLE `Ventas`
  ADD CONSTRAINT `fk_Ventas_Clientes1` FOREIGN KEY (`Clientes_id_clientes`) REFERENCES `Clientes` (`id_clientes`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Ventas_Productos`
--
ALTER TABLE `Ventas_Productos`
  ADD CONSTRAINT `fk_Ventas_has_Productos_Productos1` FOREIGN KEY (`Productos_id_productos`) REFERENCES `Productos` (`id_productos`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_Ventas_has_Productos_Ventas1` FOREIGN KEY (`Ventas_id_ventas`) REFERENCES `Ventas` (`id_ventas`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
