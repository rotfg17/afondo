-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-01-2024 a las 15:35:23
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
-- Base de datos: `newpaper_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE `articulo` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `subtitulo` varchar(100) NOT NULL,
  `contenido` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_autor` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `activo` tinyint(4) DEFAULT 1,
  `imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `articulo`
--

INSERT INTO `articulo` (`id`, `titulo`, `subtitulo`, `contenido`, `fecha`, `id_autor`, `id_categoria`, `activo`, `imagen`) VALUES
(1, 'Comienza la impresión de 17.8 millones de boletas para elecciones municipales del 18 de febrero', 'Las tiradas abarcan la impresión de 19,194 candidatos en 16,851 colegios electorales', '<p>La<strong> Junta Central Electoral </strong>(JCE) comenzó la tarde de este viernes la<strong> impresión </strong>de 17.8 millones de boletas que serán usadas en las<strong> elecciones municipales</strong> el próximo domingo 18 de febrero, donde están convocados <strong>8.1 millones de votantes.</strong></p>', '2024-01-12 23:58:06', 0, 1, 1, '../../img/entradas/anuncio.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autor`
--

CREATE TABLE `autor` (
  `id` int(11) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `activo` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `autor`
--

INSERT INTO `autor` (`id`, `nombres`, `email`, `activo`) VALUES
(1, 'Andreina Chalas', 'afondoconandreina@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `activo` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`, `activo`) VALUES
(1, 'Actualidad', 1),
(2, 'Deportes', 1),
(3, 'Turismo', 0),
(4, 'Revista', 1),
(5, 'Farándula', 1),
(6, 'Economía', 1),
(12, 'hola', 0),
(13, 'hola', 0),
(14, 'Inicio', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE `comentario` (
  `id` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `fecha_comentario` date NOT NULL,
  `id_articulo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `valor` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nombre`, `valor`) VALUES
(1, 'tienda_nombre', 'a fondo con andreina'),
(2, 'correo_email', 'afondoconandreina@gmail.com'),
(3, 'correo_smtp', 'smtp.gmail.com'),
(4, 'correo_password', 'O5L1l2S7ONR/GzIYT9TXsA==:/e3rhi5BEc4oGggU0tAzZ7SCJjbReSk8VFPvqfO49n4='),
(5, 'correo_puerto', '465');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contactos`
--

INSERT INTO `contactos` (`id`, `name`, `apellido`, `email`, `phone`, `message`) VALUES
(1, 'Robinson', 'Chalas', 'Robinsonchalasj@gmail.com', '980650', 'erthgssdrh;rbgsdivd;rtgvsedrt\r\nhrft\r\nhdsftgio;ujstdnbgsdft\'hrtb\r\nfthf\r\nth'),
(2, 'test', 'cristopher', 'rotfg17@gmail.com', 'r34524354', 'klk estoy probando'),
(3, 'test', '', 'robinsonchalasj@gmail.com', '987345890', 'Hola, estoy realizando prubas'),
(4, 'test', '', 'robinsonchalasj@gmail.com', '84389489', 'hola, estoy realizando otra prueba.'),
(5, '', '', '', '', ''),
(6, 'edscs', 'dcsdc', 'robinsonchalasj@gmail.com', 'cds', 'ragdrtgdrgsarsadr'),
(7, 'Test', '2', 'robinsonchalasj@gmail.com', '8097875349', 'Hola, esta es una nueva prueba'),
(8, 'Prueba', '11', 'robinsonchalasj@gmail.com', '898089', 'Hola'),
(9, 'Adelin', 'Alvarez', 'Robinsonchalasj@gmail.com', '459780', 'Hola, mi nombre es Adelin y es un placer saludarte. Quiero que sepas que me gustas mucho y no lo pienso discutir con nobody...');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `miniaturas`
--

CREATE TABLE `miniaturas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `subtitulo` varchar(200) NOT NULL,
  `contenido` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `imagen` varchar(255) NOT NULL,
  `activo` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `miniaturas`
--

INSERT INTO `miniaturas` (`id`, `titulo`, `subtitulo`, `contenido`, `fecha`, `imagen`, `activo`) VALUES
(1, 'Sample blog post', 'HTML defines a long list of available inline tags, a complete list of which can be found on the Mozilla Developer Network.', '<p>This blog post shows a few different types of content that’s supported and styled with Bootstrap. Basic typography, lists, tables, images, code, and more are all supported as expected.</p><p>This is some additional paragraph placeholder content. It has been written to fill the available space and show how a longer snippet of text affects the surrounding content. We\'ll repeat it often to keep the demonstration flowing, so be on the lookout for this exact same string of text.</p>', '2024-01-14 14:38:26', '../../img/miniaturas/no-photo.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `activacion` int(11) NOT NULL DEFAULT 0,
  `token` varchar(100) NOT NULL,
  `token_password` varchar(100) DEFAULT NULL,
  `password_request` int(11) NOT NULL DEFAULT 0,
  `id_autor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `activacion`, `token`, `token_password`, `password_request`, `id_autor`) VALUES
(1, 'afondo', '$2y$10$o0cjzUK9eiLnjlYJ1uDvYOCcqN36QR3OQaeXrsEjmpWc2mzddXFQy', 1, '', '9a160a809dad07659990c2312841a3e0', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `autor`
--
ALTER TABLE `autor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `miniaturas`
--
ALTER TABLE `miniaturas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulo`
--
ALTER TABLE `articulo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `autor`
--
ALTER TABLE `autor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `miniaturas`
--
ALTER TABLE `miniaturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
