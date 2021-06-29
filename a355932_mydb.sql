-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 29 2021 г., 13:29
-- Версия сервера: 5.7.22-22-log
-- Версия PHP: 5.6.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `a355932_mydb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `address`
--

CREATE TABLE `address` (
  `info_orders_id` int(11) NOT NULL,
  `city` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `street` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `building` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `flat` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `address`
--

INSERT INTO `address` (`info_orders_id`, `city`, `street`, `building`, `flat`) VALUES
(2, 'Москва', 'Победы', '10', '12'),
(3, 'Киров', 'Мира', '1', '12'),
(5, 'cdd', 'df', 'fd', '5'),
(23, 'sdv', 'vd', '544', '4'),
(25, 'fvdf', 'sdvs', 'd', '21'),
(43, '', '', '', ''),
(44, '', '', '', ''),
(45, '', '', '', ''),
(46, '', '', '', ''),
(47, '', '', '', ''),
(48, '', '', '', ''),
(49, '', '', '', ''),
(50, '', '', '', ''),
(51, '', '', '', ''),
(52, '', '', '', ''),
(53, '', '', '', ''),
(54, '', '', '', ''),
(55, '', '', '', ''),
(56, '', '', '', ''),
(57, '', '', '', ''),
(58, '', '', '', ''),
(59, '', '', '', ''),
(60, '', '', '', ''),
(61, 'sdv', 'vd', '55', '5'),
(62, 'sdv', 'vd', '55', '5'),
(75, 'glazov', 'sss', '44', '8'),
(76, 'glazov', 'sss', '44', '8'),
(77, '', '', '', ''),
(78, '', '', '', ''),
(79, '', '', '', ''),
(80, '', '', '', ''),
(85, 'mlnl', 'mlm;km', '1', '22'),
(89, 'sdv', 'vd', '1', '2'),
(90, 'm,,\'', ',,\',\'l,', '12', '123'),
(91, 'mlnl', 'mlm;km', '1', '2'),
(93, 'glazov', 'sss', '55', '4'),
(95, 'glazov', 'sss', '5464', '5'),
(96, 'lkkllk', 'mlmkm', '55', '46'),
(99, 'Светлый', 'Заводская', '14', '1'),
(100, 'Ggh', 'Vgg', 'Ff', 'Vv');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ru_name` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `ru_name`) VALUES
(1, 'women', 'Женщины'),
(2, 'men', 'Мужчины'),
(3, 'children', 'Дети'),
(4, 'accessories', 'Аксессуары');

-- --------------------------------------------------------

--
-- Структура таблицы `category_good`
--

CREATE TABLE `category_good` (
  `goods_id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `category_good`
--

INSERT INTO `category_good` (`goods_id`, `categories_id`) VALUES
(5, 4),
(6, 1),
(7, 1),
(8, 1),
(10, 1),
(11, 1),
(12, 4),
(13, 4),
(14, 2),
(15, 3),
(16, 2),
(17, 2),
(18, 3),
(19, 3),
(20, 1),
(21, 2),
(22, 2),
(22, 4),
(23, 2),
(4, 2),
(4, 3),
(4, 4),
(3, 2),
(9, 1),
(1, 1),
(2, 1),
(123, 2),
(124, 4),
(125, 4),
(129, 2),
(176, 2),
(176, 4),
(177, 4),
(177, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

CREATE TABLE `goods` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `price` int(11) NOT NULL,
  `new` tinyint(4) NOT NULL DEFAULT '0',
  `sale` tinyint(4) NOT NULL DEFAULT '0',
  `img` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`id`, `name`, `price`, `new`, `sale`, `img`) VALUES
(1, 'Платье белое со складками', 3000, 1, 0, '/img/products/product-1.jpg'),
(2, 'Рубашка в клетку', 1780, 1, 0, '/img/products/1624960158-4398018419.jpg'),
(3, 'Часы мужские классические', 100000, 1, 0, '/img/products/product-3.jpg'),
(4, 'Брюки в полоску', 1992, 0, 0, '/img/products/product-4.jpg'),
(5, 'Сумка', 8999, 1, 0, '/img/products/product-5.jpg'),
(6, 'Платье красное', 7199, 0, 1, '/img/products/product-6.jpg'),
(7, 'Тренч', 3999, 0, 1, '/img/products/product-7.jpg'),
(8, 'Джинсы', 2599, 1, 1, '/img/products/product-8.jpg'),
(9, 'Ботинки', 6199, 1, 0, '/img/products/product-9.jpg'),
(10, 'Шорты женские', 1699, 1, 1, '/img/products/product-2.jpg'),
(11, 'Кардиган', 2999, 1, 0, '/img/products/product-5.jpg'),
(12, 'Очки', 799, 1, 1, '/img/products/product-6.jpg'),
(13, 'Сумка с брелком', 5999, 1, 1, '/img/products/product-7.jpg'),
(14, 'Джинсы мужские', 3999, 1, 0, '/img/products/product-10.jpg'),
(15, 'Платье детское серое', 799, 0, 1, '/img/products/product-11.jpg'),
(16, 'Футболка мужская', 1599, 1, 1, '/img/products/product-12.jpg'),
(17, 'Пижама мужская', 2999, 1, 0, '/img/products/product-13.jpg'),
(18, 'Платье детское розовое', 999, 1, 0, '/img/products/product-11.jpg'),
(19, 'Пижама детская', 999, 1, 1, '/img/products/product-13.jpg'),
(20, 'Пижама женская', 1800, 0, 1, '/img/products/product-13.jpg'),
(21, 'Брюки мужские черные', 2999, 1, 0, '/img/products/product-12.jpg'),
(22, 'Шляпа мужская', 2199, 1, 0, '/img/products/product-14.jpg'),
(23, 'Пальто мужское', 5999, 0, 1, '/img/products/product-14.jpg'),
(123, 'Рубашка белая', 2299, 1, 0, '/img/products/1624960257-8591456901.jpeg'),
(124, 'Ручка', 122, 1, 0, '/img/products/1624960294-4816266858.jpg'),
(125, 'Блокнот', 199, 1, 0, '/img/products/1624960311-4686975097.jpg'),
(129, 'Блузка', 122, 0, 1, '/img/products/1624960334-8019451890.jpg'),
(176, 'Часы', 2000, 1, 0, '/img/products/1624960381-6901514770.jpg'),
(177, 'рюкзак', 1599, 1, 0, '/img/products/1624960399-2103552891.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `good_order`
--

CREATE TABLE `good_order` (
  `orders_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `good_order`
--

INSERT INTO `good_order` (`orders_id`, `goods_id`) VALUES
(17, 1),
(18, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(93, 1),
(2, 2),
(19, 2),
(20, 2),
(25, 2),
(87, 2),
(89, 2),
(90, 2),
(94, 2),
(96, 2),
(97, 2),
(99, 2),
(1, 3),
(91, 3),
(92, 3),
(46, 4),
(47, 4),
(48, 4),
(49, 4),
(50, 4),
(51, 4),
(52, 4),
(53, 4),
(54, 4),
(55, 4),
(56, 4),
(57, 4),
(26, 6),
(58, 6),
(88, 9),
(95, 9),
(98, 9),
(43, 11),
(44, 11),
(45, 11),
(15, 13),
(16, 17),
(5, 20),
(3, 22),
(100, 177);

-- --------------------------------------------------------

--
-- Структура таблицы `info`
--

CREATE TABLE `info` (
  `orders_id` int(11) NOT NULL,
  `delivery` tinyint(4) NOT NULL DEFAULT '0',
  `payment` tinyint(4) NOT NULL DEFAULT '0',
  `comment` text CHARACTER SET utf8
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `info`
--

INSERT INTO `info` (`orders_id`, `delivery`, `payment`, `comment`) VALUES
(1, 0, 0, '000'),
(2, 1, 0, '65165'),
(3, 1, 1, NULL),
(5, 1, 0, NULL),
(15, 0, 1, NULL),
(16, 1, 0, ''),
(17, 0, 1, 'nlknlkn'),
(18, 1, 1, 'v'),
(19, 1, 1, ''),
(20, 1, 1, ''),
(21, 1, 1, ''),
(22, 1, 1, ''),
(23, 1, 1, ''),
(24, 0, 1, ''),
(25, 1, 0, 'sdv'),
(26, 0, 1, ''),
(43, 1, 1, 'nlnlkn m;lm'),
(44, 1, 1, ''),
(45, 1, 1, ''),
(46, 1, 1, ''),
(47, 1, 1, ''),
(48, 1, 1, ''),
(49, 1, 1, ''),
(50, 1, 1, ''),
(51, 1, 1, ''),
(52, 1, 0, ''),
(53, 1, 1, ''),
(54, 1, 0, ''),
(55, 1, 1, ''),
(56, 1, 1, ''),
(57, 1, 1, ''),
(58, 1, 1, ''),
(59, 1, 1, ''),
(60, 1, 1, ''),
(61, 1, 1, ''),
(62, 1, 1, ''),
(63, 0, 1, ''),
(64, 0, 1, ''),
(65, 0, 1, ''),
(66, 0, 1, ''),
(67, 0, 1, ''),
(68, 0, 1, ''),
(69, 0, 1, ''),
(70, 0, 1, ''),
(71, 0, 1, ''),
(72, 0, 1, ''),
(73, 0, 1, ''),
(74, 0, 1, ''),
(75, 1, 1, ''),
(76, 1, 1, ''),
(77, 1, 1, ''),
(78, 1, 1, ''),
(79, 1, 1, ''),
(80, 1, 1, ''),
(81, 0, 1, ''),
(82, 0, 1, ''),
(83, 0, 1, ''),
(84, 0, 1, ''),
(85, 1, 1, ''),
(86, 0, 1, ''),
(87, 0, 1, ''),
(88, 0, 1, ''),
(89, 1, 0, 'no com'),
(90, 1, 0, 'j'),
(91, 1, 0, ''),
(92, 0, 1, ''),
(93, 1, 0, 'mklml'),
(94, 0, 1, ''),
(95, 1, 0, 'hoih'),
(96, 1, 1, ''),
(97, 0, 1, ''),
(98, 0, 0, 'нет комментария'),
(99, 1, 1, ''),
(100, 1, 1, '');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `total_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `users_id`, `status`, `total_price`) VALUES
(43, 4, 0, 2999),
(44, 4, 0, 2999),
(45, 4, 0, 2999),
(46, 4, 0, 2272),
(47, 4, 0, 2272),
(48, 4, 0, 2272),
(49, 4, 0, 2272),
(50, 4, 0, 2272),
(51, 4, 0, 2272),
(52, 4, 0, 2272),
(53, 4, 0, 2272),
(54, 4, 0, 2272),
(55, 4, 0, 2272),
(56, 4, 1, 2272),
(57, 4, 0, 2272),
(58, 1, 0, 7199),
(59, 1, 0, 2999),
(60, 1, 0, 2999),
(61, 1, 0, 2999),
(62, 1, 0, 2999),
(63, 1, 0, 2999),
(64, 1, 0, 2999),
(65, 1, 0, 2999),
(66, 1, 0, 2999),
(67, 1, 0, 2999),
(68, 1, 0, 2999),
(69, 1, 0, 2999),
(70, 1, 0, 2999),
(71, 1, 0, 2999),
(72, 1, 0, 2999),
(73, 1, 0, 2999),
(74, 1, 0, 2999),
(75, 1, 0, 2999),
(76, 1, 0, 2999),
(77, 1, 0, 2999),
(78, 1, 0, 2999),
(79, 1, 0, 2999),
(80, 1, 0, 2999),
(81, 1, 0, 2999),
(82, 1, 0, 2999),
(83, 1, 0, 2999),
(84, 1, 0, 2999),
(85, 4, 0, 2999),
(86, 4, 0, 2999),
(87, 4, 0, 178),
(88, 4, 0, 6199),
(89, 6, 1, 458),
(90, 7, 1, 458),
(91, 4, 0, 100000),
(92, 4, 1, 100000),
(93, 20, 1, 3000),
(94, 4, 1, 178),
(95, 4, 1, 6199),
(96, 4, 1, 458),
(97, 1, 1, 178),
(98, 10, 1, 6199),
(99, 10, 1, 458),
(100, 10, 0, 1879);

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `order_list_allowed` tinyint(4) NOT NULL DEFAULT '0',
  `manage_goods` varchar(45) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `admin_interface` varchar(45) CHARACTER SET utf8 NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `order_list_allowed`, `manage_goods`, `admin_interface`) VALUES
(1, 'Admin', 'Admin description', 1, '1', '1'),
(2, 'Operator', 'Operator desc', 1, '0', '1'),
(3, 'Buyer', 'Buyer', 0, '0', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `role_user`
--

CREATE TABLE `role_user` (
  `users_id` int(11) NOT NULL,
  `roles_id` int(11) NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `role_user`
--

INSERT INTO `role_user` (`users_id`, `roles_id`) VALUES
(1, 1),
(5, 2),
(2, 3),
(3, 3),
(4, 3),
(6, 3),
(7, 3),
(8, 3),
(10, 3),
(11, 3),
(12, 3),
(13, 3),
(14, 3),
(15, 3),
(16, 3),
(17, 3),
(18, 3),
(19, 3),
(20, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `surname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `phone` int(11) NOT NULL,
  `patronymic` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `name`, `surname`, `phone`, `patronymic`, `password`) VALUES
(1, 'admin@admin.ru', 'admin', 'admin', 123456, 'adminfather', '$2y$10$GZcQPVOtFsZKMatoYI.ZduV.rI3jhksk7TlGqg5miMAeuP1qiU8SO'),
(2, 'test2@fff.ff', 'test2', 'test2S', 123456, 'test2P', '$2y$10$GZcQPVOtFsZKMatoYI.ZduV.rI3jhksk7TlGqg5miMAeuP1qiU8SO'),
(3, 'test3@fff.ff', 'test3', 'test3S', 123456, 'test3P', '$2y$10$GZcQPVOtFsZKMatoYI.ZduV.rI3jhksk7TlGqg5miMAeuP1qiU8SO'),
(4, 'test1@fff.ff', 'test1', 'test1S', 123456, 'test1P', '$2y$10$GZcQPVOtFsZKMatoYI.ZduV.rI3jhksk7TlGqg5miMAeuP1qiU8SO'),
(5, 'operator@opr.opr', 'operator', 'operator', 321456, 'operatorovich', '$2y$10$GZcQPVOtFsZKMatoYI.ZduV.rI3jhksk7TlGqg5miMAeuP1qiU8SO'),
(6, 'new@kkk.aa', 'new', 'kkkk', 123456, 'nnnnnnnnnn', '$2y$10$GZcQPVOtFsZKMatoYI.ZduV.rI3jhksk7TlGqg5miMAeuP1qiU8SO'),
(7, 'dvsd', 'sdvsd', 'fvdfv', 80000000, '546', '$2y$10$GZcQPVOtFsZKMatoYI.ZduV.rI3jhksk7TlGqg5miMAeuP1qiU8SO'),
(8, 'dvs', 'sdvs', 'svsv', 0, '546', '$2y$10$GZcQPVOtFsZKMatoYI.ZduV.rI3jhksk7TlGqg5miMAeuP1qiU8SO'),
(10, 'bma1989@yandex.ru', 'm;m;', 'ef', 0, 'l,;,;,', '$2y$10$GZcQPVOtFsZKMatoYI.ZduV.rI3jhksk7TlGqg5miMAeuP1qiU8SO'),
(11, 'bma1989@yandex.sy', 'm;m;', 'ef', 0, 'l,;,;,', '$2y$10$GZcQPVOtFsZKMatoYI.ZduV.rI3jhksk7TlGqg5miMAeuP1qiU8SO'),
(12, 'ivanov@hhh.ff', 'Иван', 'Иванов', 23456, '', '$2y$10$GZcQPVOtFsZKMatoYI.ZduV.rI3jhksk7TlGqg5miMAeuP1qiU8SO'),
(13, 'ivan@gmail.com', 'Иван', 'Иванов', 23456, 'Иванович', '$2y$10$GZcQPVOtFsZKMatoYI.ZduV.rI3jhksk7TlGqg5miMAeuP1qiU8SO');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`info_orders_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `category_good`
--
ALTER TABLE `category_good`
  ADD KEY `fk_goods_has_categories_categories1_idx` (`categories_id`),
  ADD KEY `fk_goods_has_categories_goods1_idx` (`goods_id`);

--
-- Индексы таблицы `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `good_order`
--
ALTER TABLE `good_order`
  ADD PRIMARY KEY (`orders_id`,`goods_id`),
  ADD KEY `fk_orders_has_goods_goods1_idx` (`goods_id`),
  ADD KEY `fk_orders_has_goods_orders1_idx` (`orders_id`);

--
-- Индексы таблицы `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`orders_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`,`users_id`),
  ADD KEY `fk_orders_users_idx` (`users_id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`users_id`,`roles_id`),
  ADD KEY `fk_users_has_roles_roles1_idx` (`roles_id`),
  ADD KEY `fk_users_has_roles_users1_idx` (`users_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `fk_address_info2` FOREIGN KEY (`info_orders_id`) REFERENCES `info` (`orders_id`);

--
-- Ограничения внешнего ключа таблицы `category_good`
--
ALTER TABLE `category_good`
  ADD CONSTRAINT `fk_goods_has_categories_categories1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `fk_goods_has_categories_goods1` FOREIGN KEY (`goods_id`) REFERENCES `goods` (`id`);

--
-- Ограничения внешнего ключа таблицы `good_order`
--
ALTER TABLE `good_order`
  ADD CONSTRAINT `fk_orders_has_goods_goods1` FOREIGN KEY (`goods_id`) REFERENCES `goods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orders_has_goods_orders1` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `info`
--
ALTER TABLE `info`
  ADD CONSTRAINT `fk_info_orders1` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `fk_users_has_roles_roles1` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `fk_users_has_roles_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
