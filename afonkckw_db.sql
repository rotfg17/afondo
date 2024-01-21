-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-01-2024 a las 20:12:03
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
(1, 'Con más de un mes sin audiencias, Operación Medusa vuelve a conocerse este viernes', 'Las vistas se retoman luego de que la corte de apelación rechazara la recusación del juez', '<p>El <strong>juez</strong> Amauri Martínez, del Segundo Juzgado de Instrucción del Distrito Nacional, retoma hoy las <strong>audiencias</strong> del <strong>juicio</strong> preliminar de <strong>Operación Medusa</strong>, caso de <strong>corrupción</strong> que involucra al exprocurador general <strong>Jean Alain Rodríguez</strong> y a otras 62 personas físicas y jurídicas.</p><p>El <strong>proceso</strong>, que estaba estancado desde el 15 de diciembre, continuará este viernes, después que la Primera Sala Penal de la Corte de Apelación rechazara ayer la <strong>recusación</strong> contra Martínez, la cual interpuso el defensor público Dukaski Payano Taveras, representante del imputado Félix Antonio Rosario.</p><p>La pasada semana la <strong>Suprema Corte</strong> de Justicia (SCJ) denegó la declinatoria por <strong>sospecha ilegítima</strong> que hiciera también Payano Taveras contra todo el pleno de la Corte de Apelación del Distrito Nacional, lo que impedía que una sala de esa jurisdicción conociera la <strong>recusación</strong> contra el <strong>juez</strong> Amauri.</p>', '2024-01-20 00:40:52', 0, 1, 1, ''),
(2, 'Bajan precios de algunos combustibles de menor uso en República Dominicana', 'Principales combustibles mantendrán sus precios invariables', '<p>El viceministro de Comercio Interno del&nbsp;Ministerio de Industria, Comercio y Mipymes (MICM), <strong>Ramón Pérez Fermín</strong>, informó este viernes que el gobierno se dispone a seguir subsidiando los <strong>combustibles</strong> de mayor uso doméstico, aplicando casi 25 pesos de subsidio por galón al gasoil regular y más de 17 pesos al gasoil óptimo.</p><p>Pérez Fermín explicó que, según una nota de prensa, también se dispuso mantener un subsidio de casi 10 pesos al Gas Licuado de Petróleo (GLP), con el objetivo de no transferir las alzas del&nbsp;<strong>precio internacional</strong> a los precios de venta al público en el mercado local.</p>', '2024-01-20 00:43:01', 0, 6, 1, ''),
(3, 'Luis Miguel, el \"sol divino\" de México, conquista Santo Domingo', 'Durante su actuación de una hora y media no tuvo interacción con el público', '<p>Con la entrada abierta desde antes de las 8:00 de la tarde, el <strong>Estadio Olímpico</strong> volvió a llenarse de seguidores del <strong>cantante mexicano</strong>, y todo ello pese a haber pospuesto el <strong>concierto</strong> por problemas técnicos el día anterior.</p><p>Como era casi de esperar, <strong>Luis Miguel</strong> conquistó los corazones de todos los asistentes durante la más de hora y media de <strong>espectáculo musical</strong> y visual, manteniendo al público cantando, bailando y saltando.&nbsp;</p><p>Todo comenzó con <strong>luces rojas</strong>, animaciones de la carrera musical del cantante y los músicos de fondo bajo las tres monumentales pantallas que componían el <strong>escenario</strong>, hasta que <strong>Luis Miguel</strong> \"amaneció\" en el <strong>escenario</strong> con un sol naranja e imponente de fondo.&nbsp;</p>', '2024-01-20 01:00:06', 0, 4, 1, ''),
(4, 'Juan Soto bateará segundo en la alineación de los Yanquis de Nueva York', 'El dirigente del equipo, Aaron Boone, tiene claro quien estará detrás de él, pero no delante', '<p>El <strong>dirigente</strong> de los <strong>Yanquis</strong> de Nueva York, <strong>Aaron Boone</strong>, reveló en una entrevista en el Podcast Foul Territory con el ex jugador de Grandes Ligas, Todd Frazier, que el jardinero dominicano, <strong>Juan Soto</strong> bateará segundo en la alineación.&nbsp;</p><p>Soto llegó a los <strong>Yanquis</strong> en una <strong>transacción</strong> realizada en la temporada muerta junto a Trent Grisham y estará jugando en su última temporada antes de convertirse en <strong>agente libre</strong> por primera vez en su carrera.&nbsp;</p><p>\"En realidad si, piendo en eso todo el tiempo, ahora mismo Juan en el <strong>segundo puesto</strong> y Judge <strong>tercero</strong>, pero hay que ver como sale lo del primer puesto en la alineación\", respondió Boone a la pregunta de Frazier sobre el orden de bateo.&nbsp;</p>', '2024-01-20 01:01:40', 0, 2, 1, ''),
(8, 'Nueva cinta de Jennifer López aborda el rumor de que es \"adicta al sexo\"', 'El amor y la música se unen en \'This Is Me... Now\' de Jennifer López', '<p>La cantante <strong>Jennifer López</strong> llegará a <strong>Prime Video</strong> con su nueva <strong>cinta</strong> \'<strong>This Is Me... Now</strong>: A Love Story\', una mirada profunda a su carrera y relaciones románticas a lo largo de su vida. Este se estrenará el próximo 16 de febrero, día que también será lanzado su nuevo álbum \'<strong>This Is Me... Now</strong>\', un homenaje a su disco producido en 2002.</p><h2><strong>¿Jennifer López es una \'adicta al sexo\'?</strong></h2><p>La nueva producción la tendrá a ella como protagonista <strong>y contará</strong> con un elenco que le ayudará a dramatizar algunos aspectos reales de su vida. Entre el reparto se destacan varias estrellas como Fat Joe, Trevor Noah y Kim Petras, Post Malone, Keke Palmer, Sofía Vergara, Jenifer Lewis, Jay Shetty, Neil deGrasse Tyson, Sadhguru, Derek Hough y su esposo Ben Affleck.</p><p>&nbsp;</p><p>El <strong>tráiler</strong> fue <strong>lanzado</strong> hace unas horas y la intérprete de \'On the floor\' comenzó con una voz en off, en la que expresó: \"Sé lo que dicen de mí, sobre románticos empedernidos, que somos débiles, pero no soy débil\".</p><p>Como señala el medio \"El tiempo\", el corto de más de dos minutos dejó ver varios momentos en que sus <strong>relaciones fallidas</strong> no tuvieron éxito. Las escenas mostraron sus compromisos con diferentes hombres, los problemas que tuvieron dentro de la relación y una historia sobre la eterna búsqueda del <strong>amor</strong>.</p><p>\"He aprendido por las malas. No todas las <strong>historias de amor</strong> tienen un <strong>final feliz</strong>\", expresó la actriz en su película.</p>', '2024-01-20 01:59:27', 0, 4, 1, ''),
(9, 'Tribunal español reconoce derecho a indemnización por robo de joyas a Daddy Yankee en hotel', 'El cantante y su esposa deben ser indemnizados con $908,950 por el robo de las prendas en el 2018', '<p>Un <strong>tribunal</strong> español ha reconocido al <strong>cantante</strong> puertorriqueño <strong>Daddy Yankee</strong> y a su esposa el derecho a ser <strong>indemnizados</strong> con $908,950 por el <strong>robo</strong> de unas <strong>joyas</strong> de su propiedad en la habitación de un <strong>hotel</strong> en España en 2018.</p><p>Según informó este viernes el <strong>Tribunal</strong> Superior de Justicia de la región española de la <strong>Comunidad Valenciana</strong>, la Audiencia de <strong>Valencia</strong>, la ciudad donde se produjo el <strong>robo</strong>, estima parcialmente su recurso de apelación contra una sentencia anterior que rechazaba la demanda interpuesta por el matrimonio y un hermano de la esposa.</p><p>El <strong>artista</strong> puertorriqueño, considerado el ´rey del <strong>reguetón</strong>´, se encontraba en la ciudad para participar en el festival <strong>Latin Fest de Gandia</strong> en agosto de 2018, con una gran cantidad de <strong>joyas</strong> con las que suele viajar pues \"complementan su aspecto durante los conciertos\".</p><p>&nbsp;</p><p><a href=\"https://www.diariolibre.com/revista/daddy-yankee-denuncia-robo-millonario-en-hotel-AG10529180\"><strong>Daddy Yankee</strong></a>sostiene que depositó en la <strong>caja fuerte</strong> dos relojes, tres cadenas, una cruz, cuatro brazaletes, tres anillos y un par de pendientes de diamantes valorado todo ello en 1,052.500 dólares.</p><p>Su <strong>cuñado</strong>, que también viajaba con la pareja, depositó en la <strong>caja fuerte</strong> de su habitación un cordón de oro valorado en más de $20, 000 y 4,200 euros en <strong>efectivo</strong>.</p><p>La Audiencia recuerda en su resolución, que se puede recurrir ante el <strong>Tribunal</strong> Supremo español, que los apelantes se alojaron en un moderno <strong>hotel</strong> de cuatro estrellas, cuyas habitaciones están dotadas de \"una <strong>medida de seguridad</strong> específica\" para enseres valiosos como es la <strong>caja fuerte</strong>.</p>', '2024-01-20 02:06:41', 0, 4, 1, ''),
(10, 'Natacha Batlle, una poeta canina y nebulosa', 'Esta poeta, originaria de Hato Mayor, ha sido profesora, artesana y pasajera ambulante de las calles', '<p>Hace unos años, el <strong>escritor</strong> <strong>dominicano</strong>&nbsp;Claudio Troisemme dijo que Natacha Batlle hace que una <strong>noche</strong> en el parque Duarte se convierta en palacios de la destrucción. Probablemente tenga razón, pues, esta poeta, originaria de Hato Mayor, ha sido profesora, artesana y pasajera ambulante de las calles de Santo Domingo.</p><p>En <strong>libros</strong> como Bajo la piel de la aguja, La muerte en cuatro o Fisionomía de un dedo con plumas, Natacha explora preocupaciones como la <strong>muerte</strong>, la tristeza y su visión estética del mundo. A la vez, hace apuntes de intención puramente política, es decir, social.</p>', '2024-01-20 02:08:16', 0, 4, 1, ''),
(11, 'Nicky Jam, Yovngchimi y Ángel Dior se unen en nuevo tema ', 'El sencillo es presentado por Legado Urbano, la compañía fundada por Álex Gárgolas', '<p>Los artistas puertorriqueños <strong>Nicky Jam</strong> y <strong>Yovngchimi</strong>, junto al intérprete urbano dominicano <strong>Ángel Dior</strong>, unen sus talentos en una colaboración cargada de la fuerza y el ritmo característico del <strong>dembow</strong>, titulado \"<strong>Las Gatas</strong>\".</p><p>Nicky, pilar del <strong>reggaetón</strong>; <strong>Yovngchimi</strong>, quien ya ha creado un nombre respetable dentro del <strong>trap</strong>; y <strong>Ángel Dior</strong>, uno de los dembowseros más sólidos de la industria, llegan con una canción fresca que promete conquistar las listas de reproducción de los amantes del género, destaca una nota de prensa.</p><p>El sencillo es presentado por <strong>Legado Urbano</strong>, la compañía fundada por Álex Gárgolas, Tuti Díaz y Michael Villalobos, quienes por décadas han sido jugadores importantes en la industria musical y que con esta empresa buscan recuperar y redefinir los sonidos de la <strong>música latina</strong> del momento.</p>', '2024-01-20 02:23:04', 0, 4, 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autor`
--

CREATE TABLE `autor` (
  `id` int(11) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `region` varchar(100) NOT NULL,
  `activo` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `autor`
--

INSERT INTO `autor` (`id`, `nombres`, `email`, `region`, `activo`) VALUES
(1, 'Andreina Chalas', 'afondoconandreina@gmail.com', 'El Seibo', 1);

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
(15, 'Turismo', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `autor`
--
ALTER TABLE `autor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
