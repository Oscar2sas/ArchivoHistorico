-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-08-2022 a las 19:50:00
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `archivo_historico`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos`
--

CREATE TABLE `archivos` (
  `id_archivo` int(11) NOT NULL,
  `Id_ruta` varchar(11) NOT NULL,
  `Id_tipo_archivo` varchar(11) NOT NULL,
  `Id_palabra_clave` varchar(11) NOT NULL,
  `Nombre_Archivo` varchar(60) NOT NULL,
  `Titulo` varchar(60) NOT NULL,
  `Relacion` int(30) DEFAULT NULL,
  `Area` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `archivos`
--

INSERT INTO `archivos` (`id_archivo`, `Id_ruta`, `Id_tipo_archivo`, `Id_palabra_clave`, `Nombre_Archivo`, `Titulo`, `Relacion`, `Area`) VALUES
(4, '1', '1', '1', 'Exped_Jud_Aborigenes.pdf', 'Expedientes judiciales Pueblos aborigenes', 0, ''),
(5, '1', '1', '2', 'Exp_ferrocarril.pdf', 'Expedientes judiciales Ferrocarril', 0, ''),
(9, '2', '2', '1', 'dia_del_aborigen_americado.jpg', 'Foto por el dia del aborigen', 0, ''),
(10, '2', '2', '2', 'Ferrovial.jpg', 'Foto de un tren 1890', 0, ''),
(11, '2', '2', '2', 'trenes.jpg', 'Foto de un tren 1870', 0, ''),
(12, '2', '2', '1', 'mismo_trato.jpg', 'Fotografia del Gobernador ', 0, ''),
(14, '2', '2', '2', 'trenes.jpg', 'Fotografia del mismo tren 1870', 0, ''),
(25, '4', '1', '2', 'tapa.jpg', 'hola', 8605, '1'),
(26, '4', '1', '2', 'indice.jpg', 'hola', 8605, '1'),
(27, '4', '1', '2', 'contra tapa.jpg', 'hola', 8605, '1'),
(28, '4', '1', '1', 'tapa.jpg', 'trenes Argentinos', 2704, '1'),
(29, '4', '1', '1', 'indice.jpg', 'trenes Argentinos', 2704, '1'),
(30, '4', '1', '1', 'contra tapa.jpg', 'trenes Argentinos', 2704, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `ID_Areas` int(11) NOT NULL,
  `area` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`ID_Areas`, `area`) VALUES
(1, 'Biblioteca'),
(2, 'Fotografia'),
(3, 'Expedientes Jud'),
(4, 'Mapoteca');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `biblioteca`
--

CREATE TABLE `biblioteca` (
  `ID_Libro` int(11) NOT NULL,
  `ID_Archivo` int(11) NOT NULL,
  `Titulo_libro` varchar(20) NOT NULL,
  `Autor` varchar(20) NOT NULL,
  `Materia` varchar(20) NOT NULL,
  `Tipo` int(11) NOT NULL,
  `ID_coleccion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `biblioteca`
--

INSERT INTO `biblioteca` (`ID_Libro`, `ID_Archivo`, `Titulo_libro`, `Autor`, `Materia`, `Tipo`, `ID_coleccion`) VALUES
(8, 27, 'hola', 'yo', 'queso', 1, 2),
(9, 30, 'trenes Argentinos', 'jose', 'trenes', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coleccion`
--

CREATE TABLE `coleccion` (
  `ID_coleccion` int(11) NOT NULL,
  `Tipo_coleccion` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `coleccion`
--

INSERT INTO `coleccion` (`ID_coleccion`, `Tipo_coleccion`) VALUES
(1, 'Coleccion Local'),
(2, 'Coleccion General');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expedientes_judiciales`
--

CREATE TABLE `expedientes_judiciales` (
  `Id_exp_jud` int(11) NOT NULL,
  `Decada` varchar(30) NOT NULL,
  `id_archivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `expedientes_judiciales`
--

INSERT INTO `expedientes_judiciales` (`Id_exp_jud`, `Decada`, `id_archivo`) VALUES
(3, '40', 4),
(4, '60', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotografia`
--

CREATE TABLE `fotografia` (
  `Id_fotografia` int(11) NOT NULL,
  `Id_archivo` int(11) NOT NULL,
  `Descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `fotografia`
--

INSERT INTO `fotografia` (`Id_fotografia`, `Id_archivo`, `Descripcion`) VALUES
(1, 9, 'foto por el 19 de abril dia del aborigen americano'),
(2, 10, 'una foto del tren'),
(3, 11, 'otra foto del tren '),
(4, 12, 'foto del gobernador'),
(5, 13, 'foto de un tre'),
(6, 14, 'buenos dias');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `palabras_claves`
--

CREATE TABLE `palabras_claves` (
  `Id_palabra_clave` int(11) NOT NULL,
  `palabra_clave` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `palabras_claves`
--

INSERT INTO `palabras_claves` (`Id_palabra_clave`, `palabra_clave`) VALUES
(1, 'Pueblos aborigenes'),
(2, 'Ferrocarril');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutas`
--

CREATE TABLE `rutas` (
  `Id_rutas` int(11) NOT NULL,
  `rutas` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rutas`
--

INSERT INTO `rutas` (`Id_rutas`, `rutas`) VALUES
(1, '/archivoProvincial/Expedientes/'),
(2, '/archivoProvincial/Fotografia/'),
(3, '/archivoProvincial/Biblioteca/'),
(4, '/archivoProvincial/Biblioteca/Imagenes/');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_archivo`
--

CREATE TABLE `tipo_archivo` (
  `Id_tipo_Archivo` int(11) NOT NULL,
  `tipo` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_archivo`
--

INSERT INTO `tipo_archivo` (`Id_tipo_Archivo`, `tipo`) VALUES
(1, 'Expediente'),
(2, 'Imagenes'),
(5, 'PDF');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cont_b`
--

CREATE TABLE `tipo_cont_b` (
  `ID_tipo_cont_b` int(11) NOT NULL,
  `Descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_cont_b`
--

INSERT INTO `tipo_cont_b` (`ID_tipo_cont_b`, `Descripcion`) VALUES
(1, 'Libro'),
(2, 'Folleto');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD PRIMARY KEY (`id_archivo`);

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`ID_Areas`);

--
-- Indices de la tabla `biblioteca`
--
ALTER TABLE `biblioteca`
  ADD PRIMARY KEY (`ID_Libro`);

--
-- Indices de la tabla `coleccion`
--
ALTER TABLE `coleccion`
  ADD PRIMARY KEY (`ID_coleccion`);

--
-- Indices de la tabla `expedientes_judiciales`
--
ALTER TABLE `expedientes_judiciales`
  ADD PRIMARY KEY (`Id_exp_jud`);

--
-- Indices de la tabla `fotografia`
--
ALTER TABLE `fotografia`
  ADD PRIMARY KEY (`Id_fotografia`);

--
-- Indices de la tabla `palabras_claves`
--
ALTER TABLE `palabras_claves`
  ADD PRIMARY KEY (`Id_palabra_clave`);

--
-- Indices de la tabla `rutas`
--
ALTER TABLE `rutas`
  ADD PRIMARY KEY (`Id_rutas`);

--
-- Indices de la tabla `tipo_archivo`
--
ALTER TABLE `tipo_archivo`
  ADD PRIMARY KEY (`Id_tipo_Archivo`);

--
-- Indices de la tabla `tipo_cont_b`
--
ALTER TABLE `tipo_cont_b`
  ADD PRIMARY KEY (`ID_tipo_cont_b`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivos`
--
ALTER TABLE `archivos`
  MODIFY `id_archivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `ID_Areas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `biblioteca`
--
ALTER TABLE `biblioteca`
  MODIFY `ID_Libro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `coleccion`
--
ALTER TABLE `coleccion`
  MODIFY `ID_coleccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `expedientes_judiciales`
--
ALTER TABLE `expedientes_judiciales`
  MODIFY `Id_exp_jud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `fotografia`
--
ALTER TABLE `fotografia`
  MODIFY `Id_fotografia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `palabras_claves`
--
ALTER TABLE `palabras_claves`
  MODIFY `Id_palabra_clave` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rutas`
--
ALTER TABLE `rutas`
  MODIFY `Id_rutas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_archivo`
--
ALTER TABLE `tipo_archivo`
  MODIFY `Id_tipo_Archivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_cont_b`
--
ALTER TABLE `tipo_cont_b`
  MODIFY `ID_tipo_cont_b` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
