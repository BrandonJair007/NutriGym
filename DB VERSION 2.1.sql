-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-05-2026 a las 19:58:59
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `nutrigym`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimentos`
--

CREATE TABLE `alimentos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `categoria` enum('fruta','verdura','carne','cereal','lacteo','otro') NOT NULL,
  `proteina` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Gramos de proteína por 100g',
  `carbohidratos` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Gramos de carbohidratos por 100g',
  `grasas` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Gramos de grasas por 100g',
  `fibra` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Gramos de fibra por 100g',
  `azucar` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Gramos de azúcar por 100g',
  `calorias` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Calorías por 100g',
  `sodio` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Miligramos de sodio por 100g',
  `potasio` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Miligramos de potasio por 100g',
  `calcio` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Miligramos de calcio por 100g',
  `hierro` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Miligramos de hierro por 100g',
  `unidad_medida` varchar(255) NOT NULL DEFAULT 'g' COMMENT 'Unidad de medida (g, ml, unidad)',
  `tamanio_porcion` decimal(8,2) NOT NULL DEFAULT 100.00 COMMENT 'Tamaño de porción estándar',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `alimentos`
--

INSERT INTO `alimentos` (`id`, `nombre`, `categoria`, `proteina`, `carbohidratos`, `grasas`, `fibra`, `azucar`, `calorias`, `sodio`, `potasio`, `calcio`, `hierro`, `unidad_medida`, `tamanio_porcion`, `created_at`, `updated_at`) VALUES
(1, 'Pechuga de pollo', 'carne', 31.00, 0.00, 3.60, 0.00, 0.00, 165.00, 74.00, 256.00, 15.00, 1.00, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(2, 'Salmón', 'carne', 25.00, 0.00, 13.00, 0.00, 0.00, 208.00, 59.00, 384.00, 12.00, 0.80, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(3, 'Atún en agua', 'carne', 25.00, 0.00, 1.00, 0.00, 0.00, 116.00, 50.00, 237.00, 8.00, 1.00, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(4, 'Carne de res magra', 'carne', 26.00, 0.00, 15.00, 0.00, 0.00, 250.00, 65.00, 318.00, 12.00, 2.60, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(5, 'Huevo entero', 'otro', 13.00, 1.10, 11.00, 0.00, 1.10, 155.00, 124.00, 126.00, 50.00, 1.80, 'unidad', 50.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(6, 'Clara de huevo', 'otro', 11.00, 0.70, 0.20, 0.00, 0.70, 52.00, 166.00, 163.00, 7.00, 0.10, 'unidad', 33.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(7, 'Queso cottage', 'lacteo', 11.00, 3.40, 4.30, 0.00, 2.70, 98.00, 364.00, 104.00, 83.00, 0.10, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(8, 'Yogur griego natural', 'lacteo', 10.00, 3.60, 0.40, 0.00, 3.60, 59.00, 36.00, 141.00, 110.00, 0.10, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(9, 'Leche desnatada', 'lacteo', 3.40, 5.00, 0.20, 0.00, 5.00, 34.00, 42.00, 156.00, 125.00, 0.00, 'ml', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(10, 'Tofu firme', 'otro', 8.00, 1.90, 4.80, 0.30, 0.60, 76.00, 7.00, 121.00, 350.00, 1.10, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(11, 'Arroz integral cocido', 'cereal', 2.60, 23.00, 0.90, 1.80, 0.40, 112.00, 1.00, 43.00, 10.00, 0.40, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(12, 'Avena en hojuelas', 'cereal', 13.00, 66.00, 7.00, 10.00, 1.00, 379.00, 6.00, 362.00, 52.00, 4.30, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(13, 'Pan integral', 'cereal', 13.00, 41.00, 3.50, 7.00, 5.00, 247.00, 455.00, 254.00, 107.00, 2.50, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(14, 'Quinoa cocida', 'cereal', 4.40, 21.00, 1.90, 2.80, 0.90, 120.00, 7.00, 172.00, 17.00, 1.50, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(15, 'Pasta integral cocida', 'cereal', 5.00, 25.00, 0.50, 3.50, 1.00, 124.00, 2.00, 44.00, 10.00, 1.00, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(16, 'Batata cocida', 'verdura', 1.60, 20.00, 0.10, 3.00, 6.50, 86.00, 55.00, 337.00, 30.00, 0.60, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(17, 'Maíz dulce', 'verdura', 3.30, 19.00, 1.40, 2.40, 3.20, 86.00, 15.00, 270.00, 2.00, 0.50, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(18, 'Garbanzos cocidos', 'otro', 8.00, 27.00, 2.40, 8.00, 4.80, 139.00, 7.00, 291.00, 49.00, 2.90, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(19, 'Lentejas cocidas', 'otro', 9.00, 20.00, 0.40, 8.00, 1.80, 116.00, 2.00, 369.00, 19.00, 3.30, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(20, 'Plátano', 'fruta', 1.10, 22.80, 0.30, 2.60, 12.20, 89.00, 1.00, 358.00, 5.00, 0.30, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(21, 'Aguacate', 'fruta', 2.00, 8.50, 14.70, 6.70, 0.70, 160.00, 7.00, 485.00, 12.00, 0.60, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(22, 'Almendras', 'otro', 21.00, 22.00, 50.00, 12.00, 4.40, 579.00, 1.00, 733.00, 269.00, 3.70, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(23, 'Nueces', 'otro', 15.00, 14.00, 65.00, 7.00, 2.60, 654.00, 2.00, 441.00, 98.00, 2.90, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(24, 'Aceite de oliva', 'otro', 0.00, 0.00, 100.00, 0.00, 0.00, 884.00, 0.00, 1.00, 1.00, 0.60, 'ml', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(25, 'Mantequilla de maní', 'otro', 25.00, 20.00, 50.00, 6.00, 9.00, 588.00, 459.00, 649.00, 49.00, 1.90, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(26, 'Semillas de chía', 'otro', 17.00, 42.00, 31.00, 34.00, 0.00, 486.00, 16.00, 407.00, 631.00, 7.70, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(27, 'Coco rallado', 'fruta', 3.30, 15.00, 33.00, 9.00, 6.20, 354.00, 20.00, 356.00, 14.00, 2.40, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(28, 'Queso cheddar', 'lacteo', 25.00, 1.30, 33.00, 0.00, 0.50, 404.00, 621.00, 98.00, 721.00, 0.70, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(29, 'Salmón ahumado', 'carne', 22.00, 0.00, 12.00, 0.00, 0.00, 117.00, 784.00, 175.00, 11.00, 0.90, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(30, 'Aceitunas verdes', 'verdura', 1.00, 6.00, 11.00, 3.20, 0.00, 115.00, 872.00, 8.00, 52.00, 0.50, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(31, 'Brócoli cocido', 'verdura', 2.40, 7.00, 0.40, 3.30, 1.40, 35.00, 41.00, 293.00, 40.00, 0.70, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(32, 'Espinaca cruda', 'verdura', 2.90, 3.60, 0.40, 2.20, 0.40, 23.00, 79.00, 558.00, 99.00, 2.70, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(33, 'Zanahoria cruda', 'verdura', 0.90, 10.00, 0.20, 2.80, 4.70, 41.00, 69.00, 320.00, 33.00, 0.30, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(34, 'Tomate', 'verdura', 0.90, 3.90, 0.20, 1.20, 2.60, 18.00, 5.00, 237.00, 10.00, 0.30, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(35, 'Pimiento rojo', 'verdura', 0.90, 6.00, 0.30, 2.10, 4.20, 31.00, 4.00, 211.00, 7.00, 0.40, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(36, 'Cebolla', 'verdura', 1.10, 9.00, 0.10, 1.70, 4.20, 40.00, 4.00, 146.00, 23.00, 0.20, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(37, 'Ajo', 'verdura', 6.40, 33.00, 0.50, 2.10, 1.00, 149.00, 17.00, 401.00, 181.00, 1.70, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(38, 'Coliflor', 'verdura', 1.90, 5.00, 0.30, 2.00, 1.90, 25.00, 30.00, 299.00, 22.00, 0.40, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(39, 'Calabacín', 'verdura', 1.20, 3.10, 0.30, 1.00, 2.50, 17.00, 8.00, 261.00, 16.00, 0.40, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(40, 'Berenjena', 'verdura', 1.00, 6.00, 0.20, 3.00, 3.50, 25.00, 2.00, 229.00, 9.00, 0.20, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(41, 'Manzana', 'fruta', 0.30, 14.00, 0.20, 2.40, 10.40, 52.00, 1.00, 107.00, 6.00, 0.10, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(42, 'Naranja', 'fruta', 0.90, 11.80, 0.10, 2.40, 9.40, 47.00, 0.00, 181.00, 40.00, 0.10, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(43, 'Fresa', 'fruta', 0.70, 7.70, 0.30, 2.00, 4.90, 32.00, 1.00, 153.00, 16.00, 0.40, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(44, 'Uvas rojas', 'fruta', 0.60, 18.00, 0.40, 0.90, 16.00, 69.00, 2.00, 191.00, 10.00, 0.40, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(45, 'Piña', 'fruta', 0.50, 13.00, 0.10, 1.40, 10.00, 50.00, 1.00, 109.00, 13.00, 0.30, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(46, 'Mango', 'fruta', 0.80, 15.00, 0.40, 1.60, 14.00, 60.00, 1.00, 168.00, 11.00, 0.20, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(47, 'Pera', 'fruta', 0.40, 15.00, 0.10, 3.10, 10.00, 57.00, 1.00, 116.00, 9.00, 0.20, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(48, 'Melón', 'fruta', 0.80, 8.00, 0.20, 0.90, 8.00, 34.00, 16.00, 267.00, 9.00, 0.20, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(49, 'Sandía', 'fruta', 0.60, 7.60, 0.20, 0.40, 6.20, 30.00, 1.00, 112.00, 7.00, 0.20, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59'),
(50, 'Kiwi', 'fruta', 1.10, 14.70, 0.50, 3.00, 9.00, 61.00, 3.00, 312.00, 34.00, 0.30, 'g', 100.00, '2026-04-16 21:33:59', '2026-04-16 21:33:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion_menus`
--

CREATE TABLE `asignacion_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_usuario` bigint(20) UNSIGNED NOT NULL,
  `calorias` int(11) NOT NULL,
  `tipo` enum('desayuno','almuerzo','cena','otro') NOT NULL,
  `fecha_asignacion` date NOT NULL,
  `validado` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `asignacion_menus`
--

INSERT INTO `asignacion_menus` (`id`, `id_usuario`, `calorias`, `tipo`, `fecha_asignacion`, `validado`, `created_at`, `updated_at`) VALUES
(1, 32, 227, 'desayuno', '2026-05-05', 0, '2026-05-05 08:00:03', '2026-05-05 08:00:03'),
(2, 32, 956, 'almuerzo', '2026-05-05', 0, '2026-05-05 08:00:09', '2026-05-05 08:00:09'),
(3, 32, 653, 'cena', '2026-05-05', 0, '2026-05-05 08:00:12', '2026-05-05 08:00:12'),
(4, 23, 528, 'desayuno', '2026-05-06', 0, '2026-05-06 06:38:01', '2026-05-06 06:38:01'),
(5, 23, 769, 'desayuno', '2026-05-06', 0, '2026-05-06 07:27:08', '2026-05-06 07:27:08'),
(6, 23, 172, 'cena', '2026-05-06', 0, '2026-05-06 07:27:11', '2026-05-06 07:27:11'),
(7, 23, 540, 'almuerzo', '2026-05-06', 0, '2026-05-06 22:08:50', '2026-05-06 22:08:50'),
(8, 23, 327, 'almuerzo', '2026-05-06', 0, '2026-05-06 22:43:59', '2026-05-06 22:43:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion_objetivo`
--

CREATE TABLE `asignacion_objetivo` (
  `id_asignacion` bigint(20) UNSIGNED NOT NULL,
  `id_usuario` bigint(20) UNSIGNED NOT NULL,
  `id_objetivo` bigint(20) UNSIGNED NOT NULL,
  `fecha_asignacion` date NOT NULL,
  `estado` enum('activo','completado','pendiente') NOT NULL DEFAULT 'pendiente',
  `calificacion` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `asignacion_objetivo`
--

INSERT INTO `asignacion_objetivo` (`id_asignacion`, `id_usuario`, `id_objetivo`, `fecha_asignacion`, `estado`, `calificacion`, `created_at`, `updated_at`) VALUES
(30, 32, 1, '2026-05-05', 'activo', NULL, '2026-05-05 08:01:38', '2026-05-05 08:01:38'),
(31, 32, 4, '2026-05-05', 'activo', NULL, '2026-05-05 08:01:38', '2026-05-05 08:01:38'),
(32, 32, 5, '2026-05-05', 'activo', NULL, '2026-05-05 08:01:38', '2026-05-05 08:01:38'),
(33, 23, 1, '2026-05-06', 'activo', NULL, '2026-05-06 06:38:25', '2026-05-06 06:38:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion_preferencia`
--

CREATE TABLE `asignacion_preferencia` (
  `id_asignacion` bigint(20) UNSIGNED NOT NULL,
  `id_usuario` bigint(20) UNSIGNED NOT NULL,
  `id_preferencia` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL DEFAULT curdate(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `asignacion_preferencia`
--

INSERT INTO `asignacion_preferencia` (`id_asignacion`, `id_usuario`, `id_preferencia`, `fecha`, `created_at`, `updated_at`) VALUES
(34, 32, 5, '2026-05-05', '2026-05-05 08:02:05', '2026-05-05 08:02:05'),
(35, 23, 4, '2026-05-06', '2026-05-06 06:38:35', '2026-05-06 06:38:35'),
(36, 23, 2, '2026-05-06', '2026-05-06 22:50:18', '2026-05-06 22:50:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medidas`
--

CREATE TABLE `medidas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_usuario` bigint(20) UNSIGNED NOT NULL,
  `peso` decimal(5,2) NOT NULL,
  `talla` decimal(5,2) NOT NULL,
  `edad` int(11) NOT NULL,
  `genero` enum('M','F') NOT NULL,
  `circunferencia_brazo` decimal(5,2) DEFAULT NULL,
  `circunferencia_antebrazo` decimal(5,2) DEFAULT NULL,
  `circunferencia_cintura` decimal(5,2) DEFAULT NULL,
  `circunferencia_caderas` decimal(5,2) DEFAULT NULL,
  `circunferencia_muslos` decimal(5,2) DEFAULT NULL,
  `circunferencia_pantorrilla` decimal(5,2) DEFAULT NULL,
  `circunferencia_cuello` decimal(5,2) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado_fisico` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `medidas`
--

INSERT INTO `medidas` (`id`, `id_usuario`, `peso`, `talla`, `edad`, `genero`, `circunferencia_brazo`, `circunferencia_antebrazo`, `circunferencia_cintura`, `circunferencia_caderas`, `circunferencia_muslos`, `circunferencia_pantorrilla`, `circunferencia_cuello`, `fecha_registro`, `estado_fisico`, `created_at`, `updated_at`) VALUES
(152, 32, 70.00, 175.00, 28, 'M', 32.00, 28.00, 85.00, 95.00, 55.00, 38.00, 38.00, '2026-05-05 02:58:16', 1, '2026-05-05 07:58:16', '2026-05-05 07:58:16'),
(153, 23, 69.00, 164.00, 25, 'M', 32.00, 28.00, 85.00, 95.00, 55.00, 38.00, 37.97, '2026-05-05 17:29:44', 1, '2026-05-05 22:29:44', '2026-05-05 22:29:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo` enum('desayuno','almuerzo','cena','otro') NOT NULL,
  `fecha` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_alimentos`
--

CREATE TABLE `menu_alimentos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asignacion_menu_id` bigint(20) UNSIGNED NOT NULL,
  `id_alimento` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `menu_alimentos`
--

INSERT INTO `menu_alimentos` (`id`, `asignacion_menu_id`, `id_alimento`, `created_at`, `updated_at`) VALUES
(1, 1, 16, '2026-05-05 08:00:03', '2026-05-05 08:00:03'),
(2, 1, 3, '2026-05-05 08:00:03', '2026-05-05 08:00:03'),
(3, 1, 40, '2026-05-05 08:00:03', '2026-05-05 08:00:03'),
(4, 2, 22, '2026-05-05 08:00:09', '2026-05-05 08:00:09'),
(5, 2, 32, '2026-05-05 08:00:09', '2026-05-05 08:00:09'),
(6, 2, 27, '2026-05-05 08:00:09', '2026-05-05 08:00:09'),
(7, 3, 26, '2026-05-05 08:00:12', '2026-05-05 08:00:12'),
(8, 3, 42, '2026-05-05 08:00:12', '2026-05-05 08:00:12'),
(9, 3, 14, '2026-05-05 08:00:12', '2026-05-05 08:00:12'),
(10, 4, 8, '2026-05-06 06:38:01', '2026-05-06 06:38:01'),
(11, 4, 30, '2026-05-06 06:38:01', '2026-05-06 06:38:01'),
(12, 4, 27, '2026-05-06 06:38:01', '2026-05-06 06:38:01'),
(13, 5, 15, '2026-05-06 07:27:08', '2026-05-06 07:27:08'),
(14, 5, 25, '2026-05-06 07:27:08', '2026-05-06 07:27:08'),
(15, 5, 47, '2026-05-06 07:27:08', '2026-05-06 07:27:08'),
(16, 6, 36, '2026-05-06 07:27:11', '2026-05-06 07:27:11'),
(17, 6, 30, '2026-05-06 07:27:11', '2026-05-06 07:27:11'),
(18, 6, 39, '2026-05-06 07:27:11', '2026-05-06 07:27:11'),
(19, 7, 33, '2026-05-06 22:08:50', '2026-05-06 22:08:50'),
(20, 7, 12, '2026-05-06 22:08:50', '2026-05-06 22:08:50'),
(21, 7, 14, '2026-05-06 22:08:50', '2026-05-06 22:08:50'),
(22, 8, 4, '2026-05-06 22:43:59', '2026-05-06 22:43:59'),
(23, 8, 46, '2026-05-06 22:43:59', '2026-05-06 22:43:59'),
(24, 8, 39, '2026-05-06 22:43:59', '2026-05-06 22:43:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_03_124123_create_roles', 1),
(5, '2025_10_03_124143_create_preferencias', 1),
(6, '2025_10_03_124150_create_usuarios', 1),
(7, '2025_10_03_124205_create_asignacion_preferencia', 1),
(8, '2025_10_03_124217_create_objetivos', 1),
(9, '2025_10_03_124227_create_medidas', 1),
(10, '2025_10_03_124233_create_progreso', 1),
(11, '2025_10_03_124240_create_alimentos', 1),
(12, '2025_10_03_124255_create_menus', 1),
(13, '2025_10_03_124300_create_asignacion_menu', 1),
(14, '2025_10_03_124305_create_menu_alimentos', 1),
(15, '2025_10_03_125056_create_asignacion_objetivo', 1),
(16, '2026_05_06_035056_add_remember_token_to_usuarios_table', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetivos`
--

CREATE TABLE `objetivos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `objetivos`
--

INSERT INTO `objetivos` (`id`, `nombre`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Pérdida de peso', 'Reducir grasa corporal y alcanzar un peso saludable mediante ejercicio y dieta balanceada', '2026-04-16 21:33:53', '2026-04-16 21:33:53'),
(2, 'Ganancia muscular', 'Aumentar masa muscular mediante entrenamiento de fuerza y superávit calórico controlado', '2026-04-16 21:33:53', '2026-04-16 21:33:53'),
(3, 'Mejora cardiovascular', 'Incrementar resistencia y salud del corazón con ejercicio aeróbico regular', '2026-04-16 21:33:53', '2026-04-16 21:33:53'),
(4, 'Aumento de fuerza', 'Desarrollar fuerza máxima mediante entrenamiento con cargas progresivas', '2026-04-16 21:33:53', '2026-04-16 21:33:53'),
(5, 'Definición muscular', 'Reducir porcentaje de grasa manteniendo masa muscular para mayor definición', '2026-04-16 21:33:53', '2026-04-16 21:33:53'),
(6, 'Control de calorías', 'Manejar consumo calórico según objetivos de peso y composición corporal', '2026-04-16 21:33:53', '2026-04-16 21:33:53'),
(7, 'Balance de macronutrientes', 'Optimizar proporción de proteínas, carbohidratos y grasas según necesidades', '2026-04-16 21:33:53', '2026-04-16 21:33:53'),
(8, 'Hidratación óptima', 'Mantener adecuada hidratación para rendimiento físico y salud general', '2026-04-16 21:33:53', '2026-04-16 21:33:53'),
(9, 'Suplementación deportiva', 'Uso estratégico de suplementos para potenciar resultados deportivos', '2026-04-16 21:33:53', '2026-04-16 21:33:53'),
(10, 'Alimentación limpia', 'Enfoque en alimentos naturales y mínimamente procesados para mejor salud', '2026-04-16 21:33:53', '2026-04-16 21:33:53'),
(11, 'Recomposición corporal', 'Perder grasa y ganar músculo simultáneamente mediante dieta y ejercicio precisos', '2026-04-16 21:33:53', '2026-04-16 21:33:53'),
(12, 'Rendimiento deportivo', 'Mejorar capacidades físicas específicas para deporte o disciplina particular', '2026-04-16 21:33:53', '2026-04-16 21:33:53'),
(13, 'Salud y bienestar', 'Enfoque integral en salud física, mental y nutricional para calidad de vida', '2026-04-16 21:33:53', '2026-04-16 21:33:53'),
(14, 'Preparación competitiva', 'Programa específico para competencias, shows o eventos deportivos', '2026-04-16 21:33:53', '2026-04-16 21:33:53'),
(15, 'Mantenimiento', 'Conservar logros alcanzados mediante hábitos sostenibles de ejercicio y nutrición', '2026-04-16 21:33:53', '2026-04-16 21:33:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preferencias`
--

CREATE TABLE `preferencias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo` enum('dieta','alergia') NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `preferencias`
--

INSERT INTO `preferencias` (`id`, `tipo`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'dieta', 'Vegetariano', '2026-04-16 21:33:53', '2026-04-16 21:33:53'),
(2, 'dieta', 'Vegano', '2026-04-16 21:33:53', '2026-04-16 21:33:53'),
(3, 'dieta', 'Sin Gluten', '2026-04-16 21:33:53', '2026-04-16 21:33:53'),
(4, 'dieta', 'Bajo en Azúcar', '2026-04-16 21:33:53', '2026-04-16 21:33:53'),
(5, 'alergia', 'Sin Lactosa', '2026-04-16 21:33:53', '2026-04-16 21:33:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `progreso`
--

CREATE TABLE `progreso` (
  `id_progreso` bigint(20) UNSIGNED NOT NULL,
  `id_medida` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `imc` decimal(5,2) DEFAULT NULL,
  `tmb` decimal(7,2) DEFAULT NULL,
  `porcentaje_grasa` decimal(5,2) DEFAULT NULL,
  `masa_grasa` decimal(5,2) DEFAULT NULL,
  `masa_magra` decimal(5,2) DEFAULT NULL,
  `masa_muscular` decimal(5,2) DEFAULT NULL,
  `porcentaje_musculo` decimal(5,2) DEFAULT NULL,
  `progreso` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `progreso`
--

INSERT INTO `progreso` (`id_progreso`, `id_medida`, `fecha`, `imc`, `tmb`, `porcentaje_grasa`, `masa_grasa`, `masa_magra`, `masa_muscular`, `porcentaje_musculo`, `progreso`, `created_at`, `updated_at`) VALUES
(152, 152, '2026-05-05', 22.86, 1658.75, 18.29, 11.86, 58.14, 31.98, 45.68, 1, '2026-05-05 07:58:16', '2026-05-05 07:58:16'),
(153, 153, '2026-05-05', 25.65, 1595.00, 22.48, 13.03, 55.97, 30.78, 44.61, 1, '2026-05-05 22:29:44', '2026-05-05 22:29:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre_rol` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre_rol`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', '2026-04-16 21:33:53', '2026-04-16 21:33:53'),
(2, 'Nutriólogo', '2026-04-16 21:33:53', '2026-04-16 21:33:53'),
(3, 'Entrenador', '2026-04-16 21:33:53', '2026-04-16 21:33:53'),
(4, 'Usuario', '2026-04-16 21:33:53', '2026-04-16 21:33:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('xvODvwrCsZ4amyloViSSpAciWZvbtk4EnSLxu66s', 23, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoielFTVG02djF6OUtKY3Z2T2g1aUI0Ukx6cHp4OU9vZmt5WFNhdkZYUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9ncmVzby9kYXRvcyI7czo1OiJyb3V0ZSI7czoxNDoicHJvZ3Jlc28uZGF0b3MiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyMzt9', 1778090197);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_cese` timestamp NULL DEFAULT NULL,
  `id_rol` bigint(20) UNSIGNED NOT NULL DEFAULT 4,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `fecha_nacimiento`, `contrasena`, `fecha_registro`, `fecha_cese`, `id_rol`, `created_at`, `updated_at`, `remember_token`) VALUES
(23, 'usuario1', 'usuario1@gmail.com', '2000-01-01', '$2y$12$MaFJRWqkTYQ6QodGpiT7feDhcrARTXGdyfLLdbWA2coLTg6Qh9sTy', '2026-05-05 05:53:39', NULL, 4, '2026-05-05 05:53:39', '2026-05-05 05:53:39', 'vYAyEGDSijAoJcUswLZGME1vQBBIceJctXwlkeEflMDdG1cbohSvS6OPpOZe'),
(24, 'usuario2', 'usuario2@gmail.com', '2000-01-01', '$2y$12$upWRhtleET0jfNLyFrhVkuA3FyNegmgnavz6ERXDsFb0moNwExTay', '2026-05-05 06:02:20', NULL, 4, '2026-05-05 06:02:20', '2026-05-05 06:02:20', NULL),
(25, 'usuario3', 'usuario3@gmail.com', '2000-11-01', '$2y$12$h2lRdbJDz4BH65eZs9lSrOFP3xbkiMeJ3cBzuuBLxCiwxSQyYaHyq', '2026-05-05 06:02:53', NULL, 4, '2026-05-05 06:02:53', '2026-05-05 06:02:53', NULL),
(26, 'usuario4', 'usuario4@gmail.com', '2000-01-01', '$2y$12$Pj/VZoAN.n/YTy2YZX83tuCp/fWqtoH/DLp3VNQVUckhlop11G6eu', '2026-05-05 06:03:28', NULL, 4, '2026-05-05 06:03:28', '2026-05-05 06:03:28', NULL),
(27, 'usuario5', 'usuario5@gmail.com', '2000-01-01', '$2y$12$8iW8HvDYkuWKvMsjL6qchOefxUVIGMkLN7rNAJYanlGPtwbAxngzm', '2026-05-05 06:04:05', NULL, 4, '2026-05-05 06:04:05', '2026-05-05 06:04:05', NULL),
(28, 'entrenador1', 'entrenador1@gmail.com', '2000-01-01', '$2y$12$6dUZBSZmzZft5TScb9rTOutL5T3siJ/UmxVIqRhbbtnRmD78efLta', '2026-05-05 06:04:54', NULL, 3, '2026-05-05 06:04:54', '2026-05-05 06:04:54', NULL),
(29, 'nutriologo1', 'nutriologo1@gmail.com', '2000-01-01', '$2y$12$/kP6AGixiFP88MGaKIztOeGQG3WT8qr3xFhi.x5BJfrBoE8HO8inu', '2026-05-05 06:06:21', NULL, 2, '2026-05-05 06:06:22', '2026-05-05 06:06:22', NULL),
(30, 'administrador', 'administrador@gmail.com', '2000-01-01', '$2y$12$/e3Cb8rCVrjdTwOmBSn1euDaL5QhNY7aVDItWu7LcV47w4CsvMY9K', '2026-05-05 06:07:35', NULL, 1, '2026-05-05 06:07:35', '2026-05-05 06:07:35', NULL),
(32, 'usuario6', 'usuario6@gmail.com', '2027-01-01', '$2y$12$JLCdZiVpYjg.XTYGbxXgLuN5Dv36scRIE3RbIGnnE4HS0ajq7n9Zi', '2026-05-05 07:55:56', NULL, 4, '2026-05-05 07:55:56', '2026-05-05 07:55:56', NULL),
(33, 'usuario7', 'usuario7@gmail.com', '2010-12-10', '$2y$12$aPhJm.qacyRUhejOaNMZYOe.IMYbJmmdKZRYQV3m154JTHRHutUiu', '2026-05-05 09:09:34', NULL, 4, NULL, NULL, NULL),
(35, 'nutriologo2', 'nutriologo2@gmail.com', '2000-02-21', '$2y$12$sPOxuDmMlcSvmBDplovWSuQ94jF38fts1B.wEiIWflh0SCMX/.TJC', '2026-05-05 19:49:37', NULL, 2, '2026-05-05 19:49:38', '2026-05-05 19:49:38', NULL),
(37, 'usuario10', 'usuario10@gmail.com', '2005-06-21', '$2y$12$bpy1ayVCZSSFoPdYctSwaeUG9lN.pTPkvbYAf4wKEBOk0gp5Fcxui', '2026-05-05 20:48:53', NULL, 4, '2026-05-05 20:48:53', '2026-05-05 20:48:53', NULL),
(38, 'usuario11', 'usuario11@gmail.com', '2008-05-05', '$2y$12$WljjpAZ1zObk4ZzhoQNNBeKOGfHUVn9pldPMMEhn9r8cBPa/UtDt6', '2026-05-05 20:50:28', NULL, 4, '2026-05-05 20:50:29', '2026-05-05 20:50:29', NULL),
(39, 'usuario12', 'usuario12@gmail.com', '2025-02-25', '$2y$12$pqSw0WZf1ZsJFfAXxTK3kueNgvLOWD1h..odWdEG3Ep3FtL3ZSn/G', '2026-05-05 21:10:44', NULL, 4, '2026-05-05 21:10:44', '2026-05-05 21:10:44', NULL),
(40, 'usuario13', 'usuario13@gmail.com', '2025-02-25', '$2y$12$uDO.JjeGlI3dE.js2giXWOYMb8f9vdPwJf1aQcmDjcms62cssciBK', '2026-05-05 21:13:12', NULL, 4, '2026-05-05 21:13:12', '2026-05-05 21:13:12', NULL),
(41, 'usuario14', 'usuario14@gmail.com', '2024-05-25', '$2y$12$eHbPpPX2GDvDQfBPKVjuBO7wZ9tEA2Yx5Nc8T3ig4Ta.UKTCakec.', '2026-05-05 21:13:53', NULL, 4, '2026-05-05 21:13:53', '2026-05-05 21:13:53', NULL),
(44, 'usuario15', 'usuario15@gmail.com', '2002-02-24', '$2y$12$4./Krxiq1qeB2qjFRfRdueGogFaiLIV1MQoAEPaUF/Px1g6T85d8m', '2026-05-06 07:39:34', NULL, 4, '2026-05-06 07:39:34', '2026-05-06 07:39:34', NULL),
(45, 'usuario16', 'usuario16@gmail.com', '2002-06-24', '$2y$12$M4lscxzK07vItdmf973bzuH1dhgTmIv8.P1OuWaCv50ig04RgpoLe', '2026-05-06 07:45:09', NULL, 4, '2026-05-06 07:45:10', '2026-05-06 07:45:10', NULL),
(46, 'usuario17', 'usuario17@gmail.com', '2002-06-21', '$2y$12$a27wYelcZJ9WkAPMUjbNLO9AfvqV5PkiWtD1tApGiZIp2EBnrRPBu', '2026-05-06 07:53:27', NULL, 4, '2026-05-06 07:53:27', '2026-05-06 07:53:27', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alimentos`
--
ALTER TABLE `alimentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `asignacion_menus`
--
ALTER TABLE `asignacion_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asignacion_menus_id_usuario_foreign` (`id_usuario`);

--
-- Indices de la tabla `asignacion_objetivo`
--
ALTER TABLE `asignacion_objetivo`
  ADD PRIMARY KEY (`id_asignacion`),
  ADD KEY `asignacion_objetivo_id_usuario_foreign` (`id_usuario`),
  ADD KEY `asignacion_objetivo_id_objetivo_foreign` (`id_objetivo`);

--
-- Indices de la tabla `asignacion_preferencia`
--
ALTER TABLE `asignacion_preferencia`
  ADD PRIMARY KEY (`id_asignacion`),
  ADD KEY `asignacion_preferencia_id_usuario_foreign` (`id_usuario`),
  ADD KEY `asignacion_preferencia_id_preferencia_foreign` (`id_preferencia`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `medidas`
--
ALTER TABLE `medidas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medidas_id_usuario_foreign` (`id_usuario`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menu_alimentos`
--
ALTER TABLE `menu_alimentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_alimentos_asignacion_menu_id_foreign` (`asignacion_menu_id`),
  ADD KEY `menu_alimentos_id_alimento_foreign` (`id_alimento`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `objetivos`
--
ALTER TABLE `objetivos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `preferencias`
--
ALTER TABLE `preferencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `progreso`
--
ALTER TABLE `progreso`
  ADD PRIMARY KEY (`id_progreso`),
  ADD KEY `progreso_id_medida_foreign` (`id_medida`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuarios_email_unique` (`email`),
  ADD KEY `usuarios_id_rol_foreign` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alimentos`
--
ALTER TABLE `alimentos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `asignacion_menus`
--
ALTER TABLE `asignacion_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `asignacion_objetivo`
--
ALTER TABLE `asignacion_objetivo`
  MODIFY `id_asignacion` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `asignacion_preferencia`
--
ALTER TABLE `asignacion_preferencia`
  MODIFY `id_asignacion` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medidas`
--
ALTER TABLE `medidas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menu_alimentos`
--
ALTER TABLE `menu_alimentos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `objetivos`
--
ALTER TABLE `objetivos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `preferencias`
--
ALTER TABLE `preferencias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `progreso`
--
ALTER TABLE `progreso`
  MODIFY `id_progreso` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignacion_menus`
--
ALTER TABLE `asignacion_menus`
  ADD CONSTRAINT `asignacion_menus_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `asignacion_objetivo`
--
ALTER TABLE `asignacion_objetivo`
  ADD CONSTRAINT `asignacion_objetivo_id_objetivo_foreign` FOREIGN KEY (`id_objetivo`) REFERENCES `objetivos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asignacion_objetivo_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `asignacion_preferencia`
--
ALTER TABLE `asignacion_preferencia`
  ADD CONSTRAINT `asignacion_preferencia_id_preferencia_foreign` FOREIGN KEY (`id_preferencia`) REFERENCES `preferencias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asignacion_preferencia_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `medidas`
--
ALTER TABLE `medidas`
  ADD CONSTRAINT `medidas_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `menu_alimentos`
--
ALTER TABLE `menu_alimentos`
  ADD CONSTRAINT `menu_alimentos_asignacion_menu_id_foreign` FOREIGN KEY (`asignacion_menu_id`) REFERENCES `asignacion_menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menu_alimentos_id_alimento_foreign` FOREIGN KEY (`id_alimento`) REFERENCES `alimentos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `progreso`
--
ALTER TABLE `progreso`
  ADD CONSTRAINT `progreso_id_medida_foreign` FOREIGN KEY (`id_medida`) REFERENCES `medidas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_id_rol_foreign` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
