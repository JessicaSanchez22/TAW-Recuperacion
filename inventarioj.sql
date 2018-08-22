-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 21-08-2018 a las 23:47:53
-- Versión del servidor: 5.7.23-0ubuntu0.16.04.1
-- Versión de PHP: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inventarioj`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`) VALUES
(1, 'belleza'),
(2, 'electrodomesticos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `email`, `direccion`, `telefono`) VALUES
(6, 'Marco', 'Perez Perez', 'marco@hotmail.com', 'Calle politecnico #210', '834567891'),
(7, 'Angel', 'Sanchez', '1530466@upv.edu.mx', 'Calle politecnico #110', '8645515143'),
(9, 'Jose Marco', 'Fuentes Escamilla', 'jo@gmail.com', 'Calle politecnico #110', '3874698'),
(11, 'Juan Miguel', 'Israel Mendez', '15300@gmail.com', 'Direccion ', '8346253'),
(12, 'Juanita', 'Garza Zapata', '1530466@upv.edu.mx', 'Calle jose de escandon', '82452416');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `codigo_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` int(11) NOT NULL,
  `precio_venta` int(11) NOT NULL,
  `margen` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id`, `id_producto`, `nombre_producto`, `codigo_producto`, `cantidad`, `precio_compra`, `precio_venta`, `margen`, `id_proveedor`) VALUES
(1, 1, 'Sombra para ojos', 580, 3, 100, 200, 100, 1),
(1, 1, 'Sombra para ojos', 580, 5, 100, 200, 100, 1),
(1, 5, 'Mascarilla biore', 1453, 2, 316, 400, 84, 1),
(1, 6, 'rubor', 1298, 6, 1080, 1200, 120, 2),
(1, 12, 'Delineador', 1, 5, 125, 250, 125, 2),
(3, 2, 'Sombras para ojos', 200, 1, 710, 520, 0, 1),
(4, 2, 'Sombras para ojos', 200, 10, 7100, 8000, 900, 1),
(6, 5, 'Mascarilla biore', 1453, 8, 1264, 1600, 336, 2),
(4, 6, 'rubor', 1298, 1, 180, 120, 0, 2),
(6, 2, 'Sombras para ojos', 200, 1, 710, 500, 0, 1),
(7, 4, 'pestaÃ±as postizas', 67854, 6, 720, 3600, 2880, 2),
(8, 12, 'Delineador', 1, 1, 25, 10, 0, 1),
(9, 2, 'Sombras para ojos', 200, 2, 1420, 400, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `total_compra` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `id_proveedor`, `total_compra`) VALUES
(1, 1, 1200),
(3, 1, 1721),
(4, 1, 710),
(6, 1, 7280),
(7, 1, 1974),
(8, 1, 720),
(9, 1, 25),
(10, 1, 1420);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id` int(11) NOT NULL,
  `nombre_producto` varchar(50) NOT NULL,
  `codigo_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` int(11) NOT NULL,
  `precio_venta` int(11) NOT NULL,
  `margen` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `fecha_pedido` date NOT NULL,
  `fecha_entrega` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id`, `nombre_producto`, `codigo_producto`, `cantidad`, `precio_compra`, `precio_venta`, `margen`, `id_proveedor`, `fecha_pedido`, `fecha_entrega`) VALUES
(1, 'Sombras para ojos', 200, 3, 200, 300, 100, 1, '2018-08-21', '2018-08-28'),
(1, 'rubor', 1298, 3, 540, 360, 0, 1, '2018-08-21', '2018-08-28'),
(1, 'rubor', 1298, 3, 540, 360, 0, 1, '2018-08-21', '2018-08-28'),
(1, 'rubor', 1298, 3, 540, 360, 0, 1, '2018-08-21', '2018-08-28'),
(1, 'rubor', 1298, 3, 540, 360, 0, 1, '2018-08-21', '2018-08-28'),
(1, 'rubor', 1298, 3, 540, 360, 0, 1, '2018-08-21', '2018-08-28'),
(1, 'rubor', 1298, 3, 540, 360, 0, 1, '2018-08-21', '2018-08-28'),
(1, 'Delineador', 1, 50, 1250, 1000, 0, 1, '2018-08-21', '2018-08-28'),
(0, 'Mascarilla biore', 1453, 7, 1106, 63, 0, 1, '2018-08-07', '2018-08-08'),
(0, 'Sombras para ojos', 200, 2, 1420, 4, 0, 1, '2018-08-16', '2018-08-17'),
(0, 'Sombras para ojos', 200, 8, 5680, 4000, 0, 2, '2018-08-24', '2018-08-14'),
(1, 'Sombras para ojos', 200, 4, 2840, 2000, 0, 2, '2018-08-21', '2018-08-22'),
(2, 'Sombras para ojos', 200, 1, 710, 1, 0, 1, '2018-08-18', '2018-08-18'),
(2, 'Sombras para ojos', 200, 1, 710, 1, 0, 1, '2018-08-10', '2018-08-03'),
(4, 'Brochas para sombras', 102, 3, 1050, 6, 0, 2, '2018-08-10', '2018-08-10'),
(4, 'Mascarilla', 555, 1, 120, 10, 0, 1, '2018-08-10', '2018-08-10'),
(5, 'banditas', 3535, 3, 45, 90, 45, 2, '2018-08-23', '2018-08-14'),
(6, 'Delineador', 1, 25, 625, 3000, 2375, 2, '2018-08-21', '2018-08-23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `fecha_pedido` date NOT NULL,
  `fecha_entrega` date NOT NULL,
  `total_pedido` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `fecha_pedido`, `fecha_entrega`, `total_pedido`, `id_proveedor`) VALUES
(1, '2018-08-21', '2018-08-28', 2500, 1),
(3, '2018-08-18', '2018-08-18', 1420, 1),
(4, '2018-08-10', '2018-08-10', 1170, 2),
(5, '2018-08-23', '2018-08-14', 45, 2),
(6, '2018-08-21', '2018-08-23', 625, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `codigo_producto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio_producto` int(11) NOT NULL,
  `cantidad_stock` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo_producto`, `nombre`, `precio_producto`, `cantidad_stock`, `id_categoria`) VALUES
(2, 200, 'Sombras para ojos', 710, 14, 1),
(4, 67854, 'pestaÃ±as postizas', 120, 13, 1),
(5, 1453, 'Mascarilla biore', 158, 17, 1),
(6, 1298, 'rubor', 180, 48, 1),
(7, 102, 'Brochas para sombras', 350, 22, 1),
(9, 111, 'Refrigerador', 17000, 2, 2),
(10, 555, 'Mascarilla', 120, 13, 1),
(11, 1203, 'Mascarilla de miel', 50, 18, 1),
(12, 1, 'Delineador', 25, 21, 1),
(13, 3535, 'banditas', 15, 20, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`) VALUES
(1, 'Sally Beauty Supply'),
(2, 'Renatta Cosmeticos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `codigo_producto` int(11) NOT NULL,
  `nombre_producto` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id_venta`, `id_producto`, `codigo_producto`, `nombre_producto`, `cantidad`, `total`) VALUES
(1, 1, 580, 'Labiales', 3, 0),
(1, 1, 580, 'Labiales mate', 2, 600),
(1, 1, 580, 'Labiales mate', 1, 300),
(1, 1, 580, 'Labiales mate', 5, 1500),
(1, 1, 580, 'Labiales mate', 1, 300),
(1, 1, 580, 'Labiales mate', 6, 1800),
(1, 1, 580, 'Labiales mate', 2, 600),
(1, 5, 1453, 'Mascarilla biore', 1, 158),
(1, 5, 1453, 'Mascarilla biore', 1, 158),
(1, 5, 1453, 'Mascarilla biore', 1, 158),
(1, 4, 67854, 'pestaÃ±as postizas', 1, 120),
(1, 4, 67854, 'pestaÃ±as postizas', 1, 120),
(1, 4, 67854, 'pestaÃ±as postizas', 1, 120),
(1, 4, 67854, 'pestaÃ±as postizas', 2, 240),
(1, 4, 67854, 'pestaÃ±as postizas', 2, 240),
(1, 4, 67854, 'pestaÃ±as postizas', 2, 240),
(1, 4, 67854, 'pestaÃ±as postizas', 2, 240),
(1, 4, 67854, 'pestaÃ±as postizas', 6, 720),
(1, 4, 67854, 'pestaÃ±as postizas', 6, 720),
(1, 4, 67854, 'pestaÃ±as postizas', 6, 720),
(1, 4, 67854, 'pestaÃ±as postizas', 6, 720),
(40, 6, 1298, 'rubor', 2, 360),
(41, 1, 580, 'Labiales mate', 1, 300),
(42, 1, 580, 'Labiales mate', 1, 300),
(43, 1, 580, 'Labiales mate', 11, 3300),
(44, 1, 580, 'Labiales mate', 8, 2400),
(45, 1, 580, 'Labiales mate', 9, 2700),
(46, 1, 580, 'Labiales mate', 6, 1800),
(47, 1, 580, 'Labiales mate', 8, 2400),
(48, 1, 580, 'Labiales mate', 8, 2400),
(49, 1, 580, 'Labiales mate', 6, 1800),
(50, 1, 580, 'Labiales mate', 1, 300),
(51, 5, 1453, 'Mascarilla biore', 2, 316),
(52, 1, 580, 'Labiales mate', 8, 2400),
(53, 1, 580, 'Labiales mate', 3, 900),
(1, 6, 1298, 'rubor', 4, 720),
(1, 6, 1298, 'rubor', 4, 720),
(2, 1, 580, 'Labiales mate', 8, 2400),
(0, 1, 580, 'Labiales mate', 1, 300),
(0, 1, 580, 'Labiales mate', 1, 300),
(0, 1, 580, 'Labiales mate', 1, 300),
(0, 1, 580, 'Labiales mate', 2, 600),
(0, 1, 580, 'Labiales mate', 2, 600),
(0, 6, 1298, 'rubor', 1, 180),
(0, 1, 580, 'Labiales mate', 1, 300),
(0, 1, 580, 'Labiales mate', 1, 300),
(0, 1, 580, 'Labiales mate', 1, 300),
(0, 1, 580, 'Labiales mate', 3, 900),
(0, 1, 580, 'Labiales mate', 3, 900),
(0, 1, 580, 'Labiales mate', 3, 900),
(0, 1, 580, 'Labiales mate', 1, 300),
(0, 5, 1453, 'Mascarilla biore', 1, 158),
(0, 5, 1453, 'Mascarilla biore', 1, 158),
(1, 1, 580, 'Labiales mate', 1, 300),
(1, 6, 1298, 'rubor', 1, 180),
(1, 5, 1453, 'Mascarilla biore', 2, 316),
(2, 6, 1298, 'rubor', 1, 180),
(33, 2, 200, 'Sombras para ojos', 2, 1420),
(34, 2, 200, 'Sombras para ojos', 3, 2130),
(36, 2, 200, 'Sombras para ojos', 5, 3550),
(36, 2, 200, 'Sombras para ojos', 5, 3550),
(6, 2, 200, 'Sombras para ojos', 2, 1420),
(10, 2, 200, 'Sombras para ojos', 2, 1420),
(6, 1, 580, 'Labiales mate', 8, 2400),
(8, 1, 580, 'Labiales mate', 8, 2400),
(9, 1, 580, 'Labiales mate', 2, 600),
(19, 9, 111, 'Refrigerador', 1, 17000),
(25, 8, 2701, 'Licuadora', 2, 3000),
(1, 7, 102, 'Brochas para sombras', 2, 700),
(2, 5, 1453, 'Mascarilla biore', 1, 158),
(3, 1, 580, 'Labiales mate', 1, 300),
(9, 1, 580, 'Labiales mate', 2, 600),
(10, 5, 1453, 'Mascarilla biore', 2, 316),
(42, 1, 580, 'Labiales mate', 3, 900),
(42, 1, 580, 'Labiales mate', 3, 900),
(42, 1, 580, 'Labiales mate', 3, 900),
(42, 1, 580, 'Labiales mate', 3, 900),
(42, 1, 580, 'Labiales mate', 2, 600),
(42, 1, 580, 'Labiales mate', 2, 600),
(42, 1, 580, 'Labiales mate', 2, 600),
(42, 1, 580, 'Labiales mate', 2, 600),
(42, 1, 580, 'Labiales mate', 3, 900),
(43, 1, 580, 'Labiales mate', 2, 600),
(43, 1, 580, 'Labiales mate', 2, 600),
(43, 1, 580, 'Labiales mate', 3, 900),
(43, 1, 580, 'Labiales mate', 3, 900),
(43, 6, 1298, 'rubor', 5, 900),
(43, 6, 1298, 'rubor', 5, 900),
(43, 1, 580, 'Labiales mate', 3, 900),
(43, 1, 580, 'Labiales mate', 2, 600),
(44, 4, 67854, 'pestaÃ±as postizas', 8, 960),
(44, 6, 1298, 'rubor', 6, 1080),
(44, 6, 1298, 'rubor', 6, 1080),
(44, 6, 1298, 'rubor', 6, 1080),
(44, 6, 1298, 'rubor', 6, 1080),
(44, 6, 1298, 'rubor', 6, 1080),
(44, 6, 1298, 'rubor', 6, 1080),
(45, 2, 200, 'Sombras para ojos', 6, 4260),
(47, 9, 111, 'Refrigerador', 2, 34000),
(48, 7, 102, 'Brochas para sombras', 1, 350),
(49, 5, 1453, 'Mascarilla biore', 2, 316);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `total_venta` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `total_venta`, `id_cliente`) VALUES
(41, 1200, 6),
(42, 1736, 6),
(43, 7200, 6),
(44, 9600, 6),
(45, 9840, 6),
(46, 6960, 6),
(47, 1800, 6),
(48, 36400, 6),
(49, 2750, 6),
(50, 2116, 6);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
