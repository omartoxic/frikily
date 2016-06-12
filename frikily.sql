-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-06-2016 a las 20:45:21
-- Versión del servidor: 5.6.20
-- Versión de PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `frikily`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anime`
--

CREATE TABLE IF NOT EXISTS `anime` (
  `Codigo` int(4) NOT NULL,
  `AnnioFin` int(4) NOT NULL,
  `Temporadas` int(2) NOT NULL,
  `Capitulos` int(4) NOT NULL,
  `Estudio` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `anime`
--

INSERT INTO `anime` (`Codigo`, `AnnioFin`, `Temporadas`, `Capitulos`, `Estudio`) VALUES
(5, 2008, 2, 50, 'Sunrise'),
(13, 2014, 2, 26, 'Bones');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE IF NOT EXISTS `comentarios` (
`CodigoComentario` int(4) NOT NULL,
  `Codigo` int(4) NOT NULL,
  `CodUsuario` int(4) NOT NULL,
  `Comentario` varchar(500) NOT NULL,
  `Fecha` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`CodigoComentario`, `Codigo`, `CodUsuario`, `Comentario`, `Fecha`) VALUES
(1, 5, 13, 'Escribe aquí tus comentarios', '2016-05-29 17:28:00'),
(2, 5, 13, 'Escribe aquí tus comentarios', '2016-05-29 17:28:00'),
(3, 5, 13, 'a', '2016-05-29 17:36:00'),
(10, 13, 1, 'Escribe aquí tus comentarios', '2016-05-29 18:01:00'),
(12, 14, 13, 'Escribe aquí tus comentarios', '2016-06-03 21:41:00'),
(14, 5, 1, 'aaa', '2016-06-15 13:00:00'),
(15, 13, 13, 'Escribe aquí tus comentarios', '2016-06-10 21:21:00'),
(16, 11, 13, 'Es mora\r\n', '2016-06-10 21:27:00'),
(17, 2, 13, 'Escribe aquí tus comentarios', '2016-06-10 21:28:00'),
(18, 5, 13, 'Escribe aquí tus comentarios', '2016-06-10 21:29:00'),
(19, 5, 13, 'Escribe aquí tus comentarios', '2016-06-10 21:32:00'),
(20, 3, 13, 'Escribe aquí tus comentarios', '2016-06-10 21:32:00'),
(21, 2, 13, 'Escribe aquí tus comentarios', '2016-06-10 21:34:00'),
(22, 1, 13, 'Escribe aquí tus comentarios', '2016-06-10 21:34:00'),
(23, 6, 13, 'Escribe aquí tus comentarios', '2016-06-10 21:34:00'),
(24, 4, 13, 'Escribe aquí tus comentarios', '2016-06-10 21:35:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comics`
--

CREATE TABLE IF NOT EXISTS `comics` (
  `Codigo` int(4) NOT NULL,
  `Numeros` int(4) NOT NULL,
  `Editorial` varchar(40) NOT NULL,
  `EditorialOriginal` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `comics`
--

INSERT INTO `comics` (`Codigo`, `Numeros`, `Editorial`, `EditorialOriginal`) VALUES
(7, 116, 'Panini', 'Marvel'),
(11, 3, 'Panini', 'Marvel'),
(12, 72, 'Ediciones B', 'Euredit ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `episodios`
--

CREATE TABLE IF NOT EXISTS `episodios` (
`CodigoCapitulo` int(3) NOT NULL,
  `Codigo` int(4) NOT NULL,
  `Numero` int(4) NOT NULL,
  `Contenedor` int(3) NOT NULL,
  `Titulo` varchar(60) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `episodios`
--

INSERT INTO `episodios` (`CodigoCapitulo`, `Codigo`, `Numero`, `Contenedor`, `Titulo`) VALUES
(1, 6, 705, 27, 'Rose'),
(2, 5, 1, 1, 'El Día que Nació el dios del Mal'),
(3, 11, 1, 1, 'Fuera de lo normal Parte 1: Metamorfosis '),
(4, 11, 2, 1, 'Fuera de lo normal Parte 2: Toda la humanidad'),
(5, 13, 1, 1, 'Sigue la corriente, nena'),
(6, 15, 1, 1, 'Piloto'),
(7, 1, 0, 0, '0'),
(8, 16, 0, 0, '0'),
(9, 8, 0, 0, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estrenos`
--

CREATE TABLE IF NOT EXISTS `estrenos` (
`CodEstreno` int(3) NOT NULL,
  `Codigo` int(4) NOT NULL,
  `Fecha` date NOT NULL,
  `CodCapitulo` int(4) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `estrenos`
--

INSERT INTO `estrenos` (`CodEstreno`, `Codigo`, `Fecha`, `CodCapitulo`) VALUES
(4, 1, '2016-06-22', 7),
(5, 16, '2016-06-08', 8),
(6, 8, '2016-06-16', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `general`
--

CREATE TABLE IF NOT EXISTS `general` (
`Codigo` int(4) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Sinopsis` varchar(600) NOT NULL,
  `Nota` float NOT NULL,
  `Genero` varchar(20) NOT NULL,
  `Imagen` varchar(10) NOT NULL,
  `Annio` int(4) NOT NULL,
  `Aprobado` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `general`
--

INSERT INTO `general` (`Codigo`, `Nombre`, `Sinopsis`, `Nota`, `Genero`, `Imagen`, `Annio`, `Aprobado`) VALUES
(1, 'Batman V Superman: El amanecer de la Justicia', 'Batman pega a Superman.', 8.8, 'Superhéroes', 'img1', 2016, 1),
(2, 'Frankenstein', 'Victor Von Frankenstein ha creado vida de lo muerto. Pero su creación piensa por si misma y busca su camino.', 9.4, 'Ciencia Ficcion', 'img2', 1818, 1),
(3, 'Jojo''s Bizarre Adventure', 'Los Jojos son muy machos', 9.9, 'Fantasía ', 'img3', 1987, 1),
(4, 'Life is Strange', 'Max X Chloe ', 10, 'Aventura gráfica', 'img4', 2015, 1),
(5, 'Code Geass', 'Lelouch debe liberar a Japón de Britannia.', 9.7, 'Seinen', 'img5', 2005, 1),
(6, 'Doctor Who', 'El Doctor es lo mejor que le ha pasado al universo.', 10, 'Ciencia Ficcion', 'img6', 1963, 1),
(7, 'El Asombroso Spiderman', 'Peter Parker fue mordido por una araña que le convirtió en el Asombroso Spiderman.', 9.8, 'Superhéroes', 'img7', 1962, 1),
(8, 'Mother 2', 'Ness debe derrotar a Gyigas.', 10, 'Rol', 'img8', 1994, 1),
(9, 'The Seven Deadly Sins', 'Todos saben que los Siete Pecados Capitales fueron unos rebeldes legendarios que conspiraron contra el reino, y por ello los Caballeros Sagrados aún los buscan tenazmente. Sin embargo hay una joven que intenta encontrarlos para que salven su reino… ', 8, 'Shonen', 'img9', 2012, 1),
(10, 'Twin Peaks', 'Puto amo el agente Cooper', 9.9, 'Thriller', 'img10', 1990, 1),
(11, 'Ms. Marvel', 'Kamala Khan es una chica como otra cualquiera que vive en Nueva Jersey... Hasta que un buen día recibe un don asombroso. Pero... ¿quién es realmente Ms. Marvel? ¿Una adolescente? ¿Una musulmana? ¿Una inhumana? ¿Todo lo anterior?', 9, 'Superhéroes', 'img11', 2015, 1),
(12, 'Superlopez', 'Antonio Alcántara con poderes', 9, 'Superhéroes', 'img12', 1973, 1),
(13, 'Space Dandy', 'Dandy es un cazarecompensas que busca aliens que nadie ha encontrado antes sirviéndose de su robot acompañante QT y un gato alienígena llamado Meow.', 8, 'Seinen', 'img13', 2014, 1),
(14, 'Metal Gear Solid', 'Metal Gear Solid sigue a Solid Snake, un soldado que se infiltra en una instalación de armas nucleares para neutralizar la amenaza terrorista de FOXHOUND, una unidad genéticamente mejorada de fuerzas especiales.10 11 Snake debe liberar a dos importantes rehenes, confrontar a los terroristas y evitar el lanzamiento de un ataque nuclear.', 9.9, 'Infiltración', 'img14', 1998, 1),
(15, 'Arrested Development', 'Esta es la historia de los Bluth, una familia desestructurada de clase alta que tiene que hacer frente a la pobreza cuando el padre ingresa en prisión acusado de fraude. En ese momento llega al rescate Michael, el único honrado de toda la familia que tiene que luchar por defender lo indefendible, un padre culpable a más no poder,e intentar, sin conseguirlo, que el resto asuma la nueva situación.', 9.9, 'Comedia', 'img15', 2003, 1),
(16, 'Origen', 'Dom Cobb es un experto en el arte de apropiarse, durante el sueño, de los secretos del subconsciente ajeno. Su extraña habilidad le ha convertido en un hombre muy cotizado en el mundo del espionaje, pero también lo ha condenado a ser un fugitivo y, por consiguiente, a renunciar a llevar una vida normal. Su única oportunidad para cambiar de vida será hacer lo contrario de lo que ha hecho siempre: la incepción, que consiste en implantar una idea en el subconsciente en lugar de sustraerla. Sin embargo, su plan se complica debido a la intervención de alguien que parece predecir sus movimientos', 9, 'Thriller', 'img16', 2010, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE IF NOT EXISTS `libros` (
  `Codigo` int(4) NOT NULL,
  `Paginas` int(4) NOT NULL,
  `ISBN` bigint(13) NOT NULL,
  `Editorial` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`Codigo`, `Paginas`, `ISBN`, `Editorial`) VALUES
(2, 368, 9788478445158, 'Miscojones');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `manga`
--

CREATE TABLE IF NOT EXISTS `manga` (
  `Codigo` int(4) NOT NULL,
  `AnnioFin` int(4) NOT NULL,
  `Revista` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Tomos` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `manga`
--

INSERT INTO `manga` (`Codigo`, `AnnioFin`, `Revista`, `Tomos`) VALUES
(3, 0, 'Weekly Shōnen Jump', 115),
(9, 0, 'Weekly Shōnen Magazine', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE IF NOT EXISTS `peliculas` (
  `Codigo` int(4) NOT NULL,
  `Duracion` int(3) NOT NULL,
  `Productora` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`Codigo`, `Duracion`, `Productora`) VALUES
(1, 151, 'Warner'),
(16, 148, 'Legendary Pictures');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE IF NOT EXISTS `personas` (
`CodigoPersona` int(3) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Apellido` varchar(60) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`CodigoPersona`, `Nombre`, `Apellido`) VALUES
(1, 'David', 'Tennat'),
(2, 'Jun', 'Fukuyama'),
(3, 'Peter', 'Capaldi'),
(4, 'Yukana', 'Nogami'),
(5, 'Stan ', 'Lee'),
(6, 'Steve', 'Ditko'),
(7, 'Mary', 'Shelley'),
(8, 'Hirohiko', 'Araki'),
(9, 'Zack', 'Snyder'),
(10, 'Ben', 'Affleck'),
(11, 'Henry', 'Cavill'),
(12, 'Juan', 'Lopez'),
(13, 'Kyle', 'MacLachlan'),
(14, 'Nakaba', 'Suzuki'),
(15, 'Sana', 'Amanat'),
(16, 'Stephen', 'Wacker'),
(17, 'G. Willow', 'Wilson'),
(18, 'Junichi', 'Suwabe'),
(19, 'Uki', 'Satake'),
(20, 'Hiroyuki', 'Yoshino'),
(22, 'Shigesato', 'Itoi'),
(23, 'Hideo', 'Kojima'),
(24, 'Jason', 'Bateman'),
(25, 'Michael', 'Cera'),
(26, 'Leonardo', 'DiCaprio'),
(27, 'Ellen', 'Page');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plataformas`
--

CREATE TABLE IF NOT EXISTS `plataformas` (
`CodigoPlataforma` int(4) NOT NULL,
  `Codigo` int(4) NOT NULL,
  `Plataforma` varchar(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `plataformas`
--

INSERT INTO `plataformas` (`CodigoPlataforma`, `Codigo`, `Plataforma`) VALUES
(1, 8, 'SNES'),
(2, 4, 'PS4'),
(3, 4, 'PS3'),
(4, 4, 'Xbox 360'),
(5, 4, 'Xbox One'),
(6, 4, 'Steam'),
(7, 14, 'PSX');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE IF NOT EXISTS `rol` (
  `CodigoPersona` int(4) NOT NULL,
  `Codigo` int(4) NOT NULL,
  `Rol` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`CodigoPersona`, `Codigo`, `Rol`) VALUES
(1, 6, 'Actor'),
(2, 5, 'Actor'),
(3, 6, 'Actor'),
(4, 5, 'Actor'),
(5, 7, 'Autor'),
(6, 7, 'Autor'),
(7, 2, 'Autor'),
(8, 3, 'Autor'),
(9, 1, 'Director'),
(10, 1, 'Actor'),
(11, 1, 'Actor'),
(12, 12, 'Autor'),
(13, 10, 'Actor'),
(14, 9, 'Autor'),
(15, 11, 'Autor'),
(16, 11, 'Autor'),
(17, 11, 'Autor'),
(18, 13, 'Actor'),
(19, 13, 'Actor'),
(20, 13, 'Actor'),
(22, 8, 'Autor'),
(23, 14, 'Autor'),
(24, 15, 'Actor'),
(25, 15, 'Actor'),
(26, 16, 'Actor'),
(27, 16, 'Actor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `series`
--

CREATE TABLE IF NOT EXISTS `series` (
  `Codigo` int(4) NOT NULL,
  `AnnioFin` int(4) NOT NULL,
  `Temporadas` int(3) NOT NULL,
  `Capitulos` int(3) NOT NULL,
  `Canal` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `series`
--

INSERT INTO `series` (`Codigo`, `AnnioFin`, `Temporadas`, `Capitulos`, `Canal`) VALUES
(6, 0, 35, 833, 'BBC'),
(10, 1991, 2, 39, 'ABC'),
(15, 2013, 4, 67, 'Netflix');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
`CodUsuario` int(4) NOT NULL,
  `Nombre` varchar(10) NOT NULL,
  `Pass` varchar(32) NOT NULL,
  `Imagen` varchar(5) NOT NULL,
  `Mail` varchar(20) NOT NULL,
  `Tipo` varchar(5) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`CodUsuario`, `Nombre`, `Pass`, `Imagen`, `Mail`, `Tipo`) VALUES
(1, 'omar', 'a16656a039d8b23731b3e933914f8bd7', 'omar', 'omar', 'usu'),
(2, 'ivan', '81dc9bdb52d04dc20036dbd8313ed055', 'ivan', 'ivan', 'usu'),
(3, 'pipo', '0cc175b9c0f1b6a831c399e269772661', 'pipo', 'a', 'usu'),
(13, 'u', '7b774effe4a349c6dd82ad4f4f21d34c', 'u.jpg', 'jio', 'usu');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videojuegos`
--

CREATE TABLE IF NOT EXISTS `videojuegos` (
  `Codigo` int(4) NOT NULL,
  `Desarrolladora` varchar(50) NOT NULL,
  `NumJugadores` int(2) NOT NULL,
  `Online` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `videojuegos`
--

INSERT INTO `videojuegos` (`Codigo`, `Desarrolladora`, `NumJugadores`, `Online`) VALUES
(4, 'Dontnod Entertainment', 1, 0),
(8, 'Ape', 1, 0),
(14, 'KCE Japan', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visto`
--

CREATE TABLE IF NOT EXISTS `visto` (
`CodigoVisto` int(3) NOT NULL,
  `CodigoUsuario` int(3) NOT NULL,
  `Codigo` int(4) NOT NULL,
  `CodigoEpisodio` int(3) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `visto`
--

INSERT INTO `visto` (`CodigoVisto`, `CodigoUsuario`, `Codigo`, `CodigoEpisodio`) VALUES
(1, 2, 4, 2),
(4, 13, 7, 2),
(5, 13, 6, 1),
(6, 13, 1, 0),
(7, 13, 16, 0),
(8, 13, 17, 0),
(9, 13, 8, 0),
(10, 13, 8, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anime`
--
ALTER TABLE `anime`
 ADD PRIMARY KEY (`Codigo`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
 ADD PRIMARY KEY (`CodigoComentario`);

--
-- Indices de la tabla `comics`
--
ALTER TABLE `comics`
 ADD PRIMARY KEY (`Codigo`);

--
-- Indices de la tabla `episodios`
--
ALTER TABLE `episodios`
 ADD PRIMARY KEY (`CodigoCapitulo`);

--
-- Indices de la tabla `estrenos`
--
ALTER TABLE `estrenos`
 ADD PRIMARY KEY (`CodEstreno`), ADD KEY `CodEstreno` (`CodEstreno`);

--
-- Indices de la tabla `general`
--
ALTER TABLE `general`
 ADD PRIMARY KEY (`Codigo`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
 ADD PRIMARY KEY (`Codigo`), ADD UNIQUE KEY `ISBN` (`ISBN`);

--
-- Indices de la tabla `manga`
--
ALTER TABLE `manga`
 ADD PRIMARY KEY (`Codigo`);

--
-- Indices de la tabla `peliculas`
--
ALTER TABLE `peliculas`
 ADD PRIMARY KEY (`Codigo`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
 ADD PRIMARY KEY (`CodigoPersona`);

--
-- Indices de la tabla `plataformas`
--
ALTER TABLE `plataformas`
 ADD PRIMARY KEY (`CodigoPlataforma`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
 ADD PRIMARY KEY (`CodigoPersona`);

--
-- Indices de la tabla `series`
--
ALTER TABLE `series`
 ADD PRIMARY KEY (`Codigo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`CodUsuario`), ADD UNIQUE KEY `nombre` (`Nombre`), ADD UNIQUE KEY `mail` (`Mail`);

--
-- Indices de la tabla `videojuegos`
--
ALTER TABLE `videojuegos`
 ADD PRIMARY KEY (`Codigo`);

--
-- Indices de la tabla `visto`
--
ALTER TABLE `visto`
 ADD PRIMARY KEY (`CodigoVisto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
MODIFY `CodigoComentario` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT de la tabla `episodios`
--
ALTER TABLE `episodios`
MODIFY `CodigoCapitulo` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `estrenos`
--
ALTER TABLE `estrenos`
MODIFY `CodEstreno` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `general`
--
ALTER TABLE `general`
MODIFY `Codigo` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
MODIFY `CodigoPersona` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT de la tabla `plataformas`
--
ALTER TABLE `plataformas`
MODIFY `CodigoPlataforma` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `CodUsuario` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `visto`
--
ALTER TABLE `visto`
MODIFY `CodigoVisto` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `anime`
--
ALTER TABLE `anime`
ADD CONSTRAINT `anime_ibfk_1` FOREIGN KEY (`Codigo`) REFERENCES `general` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comics`
--
ALTER TABLE `comics`
ADD CONSTRAINT `comics_ibfk_1` FOREIGN KEY (`Codigo`) REFERENCES `general` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
ADD CONSTRAINT `libros_ibfk_1` FOREIGN KEY (`Codigo`) REFERENCES `general` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `manga`
--
ALTER TABLE `manga`
ADD CONSTRAINT `manga_ibfk_1` FOREIGN KEY (`Codigo`) REFERENCES `general` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `peliculas`
--
ALTER TABLE `peliculas`
ADD CONSTRAINT `peliculas_ibfk_1` FOREIGN KEY (`Codigo`) REFERENCES `general` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rol`
--
ALTER TABLE `rol`
ADD CONSTRAINT `rol_ibfk_1` FOREIGN KEY (`CodigoPersona`) REFERENCES `personas` (`CodigoPersona`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `series`
--
ALTER TABLE `series`
ADD CONSTRAINT `series_ibfk_1` FOREIGN KEY (`Codigo`) REFERENCES `general` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `videojuegos`
--
ALTER TABLE `videojuegos`
ADD CONSTRAINT `videojuegos_ibfk_1` FOREIGN KEY (`Codigo`) REFERENCES `general` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
