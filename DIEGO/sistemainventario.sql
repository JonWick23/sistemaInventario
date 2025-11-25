-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-11-2025 a las 19:24:59
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistemainventario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
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

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_clientes`, `nombre`, `email`, `telefono`, `direccion`, `ciudad`, `estado`, `codigo_postal`, `fecha_registro`, `estatus`) VALUES
(1, 'grgregre', 'dgdgg', '4931949370', 'dgdg', 'dgdgf', 'fgfgdfg', '99050', '2025-11-19', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id_compras` int(11) NOT NULL,
  `Provedores_id_provedores` int(11) NOT NULL,
  `iva` float NOT NULL,
  `total` float DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id_compras`, `Provedores_id_provedores`, `iva`, `total`, `fecha`) VALUES
(2, 1, 8.8, 63.8, '2025-11-14'),
(4, 1, 589.6, 4274.6, '2025-11-25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `otrosmovimientos`
--

CREATE TABLE `otrosmovimientos` (
  `id_otrosMovimientos` int(11) NOT NULL,
  `Productos_id_producto` int(11) NOT NULL,
  `nombre_prod` varchar(45) DEFAULT NULL,
  `tipo_mov` varchar(45) DEFAULT NULL,
  `descripcion` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_productos` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `categoria` varchar(45) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_compra` float DEFAULT NULL,
  `precio_venta` float DEFAULT NULL,
  `proveedor` varchar(100) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `ubicacion` varchar(100) DEFAULT NULL,
  `estado` enum('Disponible','Agotado','Baja') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_productos`, `nombre`, `categoria`, `cantidad`, `precio_compra`, `precio_venta`, `proveedor`, `fecha_ingreso`, `ubicacion`, `estado`) VALUES
(1, 'bdfdf', 'fbdfb', 73, 55, 67, 'grgrg', '2025-11-05', 'o0', 'Disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_compras`
--

CREATE TABLE `productos_compras` (
  `Productos_id_productos` int(11) NOT NULL,
  `Compras_id_compras` int(11) NOT NULL,
  `cantidad_pd_cp` float DEFAULT NULL,
  `precio_pd_cp` float DEFAULT NULL,
  `subtotal` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos_compras`
--

INSERT INTO `productos_compras` (`Productos_id_productos`, `Compras_id_compras`, `cantidad_pd_cp`, `precio_pd_cp`, `subtotal`) VALUES
(1, 2, 1, 55, 55),
(1, 4, 67, 55, 3685);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provedores`
--

CREATE TABLE `provedores` (
  `id_provedores` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `rfc` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `direccion` varchar(300) DEFAULT NULL,
  `promotor` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `provedores`
--

INSERT INTO `provedores` (`id_provedores`, `nombre`, `rfc`, `email`, `telefono`, `direccion`, `promotor`) VALUES
(1, 'grg', 'rgrg', 'rgr', '4931949370', 'rgr', 'rg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provedores_productos`
--

CREATE TABLE `provedores_productos` (
  `Provedores_id_provedores` int(11) NOT NULL,
  `Productos_id_producto` int(11) NOT NULL,
  `Provedores_Productoscol` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_ventas` int(11) NOT NULL,
  `Clientes_id_clientes` int(11) NOT NULL,
  `iva` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `fecha_venta` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_ventas`, `Clientes_id_clientes`, `iva`, `total`, `fecha_venta`) VALUES
(26, 1, 21.44, 155.44, '2025-11-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_productos`
--

CREATE TABLE `ventas_productos` (
  `Ventas_id_ventas` int(11) NOT NULL,
  `Productos_id_productos` int(11) NOT NULL,
  `cantidad` float DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `subtotal` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas_productos`
--

INSERT INTO `ventas_productos` (`Ventas_id_ventas`, `Productos_id_productos`, `cantidad`, `precio`, `subtotal`) VALUES
(26, 1, 2, 67, 134);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_clientes`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_compras`),
  ADD KEY `fk_Compras_Provedores1_idx` (`Provedores_id_provedores`);

--
-- Indices de la tabla `otrosmovimientos`
--
ALTER TABLE `otrosmovimientos`
  ADD PRIMARY KEY (`id_otrosMovimientos`),
  ADD KEY `fk_OtrosMovimientos_Productos1_idx` (`Productos_id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_productos`);

--
-- Indices de la tabla `productos_compras`
--
ALTER TABLE `productos_compras`
  ADD PRIMARY KEY (`Productos_id_productos`,`Compras_id_compras`),
  ADD KEY `fk_Productos_has_Compras_Compras1_idx` (`Compras_id_compras`),
  ADD KEY `fk_Productos_has_Compras_Productos1_idx` (`Productos_id_productos`);

--
-- Indices de la tabla `provedores`
--
ALTER TABLE `provedores`
  ADD PRIMARY KEY (`id_provedores`);

--
-- Indices de la tabla `provedores_productos`
--
ALTER TABLE `provedores_productos`
  ADD PRIMARY KEY (`Provedores_id_provedores`,`Productos_id_producto`),
  ADD KEY `fk_Provedores_has_Productos_Productos1_idx` (`Productos_id_producto`),
  ADD KEY `fk_Provedores_has_Productos_Provedores1_idx` (`Provedores_id_provedores`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_ventas`),
  ADD KEY `fk_Ventas_Clientes1_idx` (`Clientes_id_clientes`);

--
-- Indices de la tabla `ventas_productos`
--
ALTER TABLE `ventas_productos`
  ADD PRIMARY KEY (`Ventas_id_ventas`,`Productos_id_productos`),
  ADD UNIQUE KEY `Ventas_id_ventas` (`Ventas_id_ventas`),
  ADD KEY `fk_Ventas_has_Productos_Productos1_idx` (`Productos_id_productos`),
  ADD KEY `fk_Ventas_has_Productos_Ventas1_idx` (`Ventas_id_ventas`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_clientes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_compras` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `otrosmovimientos`
--
ALTER TABLE `otrosmovimientos`
  MODIFY `id_otrosMovimientos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_productos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `provedores`
--
ALTER TABLE `provedores`
  MODIFY `id_provedores` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_ventas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `fk_Compras_Provedores1` FOREIGN KEY (`Provedores_id_provedores`) REFERENCES `provedores` (`id_provedores`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `otrosmovimientos`
--
ALTER TABLE `otrosmovimientos`
  ADD CONSTRAINT `fk_OtrosMovimientos_Productos1` FOREIGN KEY (`Productos_id_producto`) REFERENCES `productos` (`id_productos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productos_compras`
--
ALTER TABLE `productos_compras`
  ADD CONSTRAINT `fk_Productos_has_Compras_Compras1` FOREIGN KEY (`Compras_id_compras`) REFERENCES `compras` (`id_compras`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Productos_has_Compras_Productos1` FOREIGN KEY (`Productos_id_productos`) REFERENCES `productos` (`id_productos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `provedores_productos`
--
ALTER TABLE `provedores_productos`
  ADD CONSTRAINT `fk_Provedores_has_Productos_Productos1` FOREIGN KEY (`Productos_id_producto`) REFERENCES `productos` (`id_productos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Provedores_has_Productos_Provedores1` FOREIGN KEY (`Provedores_id_provedores`) REFERENCES `provedores` (`id_provedores`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_Ventas_Clientes1` FOREIGN KEY (`Clientes_id_clientes`) REFERENCES `clientes` (`id_clientes`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ventas_productos`
--
ALTER TABLE `ventas_productos`
  ADD CONSTRAINT `fk_Ventas_has_Productos_Productos1` FOREIGN KEY (`Productos_id_productos`) REFERENCES `productos` (`id_productos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Ventas_has_Productos_Ventas1` FOREIGN KEY (`Ventas_id_ventas`) REFERENCES `ventas` (`id_ventas`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
