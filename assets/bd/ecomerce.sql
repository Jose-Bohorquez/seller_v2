-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 31-01-2025 a las 14:00:50
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ecomerce`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carousel`
--

CREATE TABLE `carousel` (
  `id_img` int NOT NULL COMMENT 'id unico de cada imagen',
  `nombre_img` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL COMMENT 'nombre de la imagen',
  `ruta_img` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL COMMENT 'ruta de donde se almacena la imagen',
  `estado` int DEFAULT NULL COMMENT 'estado de la imagen 1 se muestra 0 no se muestra'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `id_category` int NOT NULL COMMENT 'id unico de cada categoria',
  `name_category` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL COMMENT 'nombre de la categoria general',
  `desc_category` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL COMMENT 'descripcion general de la categoria'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`id_category`, `name_category`, `desc_category`) VALUES
(3, 'papos', 'zapateria general'),
(4, 'maletas', 'morrales'),
(5, 'bolsos', 'bolsos'),
(7, 'otros', 'categoria pra otros productos en general o sin categorizar'),
(8, 'Computadores', 'todos los computadores');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL COMMENT 'identificador unico de cada producto',
  `name` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL COMMENT 'nombre de cada producto',
  `description` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL COMMENT 'descripcion general de cada producto',
  `technical_description` varchar(2000) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL COMMENT 'descripcion tecnica detallada de cada producto',
  `price` int NOT NULL COMMENT 'precio o valor por uindad del producto',
  `amount` int DEFAULT NULL COMMENT 'cantidad disponible de cada producto',
  `category` int DEFAULT NULL COMMENT 'categoria a la que pertenece cada producto',
  `image` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL COMMENT 'imagen de cada producto',
  `discount` int NOT NULL COMMENT 'descuento que se aplica al producto',
  `final_price` int GENERATED ALWAYS AS ((`price` - ((`price` * `discount`) / 100))) STORED COMMENT 'valor final a pagar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `technical_description`, `price`, `amount`, `category`, `image`, `discount`) VALUES
(10, 'bolso de mano', 'de mano', 'bolso bolso de mano', 70000, 10, 7, 'assets/images/products/Bolsodemano/840023257179001750Wx750H.webp', 1),
(14, 'multi', 'multi', 'multi', 100000, 100, 4, 'assets/images/products/Multi/1.webp', 1),
(15, 'compu', 'todo en uno', 'computador, todo en uno, con teclado y mouse', 200000, 7, 8, 'assets/images/products/Compu/198415262608001750Wx750H.webp', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int NOT NULL COMMENT 'identificador unico de cada rol',
  `name_rol` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL COMMENT 'nombre unico de cada rol'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `name_rol`) VALUES
(1, 'Super-Admin'),
(2, 'Admin'),
(3, 'Seller'),
(4, 'User');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL COMMENT 'identificador unico de cada usuario',
  `name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT 'nombres de cada usuario',
  `lastname` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT 'apellidos de cada usuario',
  `id_number` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT 'numero de identificacion de cada usuario',
  `cel` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT 'numero de telefono de cada usuario',
  `email` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT 'correo electronico de cada usuario',
  `pass` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci COMMENT 'contraseña del usuario',
  `rol` int DEFAULT NULL COMMENT 'rol de cada uno de los usuarios',
  `image_profile` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT 'ruta de donde se almacena la imagen '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `name`, `lastname`, `id_number`, `cel`, `email`, `pass`, `rol`, `image_profile`) VALUES
(6, 'jose', 'bohorquez', '1119217998', '3178773186', 'admin@gmail.com', '$2y$10$EO/O2ziVhd.kDOyQk9bWQOLHGw0qzsuQMtnygFrNLAgjyfZRBENnG', 4, 'assets/images/profile/1119217998/3135768.png'),
(9, 'z', 'z', '902', '902', 'z@gmail.com', '$2y$10$CAyubu3rZr8uNNp1UeNm8ubN3Wr/v9t3NTWsK2UFH3PUNvg/6bTd.', 3, 'z'),
(10, 'y', 'y', '909', '909', 'y@gmail.com', '$2y$10$old.G0pffybN/hF258i3M.le/elNB7qRDTtuTxDR3PlgnYg5yOGV.', 1, 'y'),
(11, 'x', 'x', '900', '900', 'x@gmail.com', '$2y$10$SlDuvFTgp0HSVqXGIf78puD8Zob2JsT3hmdN3x4G0tCII3FUHezdC', 2, 'x'),
(12, 'q', 'q', '2355', '2355', 'q@gmail.com', '$2y$10$dJjcPRFgnmJMPbkJbUTXrOi0P7hmmg2zKMMajw7Rc8zbpk4jYsBwq', 1, 'assets/images/profile/2355/rc.webp'),
(13, 'N/A', 'N/A', '0', '0', 'na@gmail.com', '$2y$10$KeS/RMiHacQn.5x9cz2uGus3/lveRoS2OFhXsB4aeD5hVh6w/ysvy', 4, 'assets/images/profile/0/perfil.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_confirmations`
--

CREATE TABLE `user_confirmations` (
  `id` int NOT NULL COMMENT 'id unico de confirmacion',
  `user_id` int NOT NULL COMMENT 'id del usuario autenticado',
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL COMMENT 'token de la autenticacion ',
  `created_at` timestamp NULL DEFAULT (now()) COMMENT 'dato de la fecha de autenticacion '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`id_img`);

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `image` (`image`),
  ADD KEY `FK_products_category` (`category`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cel` (`cel`),
  ADD UNIQUE KEY `id_number` (`id_number`),
  ADD KEY `FK_user_rol` (`rol`);

--
-- Indices de la tabla `user_confirmations`
--
ALTER TABLE `user_confirmations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carousel`
--
ALTER TABLE `carousel`
  MODIFY `id_img` int NOT NULL AUTO_INCREMENT COMMENT 'id unico de cada imagen';

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int NOT NULL AUTO_INCREMENT COMMENT 'id unico de cada categoria', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'identificador unico de cada producto', AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int NOT NULL AUTO_INCREMENT COMMENT 'identificador unico de cada rol', AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT COMMENT 'identificador unico de cada usuario', AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `user_confirmations`
--
ALTER TABLE `user_confirmations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'id unico de confirmacion';

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_products_category` FOREIGN KEY (`category`) REFERENCES `category` (`id_category`);

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_user_rol` FOREIGN KEY (`rol`) REFERENCES `rol` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
