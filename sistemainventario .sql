-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 28-11-2025 a las 06:23:51
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
(1, 'grgregre', 'dgdgg', '4931949370', 'dgdg', 'dgdgf', 'fgfgdfg', '99050', '2025-11-19', 'Activo'),
(2, 'Jorge Gómez', 'cliente1@correo.com', '5561817884', 'Calle 194 #987', 'Chihuahua', 'Quintana Roo', '45751', '2024-08-07', 'Activo'),
(3, 'Luis Díaz', 'cliente2@correo.com', '5577952342', 'Calle 101 #687', 'León', 'Jalisco', '94474', '2024-06-05', 'Activo'),
(4, 'Luis Sánchez', 'cliente3@correo.com', '5515029447', 'Calle 189 #213', 'CDMX', 'Puebla', '79249', '2024-09-26', 'Inactivo'),
(5, 'Lucía Díaz', 'cliente4@correo.com', '5590410901', 'Calle 43 #432', 'Puebla', 'Puebla', '34772', '2024-08-01', 'Inactivo'),
(6, 'Miguel López', 'cliente5@correo.com', '5593272739', 'Calle 94 #490', 'Tijuana', 'Baja California', '35370', '2024-04-22', 'Inactivo'),
(7, 'Pedro Torres', 'cliente6@correo.com', '5570087852', 'Calle 149 #491', 'Chihuahua', 'Chihuahua', '97471', '2024-01-12', 'Inactivo'),
(8, 'Camila Díaz', 'cliente7@correo.com', '5575510615', 'Calle 40 #957', 'CDMX', 'Yucatán', '76595', '2024-02-28', 'Inactivo'),
(9, 'María Torres', 'cliente8@correo.com', '5525673984', 'Calle 8 #149', 'León', 'Nuevo León', '38896', '2024-02-03', 'Activo'),
(10, 'Pedro Hernández', 'cliente9@correo.com', '5526444874', 'Calle 139 #372', 'León', 'Nuevo León', '36213', '2024-02-21', 'Activo'),
(11, 'Fernando Ramírez', 'cliente10@correo.com', '5593839948', 'Calle 177 #350', 'Tijuana', 'CDMX', '18573', '2024-08-15', 'Activo'),
(12, 'Fernando Hernández', 'cliente11@correo.com', '5513791288', 'Calle 69 #267', 'Chihuahua', 'Nuevo León', '26599', '2024-02-28', 'Activo'),
(13, 'Andrés Torres', 'cliente12@correo.com', '5592462189', 'Calle 11 #184', 'Mérida', 'Quintana Roo', '49823', '2024-02-02', 'Activo'),
(14, 'Jorge Díaz', 'cliente13@correo.com', '5538188033', 'Calle 134 #871', 'Chihuahua', 'Jalisco', '78340', '2024-06-03', 'Inactivo'),
(15, 'Pedro Hernández', 'cliente14@correo.com', '5590206848', 'Calle 48 #851', 'CDMX', 'CDMX', '48533', '2024-10-02', 'Inactivo'),
(16, 'María Pérez', 'cliente15@correo.com', '5557227791', 'Calle 154 #836', 'Chihuahua', 'Jalisco', '50242', '2024-05-17', 'Activo'),
(17, 'Camila Castro', 'cliente16@correo.com', '5553428267', 'Calle 60 #639', 'Chihuahua', 'Quintana Roo', '37064', '2024-08-13', 'Inactivo'),
(18, 'Jorge Sánchez', 'cliente17@correo.com', '5525030766', 'Calle 32 #716', 'Cancún', 'Chihuahua', '76860', '2024-04-05', 'Inactivo'),
(19, 'Jorge Sánchez', 'cliente18@correo.com', '5596093730', 'Calle 142 #723', 'CDMX', 'Guanajuato', '88677', '2024-08-14', 'Activo'),
(20, 'Fernando Ramírez', 'cliente19@correo.com', '5519942307', 'Calle 44 #404', 'Tijuana', 'CDMX', '21153', '2024-08-22', 'Activo'),
(21, 'Miguel Torres', 'cliente20@correo.com', '5593057117', 'Calle 176 #436', 'Guadalajara', 'CDMX', '43915', '2024-10-19', 'Activo'),
(22, 'Carlos Hernández', 'cliente21@correo.com', '5570109621', 'Calle 158 #552', 'Puebla', 'Nuevo León', '90391', '2024-10-05', 'Activo'),
(23, 'Juan Ramírez', 'cliente22@correo.com', '5561711771', 'Calle 124 #683', 'Guadalajara', 'Nuevo León', '82131', '2024-08-10', 'Activo'),
(24, 'Jorge Martínez', 'cliente23@correo.com', '5551886476', 'Calle 182 #34', 'Puebla', 'Querétaro', '99953', '2024-04-19', 'Inactivo'),
(25, 'Ana Gómez', 'cliente24@correo.com', '5522335786', 'Calle 57 #981', 'Puebla', 'Quintana Roo', '84937', '2024-08-26', 'Inactivo'),
(26, 'Sofía Torres', 'cliente25@correo.com', '5515616153', 'Calle 37 #81', 'Monterrey', 'Yucatán', '46212', '2024-05-02', 'Inactivo'),
(27, 'Sofía Díaz', 'cliente26@correo.com', '5524397030', 'Calle 50 #295', 'Monterrey', 'Puebla', '28209', '2024-03-28', 'Activo'),
(28, 'Lucía Díaz', 'cliente27@correo.com', '5585489798', 'Calle 39 #793', 'Cancún', 'Baja California', '93875', '2024-02-24', 'Activo'),
(29, 'Camila Gómez', 'cliente28@correo.com', '5546737927', 'Calle 103 #831', 'Mérida', 'Puebla', '41221', '2024-02-02', 'Activo'),
(30, 'Luis Torres', 'cliente29@correo.com', '5584480742', 'Calle 116 #580', 'Querétaro', 'Baja California', '32127', '2024-09-08', 'Activo'),
(31, 'Pedro Ramírez', 'cliente30@correo.com', '5594132698', 'Calle 94 #897', 'Mérida', 'Puebla', '33214', '2024-07-26', 'Inactivo'),
(32, 'Valeria Martínez', 'cliente31@correo.com', '5557149188', 'Calle 98 #44', 'Monterrey', 'Guanajuato', '53393', '2024-06-01', 'Inactivo'),
(33, 'Miguel Sánchez', 'cliente32@correo.com', '5590142344', 'Calle 145 #447', 'CDMX', 'Querétaro', '75759', '2024-01-20', 'Activo'),
(34, 'Lucía López', 'cliente33@correo.com', '5568076604', 'Calle 64 #676', 'Puebla', 'Quintana Roo', '90395', '2024-01-10', 'Activo'),
(35, 'Juan Castro', 'cliente34@correo.com', '5532849839', 'Calle 177 #38', 'León', 'Yucatán', '17507', '2024-09-26', 'Inactivo'),
(36, 'Luis Torres', 'cliente35@correo.com', '5563463468', 'Calle 12 #524', 'Chihuahua', 'Yucatán', '94357', '2024-06-04', 'Inactivo'),
(37, 'Pedro Hernández', 'cliente36@correo.com', '5512176229', 'Calle 125 #576', 'Chihuahua', 'Jalisco', '49611', '2024-10-01', 'Inactivo'),
(38, 'Luis Hernández', 'cliente37@correo.com', '5543647697', 'Calle 73 #993', 'Monterrey', 'CDMX', '76676', '2024-09-22', 'Inactivo'),
(39, 'Fernando Castro', 'cliente38@correo.com', '5591397661', 'Calle 159 #334', 'Guadalajara', 'Puebla', '50867', '2024-10-13', 'Activo'),
(40, 'Juan Hernández', 'cliente39@correo.com', '5564236431', 'Calle 50 #790', 'Puebla', 'Quintana Roo', '88678', '2024-04-22', 'Activo'),
(41, 'Lucía Díaz', 'cliente40@correo.com', '5593186356', 'Calle 129 #598', 'León', 'Nuevo León', '38144', '2024-06-07', 'Inactivo'),
(42, 'Camila Gómez', 'cliente41@correo.com', '5573711632', 'Calle 102 #705', 'León', 'Quintana Roo', '50080', '2024-02-11', 'Activo'),
(43, 'Miguel Castro', 'cliente42@correo.com', '5521143126', 'Calle 27 #769', 'Guadalajara', 'Quintana Roo', '44174', '2024-01-09', 'Inactivo'),
(44, 'Jorge Torres', 'cliente43@correo.com', '5511687045', 'Calle 55 #413', 'Puebla', 'Quintana Roo', '42333', '2024-09-26', 'Inactivo'),
(45, 'Pedro Hernández', 'cliente44@correo.com', '5514815649', 'Calle 38 #350', 'Guadalajara', 'Jalisco', '48441', '2024-03-26', 'Activo'),
(46, 'Fernando Gómez', 'cliente45@correo.com', '5571281071', 'Calle 59 #55', 'Monterrey', 'Quintana Roo', '81536', '2024-01-14', 'Inactivo'),
(47, 'Andrés Torres', 'cliente46@correo.com', '5574962197', 'Calle 100 #458', 'Cancún', 'Guanajuato', '90771', '2024-05-28', 'Inactivo'),
(48, 'Juan Martínez', 'cliente47@correo.com', '5512833973', 'Calle 146 #179', 'Cancún', 'Chihuahua', '87133', '2024-01-03', 'Activo'),
(49, 'Jorge Pérez', 'cliente48@correo.com', '5571474714', 'Calle 122 #600', 'Monterrey', 'Jalisco', '15869', '2024-08-14', 'Inactivo'),
(50, 'Camila Ramírez', 'cliente49@correo.com', '5558237798', 'Calle 25 #587', 'Cancún', 'Querétaro', '66523', '2024-04-15', 'Activo'),
(51, 'Luis Sánchez', 'cliente50@correo.com', '5586333119', 'Calle 125 #222', 'Puebla', 'Jalisco', '80363', '2024-02-01', 'Activo'),
(52, 'Andrés Martínez', 'cliente51@correo.com', '5512810528', 'Calle 140 #117', 'León', 'CDMX', '17528', '2024-05-06', 'Inactivo'),
(53, 'Sofía López', 'cliente52@correo.com', '5534746885', 'Calle 99 #143', 'Tijuana', 'CDMX', '52633', '2024-09-02', 'Activo'),
(54, 'Jorge Hernández', 'cliente53@correo.com', '5542741607', 'Calle 134 #816', 'León', 'Quintana Roo', '52849', '2024-04-27', 'Inactivo'),
(55, 'Sofía Torres', 'cliente54@correo.com', '5555611582', 'Calle 158 #64', 'Cancún', 'Baja California', '85907', '2024-05-07', 'Inactivo'),
(56, 'Juan Gómez', 'cliente55@correo.com', '5511599627', 'Calle 56 #808', 'Tijuana', 'Querétaro', '66392', '2024-10-24', 'Activo'),
(57, 'Andrés Martínez', 'cliente56@correo.com', '5576731492', 'Calle 139 #20', 'Guadalajara', 'Chihuahua', '96524', '2024-05-14', 'Activo'),
(58, 'Valeria Torres', 'cliente57@correo.com', '5559380196', 'Calle 96 #521', 'Mérida', 'Jalisco', '91130', '2024-05-11', 'Activo'),
(59, 'Sofía Díaz', 'cliente58@correo.com', '5538789929', 'Calle 51 #458', 'Chihuahua', 'Yucatán', '92920', '2024-03-23', 'Activo'),
(60, 'Ana Pérez', 'cliente59@correo.com', '5551718029', 'Calle 50 #60', 'Monterrey', 'Querétaro', '42613', '2024-02-16', 'Inactivo'),
(61, 'Fernando Hernández', 'cliente60@correo.com', '5513350099', 'Calle 97 #800', 'CDMX', 'Puebla', '91682', '2024-08-03', 'Inactivo'),
(62, 'Pedro Sánchez', 'cliente61@correo.com', '5522542581', 'Calle 111 #836', 'León', 'Quintana Roo', '40390', '2024-01-20', 'Activo'),
(63, 'Paula López', 'cliente62@correo.com', '5599299190', 'Calle 75 #228', 'Cancún', 'Puebla', '17264', '2024-01-17', 'Inactivo'),
(64, 'Sofía Martínez', 'cliente63@correo.com', '5531278521', 'Calle 198 #203', 'Chihuahua', 'CDMX', '90673', '2024-02-20', 'Inactivo'),
(65, 'Pedro Sánchez', 'cliente64@correo.com', '5585159855', 'Calle 143 #38', 'Querétaro', 'Chihuahua', '40811', '2024-07-09', 'Activo'),
(66, 'Valeria López', 'cliente65@correo.com', '5590233727', 'Calle 146 #693', 'Mérida', 'Quintana Roo', '81432', '2024-06-13', 'Inactivo'),
(67, 'Sofía Ramírez', 'cliente66@correo.com', '5540418298', 'Calle 160 #883', 'Cancún', 'Nuevo León', '27777', '2024-07-18', 'Inactivo'),
(68, 'Pedro Torres', 'cliente67@correo.com', '5518035515', 'Calle 162 #54', 'CDMX', 'Quintana Roo', '18867', '2024-03-22', 'Activo'),
(69, 'Andrés López', 'cliente68@correo.com', '5592950490', 'Calle 2 #48', 'Mérida', 'CDMX', '19885', '2024-08-29', 'Activo'),
(70, 'Lucía Pérez', 'cliente69@correo.com', '5577142438', 'Calle 109 #150', 'Guadalajara', 'Nuevo León', '14639', '2024-08-26', 'Inactivo'),
(71, 'Luis Pérez', 'cliente70@correo.com', '5524788199', 'Calle 128 #202', 'Querétaro', 'Chihuahua', '32909', '2024-10-04', 'Inactivo'),
(72, 'Luis Castro', 'cliente71@correo.com', '5579935363', 'Calle 154 #947', 'León', 'Jalisco', '29588', '2024-10-25', 'Inactivo'),
(73, 'Ana Hernández', 'cliente72@correo.com', '5598428995', 'Calle 67 #260', 'Monterrey', 'Quintana Roo', '61331', '2024-06-27', 'Activo'),
(74, 'Sofía Pérez', 'cliente73@correo.com', '5523459029', 'Calle 143 #375', 'CDMX', 'Quintana Roo', '37328', '2024-09-21', 'Inactivo'),
(75, 'Jorge Hernández', 'cliente74@correo.com', '5525560308', 'Calle 154 #527', 'Puebla', 'Nuevo León', '50879', '2024-01-02', 'Inactivo'),
(76, 'Luis Martínez', 'cliente75@correo.com', '5558247620', 'Calle 150 #96', 'Cancún', 'Yucatán', '66739', '2024-08-18', 'Inactivo'),
(77, 'Jorge Torres', 'cliente76@correo.com', '5592458349', 'Calle 126 #382', 'Guadalajara', 'Querétaro', '71882', '2024-04-25', 'Inactivo'),
(78, 'Lucía Castro', 'cliente77@correo.com', '5565610503', 'Calle 104 #838', 'Cancún', 'Querétaro', '23746', '2024-02-06', 'Activo'),
(79, 'Paula Martínez', 'cliente78@correo.com', '5562962263', 'Calle 99 #151', 'Mérida', 'Chihuahua', '76972', '2024-02-05', 'Activo'),
(80, 'Jorge Sánchez', 'cliente79@correo.com', '5572017149', 'Calle 28 #770', 'Guadalajara', 'Guanajuato', '47160', '2024-06-24', 'Inactivo'),
(81, 'Luis Díaz', 'cliente80@correo.com', '5596627561', 'Calle 69 #91', 'Cancún', 'Guanajuato', '95503', '2024-08-17', 'Activo'),
(82, 'Jorge Pérez', 'cliente81@correo.com', '5559471629', 'Calle 170 #999', 'CDMX', 'Querétaro', '49561', '2024-07-12', 'Inactivo'),
(83, 'Camila Gómez', 'cliente82@correo.com', '5583153693', 'Calle 115 #253', 'Chihuahua', 'Baja California', '17814', '2024-01-20', 'Activo'),
(84, 'Sofía Martínez', 'cliente83@correo.com', '5583480170', 'Calle 61 #452', 'León', 'Baja California', '36227', '2024-10-05', 'Inactivo'),
(85, 'Juan López', 'cliente84@correo.com', '5583083954', 'Calle 17 #957', 'Tijuana', 'Baja California', '81125', '2024-03-12', 'Activo'),
(86, 'Andrés Castro', 'cliente85@correo.com', '5592387785', 'Calle 12 #775', 'Cancún', 'Nuevo León', '85846', '2024-10-20', 'Activo'),
(87, 'Andrés Sánchez', 'cliente86@correo.com', '5599651216', 'Calle 164 #286', 'León', 'Nuevo León', '79071', '2024-07-06', 'Activo'),
(88, 'Pedro Martínez', 'cliente87@correo.com', '5556690738', 'Calle 189 #87', 'Tijuana', 'Quintana Roo', '51582', '2024-08-08', 'Activo'),
(89, 'Carlos Martínez', 'cliente88@correo.com', '5589333949', 'Calle 46 #960', 'Tijuana', 'Baja California', '93839', '2024-08-07', 'Activo'),
(90, 'Juan Gómez', 'cliente89@correo.com', '5593193148', 'Calle 97 #689', 'Guadalajara', 'Baja California', '40143', '2024-06-14', 'Activo'),
(91, 'Fernando Torres', 'cliente90@correo.com', '5582043857', 'Calle 91 #188', 'Tijuana', 'Puebla', '83453', '2024-02-04', 'Inactivo'),
(92, 'Pedro Castro', 'cliente91@correo.com', '5571105873', 'Calle 125 #757', 'Mérida', 'Querétaro', '27718', '2024-07-09', 'Inactivo'),
(93, 'Sofía Torres', 'cliente92@correo.com', '5523126702', 'Calle 117 #311', 'León', 'Chihuahua', '57648', '2024-09-24', 'Activo'),
(94, 'Valeria López', 'cliente93@correo.com', '5572988861', 'Calle 47 #417', 'Monterrey', 'Puebla', '98956', '2024-09-21', 'Activo'),
(95, 'Carlos Sánchez', 'cliente94@correo.com', '5581112531', 'Calle 15 #860', 'Puebla', 'Nuevo León', '68381', '2024-07-26', 'Inactivo'),
(96, 'Miguel López', 'cliente95@correo.com', '5576417571', 'Calle 17 #683', 'León', 'Nuevo León', '38951', '2024-06-29', 'Activo'),
(97, 'Fernando Castro', 'cliente96@correo.com', '5550727563', 'Calle 85 #898', 'Guadalajara', 'Yucatán', '47680', '2024-02-06', 'Activo'),
(98, 'María Sánchez', 'cliente97@correo.com', '5575942447', 'Calle 187 #759', 'Chihuahua', 'Quintana Roo', '76068', '2024-09-17', 'Inactivo'),
(99, 'Andrés Hernández', 'cliente98@correo.com', '5511793418', 'Calle 148 #237', 'Mérida', 'Chihuahua', '92757', '2024-04-10', 'Inactivo'),
(100, 'Ana Castro', 'cliente99@correo.com', '5552199213', 'Calle 24 #645', 'Puebla', 'Querétaro', '85476', '2024-09-16', 'Inactivo'),
(101, 'Lucía Pérez', 'cliente100@correo.com', '5554089000', 'Calle 183 #103', 'Puebla', 'Querétaro', '82092', '2024-07-13', 'Inactivo');

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
  `codigo_articulo` varchar(20) NOT NULL,
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

INSERT INTO `productos` (`id_productos`, `codigo_articulo`, `nombre`, `categoria`, `cantidad`, `precio_compra`, `precio_venta`, `proveedor`, `fecha_ingreso`, `ubicacion`, `estado`) VALUES
(1, '', 'bdfdf', 'fbdfb', 73, 55, 67, 'grgrg', '2025-11-05', 'o0', 'Disponible'),
(4, 'A003', 'Teclado Mecánico Redragon', 'Accesorios', 22, 450, 699, 'Redragon', '2024-11-03', 'Almacén B2', 'Disponible'),
(5, 'A004', 'Monitor Samsung 24\"', 'Tecnología', 10, 2100, 2999, 'Samsung', '2024-11-03', 'Almacén A2', 'Disponible'),
(6, 'A005', 'Impresora Epson L3250', 'Oficina', 8, 3200, 4499, 'Epson', '2024-11-04', 'Almacén C1', 'Disponible'),
(7, 'A006', 'Silla Gamer Cougar', 'Muebles', 5, 2800, 3899, 'Cougar', '2024-11-04', 'Almacén D1', 'Disponible'),
(8, 'A007', 'USB Kingston 32GB', 'Accesorios', 100, 60, 120, 'Kingston', '2024-11-05', 'Almacén B1', 'Disponible'),
(9, 'A008', 'Disco Duro 1TB Seagate', 'Tecnología', 20, 650, 999, 'Seagate', '2024-11-06', 'Almacén A3', 'Disponible'),
(10, 'A009', 'SSD Kingston 480GB', 'Tecnología', 18, 550, 849, 'Kingston', '2024-11-06', 'Almacén A4', 'Disponible'),
(11, 'A010', 'Router TP-Link AC1200', 'Redes', 14, 430, 699, 'TP-Link', '2024-11-07', 'Almacén C2', 'Disponible'),
(12, 'A011', 'Cable HDMI 2m', 'Accesorios', 50, 35, 79, 'Generic', '2024-11-07', 'Almacén B4', 'Disponible'),
(13, 'A012', 'Cámara Web Logitech C270', 'Tecnología', 16, 280, 450, 'Logitech', '2024-11-08', 'Almacén A5', 'Disponible'),
(14, 'A013', 'Auriculares Sony WH-CH510', 'Audio', 12, 700, 1099, 'Sony', '2024-11-08', 'Almacén B5', 'Disponible'),
(15, 'A014', 'Bocina JBL Flip 5', 'Audio', 9, 1400, 1999, 'JBL', '2024-11-09', 'Almacén B6', 'Disponible'),
(16, 'A015', 'Mini Proyector Wanbo', 'Tecnología', 6, 1500, 2199, 'Wanbo', '2024-11-09', 'Almacén C3', 'Disponible'),
(17, 'A016', 'Memoria RAM 8GB DDR4', 'Tecnología', 24, 320, 549, 'Corsair', '2024-11-10', 'Almacén A2', 'Disponible'),
(18, 'A017', 'Memoria RAM 16GB DDR4', 'Tecnología', 20, 650, 999, 'Corsair', '2024-11-10', 'Almacén A2', 'Disponible'),
(19, 'A018', 'Tablet Lenovo M10', 'Tecnología', 7, 2100, 2899, 'Lenovo', '2024-11-11', 'Almacén A6', 'Disponible'),
(20, 'A019', 'Cable USB-C 1m', 'Accesorios', 60, 20, 59, 'Generic', '2024-11-11', 'Almacén B7', 'Disponible'),
(21, 'A020', 'Power Bank 10000mAh Xiaomi', 'Tecnología', 25, 220, 450, 'Xiaomi', '2024-11-12', 'Almacén B8', 'Disponible'),
(22, 'A021', 'Calculadora Casio MX-12B', 'Oficina', 18, 90, 149, 'Casio', '2024-11-12', 'Almacén C4', 'Disponible'),
(23, 'A022', 'Regulador Forza 1200VA', 'Energía', 12, 350, 599, 'Forza', '2024-11-13', 'Almacén C5', 'Disponible'),
(24, 'A023', 'Supresor de Picos Steren', 'Energía', 35, 70, 129, 'Steren', '2024-11-13', 'Almacén C6', 'Disponible'),
(25, 'A024', 'Tinta Epson 544 Negra', 'Oficina', 30, 110, 199, 'Epson', '2024-11-14', 'Almacén C1', 'Disponible'),
(26, 'A025', 'Tinta Epson 544 Color', 'Oficina', 30, 110, 199, 'Epson', '2024-11-14', 'Almacén C1', 'Disponible'),
(27, 'A026', 'Control Xbox Series', 'Gaming', 10, 1100, 1599, 'Microsoft', '2024-11-14', 'Almacén D2', 'Disponible'),
(28, 'A027', 'Control PS5 DualSense', 'Gaming', 9, 1300, 1899, 'Sony', '2024-11-15', 'Almacén D2', 'Disponible'),
(29, 'A028', 'Disipador Cooler Master', 'Tecnología', 11, 240, 399, 'Cooler Master', '2024-11-15', 'Almacén A3', 'Disponible'),
(30, 'A029', 'Tarjeta Madre ASUS B450', 'Tecnología', 5, 1300, 1899, 'ASUS', '2024-11-15', 'Almacén A3', 'Disponible'),
(31, 'A030', 'Batería CR2032', 'Accesorios', 80, 5, 20, 'Duracell', '2024-11-16', 'Almacén B9', 'Disponible'),
(32, 'A031', 'Cargador Laptop HP 45W', 'Accesorios', 14, 180, 349, 'HP', '2024-11-16', 'Almacén B4', 'Disponible'),
(33, 'A032', 'Filtro Regulador Koblenz', 'Energía', 7, 260, 399, 'Koblenz', '2024-11-17', 'Almacén C5', 'Disponible'),
(34, 'A033', 'Bocina Bluetooth Sony XB12', 'Audio', 10, 550, 799, 'Sony', '2024-11-17', 'Almacén B6', 'Disponible'),
(35, 'A034', 'Auriculares In-Ear JBL', 'Audio', 42, 120, 249, 'JBL', '2024-11-18', 'Almacén B6', 'Disponible'),
(36, 'A035', 'Smartwatch Xiaomi Mi Band 7', 'Tecnología', 16, 650, 999, 'Xiaomi', '2024-11-18', 'Almacén A6', 'Disponible'),
(37, 'A036', 'Antena WiFi USB 600Mbps', 'Redes', 20, 90, 169, 'Generic', '2024-11-19', 'Almacén C2', 'Disponible'),
(38, 'A037', 'Proyector Epson VS250', 'Tecnología', 4, 4200, 5999, 'Epson', '2024-11-19', 'Almacén C3', 'Disponible'),
(39, 'A038', 'Disco SSD NVMe 1TB', 'Tecnología', 8, 950, 1499, 'ADATA', '2024-11-20', 'Almacén A4', 'Disponible'),
(40, 'A039', 'Teclado Inalámbrico Microsoft', 'Accesorios', 10, 240, 399, 'Microsoft', '2024-11-20', 'Almacén B2', 'Disponible'),
(41, 'A040', 'Mouse Inalámbrico Microsoft', 'Accesorios', 15, 180, 299, 'Microsoft', '2024-11-20', 'Almacén B3', 'Disponible'),
(42, 'A041', 'Cable VGA 1.5m', 'Accesorios', 50, 25, 59, 'Generic', '2024-11-21', 'Almacén B4', 'Disponible'),
(43, 'A042', 'Adaptador HDMI-VGA', 'Accesorios', 32, 40, 99, 'Generic', '2024-11-21', 'Almacén B4', 'Disponible'),
(44, 'A043', 'Extensión Eléctrica 2m', 'Energía', 28, 35, 79, 'Steren', '2024-11-21', 'Almacén C6', 'Disponible'),
(45, 'A044', 'Laptop Dell Inspiron 15', 'Tecnología', 6, 8500, 11499, 'Dell', '2024-11-22', 'Almacén A1', 'Disponible'),
(46, 'A045', 'Switch 8 Puertos TP-Link', 'Redes', 14, 240, 399, 'TP-Link', '2024-11-22', 'Almacén C2', 'Disponible'),
(47, 'A046', 'Hub USB 4 Puertos', 'Accesorios', 33, 30, 79, 'Generic', '2024-11-22', 'Almacén B1', 'Disponible'),
(48, 'A047', 'Soporte para Monitor', 'Accesorios', 12, 120, 249, 'Generic', '2024-11-23', 'Almacén B2', 'Disponible'),
(49, 'A048', 'Escritorio para PC', 'Muebles', 4, 1100, 1799, 'Office Depot', '2024-11-23', 'Almacén D1', 'Disponible'),
(50, 'A049', 'Silla Ejecutiva Negra', 'Muebles', 6, 900, 1499, 'Office Depot', '2024-11-23', 'Almacén D1', 'Disponible'),
(51, 'A050', 'Folio Bond Tamaño Carta', 'Oficina', 60, 55, 109, 'Scribe', '2024-11-24', 'Almacén C1', 'Disponible'),
(52, 'A051', 'Batería Recargable AA', 'Accesorios', 40, 20, 49, 'Energizer', '2024-11-24', 'Almacén B9', 'Disponible'),
(53, 'A052', 'Memoria MicroSD 64GB', 'Accesorios', 30, 90, 169, 'Sandisk', '2024-11-25', 'Almacén B1', 'Disponible'),
(54, 'A053', 'Memoria MicroSD 128GB', 'Accesorios', 25, 160, 299, 'Sandisk', '2024-11-25', 'Almacén B1', 'Disponible'),
(55, 'A054', 'Lámpara USB LED', 'Accesorios', 45, 15, 39, 'Generic', '2024-11-25', 'Almacén B7', 'Disponible'),
(56, 'A055', 'Laptop Lenovo ThinkPad', 'Tecnología', 6, 9800, 13499, 'Lenovo', '2024-11-25', 'Almacén A1', 'Disponible'),
(57, 'A056', 'Pad Mouse XL', 'Accesorios', 20, 50, 99, 'Generic', '2024-11-26', 'Almacén B2', 'Disponible'),
(58, 'A057', 'Micrófono USB Fifine K669', 'Audio', 10, 350, 599, 'Fifine', '2024-11-26', 'Almacén B6', 'Disponible'),
(59, 'A058', 'Webcam Full HD 1080p', 'Tecnología', 14, 200, 399, 'Generic', '2024-11-26', 'Almacén A5', 'Disponible'),
(60, 'A059', 'Proyector Mini LED', 'Tecnología', 5, 750, 1199, 'Generic', '2024-11-27', 'Almacén C3', 'Disponible'),
(61, 'A060', 'Mouse Gamer RGB', 'Gaming', 30, 120, 249, 'Redragon', '2024-11-27', 'Almacén D2', 'Disponible'),
(62, 'A061', 'Teclado Gamer RGB', 'Gaming', 20, 210, 399, 'Redragon', '2024-11-27', 'Almacén D2', 'Disponible'),
(63, 'A062', 'Bocina Portátil Bass', 'Audio', 18, 110, 199, 'Generic', '2024-11-28', 'Almacén B6', 'Disponible'),
(64, 'A063', 'Audífonos Bluetooth QCY', 'Audio', 22, 150, 299, 'QCY', '2024-11-28', 'Almacén B6', 'Disponible'),
(65, 'A064', 'Reloj Inteligente T500', 'Tecnología', 20, 180, 349, 'Generic', '2024-11-28', 'Almacén A6', 'Disponible'),
(66, 'A065', 'Case para PC ATX', 'Tecnología', 8, 550, 899, 'Game Factor', '2024-11-29', 'Almacén A3', 'Disponible'),
(67, 'A066', 'Fuente 500W Game Factor', 'Tecnología', 10, 350, 599, 'Game Factor', '2024-11-29', 'Almacén A3', 'Disponible'),
(68, 'A067', 'Extensión USB 3m', 'Accesorios', 25, 25, 59, 'Generic', '2024-11-29', 'Almacén B4', 'Disponible'),
(69, 'A068', 'Smart TV TCL 43\"', 'Tecnología', 4, 4900, 6799, 'TCL', '2024-11-30', 'Almacén A0', 'Disponible'),
(70, 'A069', 'Laptop Acer Aspire 3', 'Tecnología', 7, 7200, 9999, 'Acer', '2024-11-30', 'Almacén A1', 'Disponible'),
(71, 'A070', 'Memoria USB 128GB', 'Accesorios', 32, 110, 199, 'Kingston', '2024-11-30', 'Almacén B1', 'Disponible'),
(72, 'A071', 'Router ASUS RT-AX55', 'Redes', 5, 1300, 1999, 'ASUS', '2024-12-01', 'Almacén C2', 'Disponible'),
(73, 'A072', 'Hub USB-C 6 en 1', 'Accesorios', 15, 210, 399, 'Ugreen', '2024-12-01', 'Almacén B1', 'Disponible'),
(74, 'A073', 'Disco Externo 2TB WD', 'Tecnología', 10, 1200, 1899, 'Western Digital', '2024-12-01', 'Almacén A4', 'Disponible'),
(75, 'A074', 'Audífonos Gamer Onikuma', 'Gaming', 18, 180, 349, 'Onikuma', '2024-12-02', 'Almacén D2', 'Disponible'),
(76, 'A075', 'Laptop MSI GF63', 'Tecnología', 4, 12800, 16999, 'MSI', '2024-12-02', 'Almacén A1', 'Disponible'),
(77, 'A076', 'Multímetro Digital', 'Herramientas', 12, 80, 149, 'Steren', '2024-12-02', 'Almacén C7', 'Disponible'),
(78, 'A077', 'Cámara IP Wifi 360°', 'Seguridad', 10, 280, 499, 'Ezviz', '2024-12-03', 'Almacén C8', 'Disponible'),
(79, 'A078', 'Kit Herramientas PC', 'Herramientas', 8, 180, 329, 'Generic', '2024-12-03', 'Almacén C7', 'Disponible'),
(80, 'A079', 'Soporte Laptop Ajustable', 'Accesorios', 20, 70, 149, 'Generic', '2024-12-03', 'Almacén B2', 'Disponible'),
(81, 'A080', 'Mini Bocina LED', 'Audio', 26, 45, 99, 'Generic', '2024-12-04', 'Almacén B6', 'Disponible'),
(82, 'A081', 'Cámara Deportiva 4K', 'Tecnología', 8, 400, 699, 'Generic', '2024-12-04', 'Almacén A5', 'Disponible'),
(83, 'A082', 'Foco Inteligente WiFi', 'Hogar', 30, 90, 169, 'Tuya', '2024-12-04', 'Almacén C9', 'Disponible'),
(84, 'A083', 'Interfaz de Audio USB', 'Audio', 5, 850, 1299, 'Behringer', '2024-12-05', 'Almacén B6', 'Disponible'),
(85, 'A084', 'Tripié para Celular', 'Accesorios', 30, 45, 99, 'Generic', '2024-12-05', 'Almacén B7', 'Disponible'),
(86, 'A085', 'Micrófono Lavalier', 'Audio', 35, 30, 89, 'Generic', '2024-12-06', 'Almacén B6', 'Disponible'),
(87, 'A086', 'Monitor LG 27\" IPS', 'Tecnología', 4, 3200, 4499, 'LG', '2024-12-06', 'Almacén A2', 'Disponible'),
(88, 'A087', 'Switch 16 Puertos', 'Redes', 6, 850, 1299, 'TP-Link', '2024-12-06', 'Almacén C2', 'Disponible'),
(89, 'A088', 'Cable DisplayPort 2m', 'Accesorios', 20, 45, 99, 'Generic', '2024-12-07', 'Almacén B4', 'Disponible'),
(90, 'A089', 'Cargador Rápido 25W', 'Accesorios', 25, 80, 149, 'Samsung', '2024-12-07', 'Almacén B1', 'Disponible'),
(91, 'A090', 'Tablet Samsung A8', 'Tecnología', 9, 3200, 4499, 'Samsung', '2024-12-07', 'Almacén A6', 'Disponible'),
(92, 'A091', 'Router Huawei AX3', 'Redes', 10, 850, 1299, 'Huawei', '2024-12-08', 'Almacén C2', 'Disponible'),
(94, 'A093', 'Teclado Bluetooth', 'Accesorios', 12, 110, 199, 'Logitech', '2024-12-08', 'Almacén B2', 'Disponible'),
(95, 'A094', 'Silla Gamer Razer', 'Muebles', 3, 4200, 5999, 'Razer', '2024-12-09', 'Almacén D1', 'Disponible'),
(96, 'A095', 'Laptop ASUS Vivobook', 'Tecnología', 7, 8900, 11999, 'ASUS', '2024-12-09', 'Almacén A1', 'Disponible'),
(97, 'A096', 'SSD M.2 SATA 240GB', 'Tecnología', 25, 210, 399, 'ADATA', '2024-12-09', 'Almacén A4', 'Disponible'),
(98, 'A097', 'Cámara PTZ 1080p', 'Seguridad', 6, 450, 799, 'Ezviz', '2024-12-10', 'Almacén C8', 'Disponible'),
(99, 'A098', 'Mini UPS para Modem', 'Energía', 10, 250, 449, 'CyberPower', '2024-12-10', 'Almacén C6', 'Disponible'),
(100, 'A099', 'Estuche para Laptop 15\"', 'Accesorios', 20, 70, 149, 'Generic', '2024-12-10', 'Almacén B2', 'Disponible'),
(101, 'A100', 'Audífonos Sony ZX110', 'Audio', 14, 150, 249, 'Sony', '2024-12-11', 'Almacén B6', 'Disponible');

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
  MODIFY `id_clientes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

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
  MODIFY `id_productos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

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
