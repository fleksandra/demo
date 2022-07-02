-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 02 2022 г., 10:19
-- Версия сервера: 8.0.24
-- Версия PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `title`) VALUES
(8, 'лазерные принтеры'),
(11, 'струйные принтеры');

-- --------------------------------------------------------

--
-- Структура таблицы `composition_order`
--

CREATE TABLE `composition_order` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `count` int NOT NULL,
  `order_id` int NOT NULL,
  `price` float NOT NULL,
  `title_product` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `composition_order`
--

INSERT INTO `composition_order` (`id`, `product_id`, `count`, `order_id`, `price`, `title_product`) VALUES
(8, 4, 2, 10, 8000, 'Товар 4'),
(9, 12, 1, 10, 15000, 'Товар 7'),
(10, 4, 1, 11, 8000, 'Товар 4'),
(11, 3, 1, 11, 10000, 'Товар 3'),
(12, 12, 1, 11, 15000, 'Товар 7'),
(13, 1, 1, 11, 250.9, 'Товар 1'),
(16, 3, 2, 13, 10000, 'Товар 3'),
(17, 4, 1, 13, 8000, 'Товар 4'),
(18, 12, 1, 13, 15000, 'Товар 7'),
(22, 1, 1, 16, 250.9, 'Товар 1'),
(23, 12, 1, 17, 15000, 'Товар 7'),
(68, 3, 1, 48, 10000, 'Товар 3'),
(69, 4, 1, 48, 8000, 'Товар 4'),
(70, 12, 1, 49, 15000, 'Товар 7'),
(71, 3, 1, 49, 10000, 'Товар 3'),
(72, 2, 1, 49, 5000, 'Товар 2'),
(73, 12, 2, 50, 15000, 'Товар 7'),
(74, 1, 1, 50, 250.9, 'Товар 1');

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE `order` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_id` int NOT NULL,
  `sum_price` float NOT NULL,
  `count` int NOT NULL,
  `refusal` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`id`, `user_id`, `timestamp`, `status_id`, `sum_price`, `count`, `refusal`) VALUES
(10, 2, '2022-03-17 09:06:09', 2, 31000, 3, NULL),
(11, 2, '2022-03-17 11:16:59', 3, 33250.9, 4, 'ngn'),
(13, 6, '2022-03-17 12:20:51', 3, 43000, 4, 'fgfg'),
(16, 2, '2022-03-18 15:32:44', 2, 250.9, 1, NULL),
(17, 2, '2022-03-19 08:23:37', 2, 15000, 1, NULL),
(48, 6, '2022-03-21 14:48:45', 3, 18000, 2, 'dddd'),
(49, 6, '2022-03-21 15:46:44', 3, 30000, 3, 'ggg'),
(50, 8, '2022-03-24 17:25:01', 2, 30250.9, 3, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `photo` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `country` varchar(255) NOT NULL,
  `year` year NOT NULL,
  `model` varchar(255) NOT NULL,
  `category_id` int NOT NULL,
  `count` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `title`, `photo`, `price`, `country`, `year`, `model`, `category_id`, `count`) VALUES
(1, 'Товар 1', 'admin1646823282.png', 250.9, 'Россия', 2021, 'А5', 8, 10),
(2, 'Товар 2', 'admin1646823430.jpg', 5000, 'Франция', 2020, 'DHT-8', 8, 5),
(3, 'Товар 3', 'admin1646422204.jpg', 10000, 'Италия', 2019, 'Р-45', 8, 5),
(4, 'Товар 4', 'admin1646422250.jpg', 8000, 'Франция', 2021, 'R-09', 8, 0),
(12, 'Товар 7', 'admin1646825708.jpg', 15000, 'Франция', 2022, 'RYY-56', 11, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`id`, `title`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE `status` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id`, `title`) VALUES
(1, 'Новый'),
(2, 'Подтвержденный'),
(3, 'Отмененный');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `patronymic` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `login` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int NOT NULL,
  `auth_key` varchar(255) NOT NULL,
  `access_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `surname`, `patronymic`, `login`, `email`, `password`, `role_id`, `auth_key`, `access_token`) VALUES
(1, 'Админ', 'Админ', '', 'admin', 'admin@r.ru', '$2y$13$cWyLc8k1fJTGZ.ZYHSxXpuYnOOI4nESuWQxlnqw9NpA4yP5k92FDq', 1, 'AkMEmiV4sM_QGsJusvBI0syet6bqhKQb', NULL),
(2, 'А', 'А', 'А', 'q', 'fff@hh.ru', '$2y$13$7i/7HM8WDXBamMCBBWLRmeGa0cxEZAUdbwZQZUF3XC5vzAhHsn.0u', 2, 'DX6y58y5bnLywRExh5zOsXPl48n02HPC', NULL),
(6, 'Ф', 'Ф', 'Ф', 'w', 'aaf@hh.ru', '$2y$13$KR0PES2T45/..IzqjIaIkOSlMcx6BlncDbF0c7LN8ItjVO4XV3r0G', 2, 'dgQV_IKaj6UiSklMmSm_dGhe06gl1Nv7', NULL),
(7, 'А', 'А', 'А', 'e', 'dds@bk.ru', '$2y$13$NqPZ4M6vdLSKF9Kt86SfU.Kb8uAuQUHmLG4FTL5A8G6euGtjFzTeO', 2, 'c5Wcqz8phn2U8Rm7m1PdRD32oeljdwIz', NULL),
(8, 'Лиза', 'Боброва', '', 'liza', 'liza@hh.ru', '$2y$13$WNg5LwVY5igrl/PkruJ6dOS0K3Q3sOv3DhFWU4xTMBeKtn2eJE.Ba', 2, 'p5KBOiLEz7vc3Olhdb_X32581TJmkd1d', NULL),
(15, 'А', 'А', 'А', 'admin11', 'admin11@r.ru', '$2y$13$20/.MuUJNgo.OKEz9aD0LOKllQBeCOdliWCiGIm/09emchZhKK84O', 1, 'vWS1rYwbzsdaYYyqUCRms1dRbt9FSyqn', NULL),
(16, 'авп', 'впвпап', 'вапва', 'r', 'q@qo.fhhh', '$2y$13$jxdm9JOZmBFg7zBqehryNeVcextrGyFdPPPssLA.sZ2.LesMm9LyC', 2, 'iO4rL8-TiZQMT3kSN7nYmdWvddzUb_Zt', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `composition_order`
--
ALTER TABLE `composition_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Индексы таблицы `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `composition_order`
--
ALTER TABLE `composition_order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT для таблицы `order`
--
ALTER TABLE `order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `status`
--
ALTER TABLE `status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `composition_order`
--
ALTER TABLE `composition_order`
  ADD CONSTRAINT `composition_order_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
