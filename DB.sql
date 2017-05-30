ALTER TABLE product ADD link_name varchar(255) NOT NULL;

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) unsigned NOT NULL,
  `created_at` int(11) NOT NULL,
  `status` int(2) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `total` float NOT NULL DEFAULT '0',
  `payment_method` varchar(50) NOT NULL,
  `payment_status` int(2) unsigned NOT NULL,
  `transaction_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`)
);

CREATE TABLE IF NOT EXISTS `order_to_product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`,`product_id`),
);


CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,  
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `subscribe` int(1) unsigned NOT NULL DEFAULT '0',
  `active` int(1) unsigned NOT NULL DEFAULT '0',
  `password` varchar(50) NOT NULL DEFAULT '',
  `registration_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `name` (`name`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
);


-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1493834717),
('m130524_201442_init', 1493834724),
('m170505_133220_order', 1493992310);

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

ALTER TABLE product ADD short_title varchar(255) NOT NULL;
ALTER TABLE product ADD full_title varchar(1000) NOT NULL;

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` float unsigned NOT NULL,
  `status` int(2) unsigned NOT NULL DEFAULT '0',
  `order` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `title`, `price`, `status`, `order`) VALUES
(8, 'Guest Posting Marketing', 2000, 1, 1),
(9, 'Q&A Link Building Techniques', 1000, 1, 5),
(11, 'Forum Link Building Techniques', 655.99, 1, 0),
(14, 'Forum Link Building Techniques', 2300, 1, 2),
(15, 'Guest Posting Marketing 2', 2345, 1, 4),
(16, 'Forum Link Building Techniques 2', 1750, 1, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `product_guide`
--

CREATE TABLE IF NOT EXISTS `product_guide` (
  `id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` int(2) unsigned NOT NULL DEFAULT '0',
  `about` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `product_href`
--

CREATE TABLE IF NOT EXISTS `product_href` (
  `id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `url` varchar(255) NOT NULL,
  `status` int(2) unsigned NOT NULL DEFAULT '0',
  `alexa_rank` int(11) unsigned NOT NULL DEFAULT '0',
  `da_rank` float NOT NULL DEFAULT '0',
  `about` text,
  `example_url` varchar(255) NOT NULL,
  `type_links` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product_href`
--

INSERT INTO `product_href` (`id`, `product_id`, `url`, `status`, `alexa_rank`, `da_rank`, `about`, `example_url`, `type_links`) VALUES
(1, 15, 'http://korrespondent.net/', 1, 2933, 67.31, '', 'http://www.yiiframework.com/do', 'nolinks'),
(2, 15, 'http://auto.ria.com/', 1, 0, 60.62, 'Details', 'http://www.yiiframework.com/do', 'redirect'),
(3, 11, 'http://auto.ria.com/', 1, 0, 60.62, 'sasdfasdf', 'http://www.yiiframework.com/do', 'redirect'),
(4, 11, 'http://korrespondent.net/', 1, 2942, 67.31, 'dsfgsdfgsdfg', 'http://www.yiiframework.com/do', 'nolinks');

-- --------------------------------------------------------

--
-- Структура таблицы `product_href_category`
--

CREATE TABLE IF NOT EXISTS `product_href_category` (
  `id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product_href_category`
--

INSERT INTO `product_href_category` (`id`, `title`) VALUES
(1, 'SEO'),
(2, 'Marketing'),
(3, 'Website Development'),
(4, 'Category');

-- --------------------------------------------------------

--
-- Структура таблицы `product_href_to_category`
--

CREATE TABLE IF NOT EXISTS `product_href_to_category` (
  `product_id` int(11) unsigned NOT NULL,
  `category_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product_href_to_category`
--

INSERT INTO `product_href_to_category` (`product_id`, `category_id`) VALUES
(1, 2),
(2, 3),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(4, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `user_backend`
--

CREATE TABLE IF NOT EXISTS `user_backend` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user_backend`
--

INSERT INTO `user_backend` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', '', '$2y$13$C0fkgk3txcpzrEcgo.sUzuMnRW8lXJ6RDrYL1.o/Tem7iO5Wm4VJS', NULL, '', 10, 1493838079, 1493838079);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `price` (`price`);

--
-- Индексы таблицы `product_guide`
--
ALTER TABLE `product_guide`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `product_guide`  ADD `order`  smallint(6) NOT NULL;

--
-- Индексы таблицы `product_href`
--
ALTER TABLE `product_href`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`product_id`);

--
-- Индексы таблицы `product_href_category`
--
ALTER TABLE `product_href_category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `product_href_to_category`
--
ALTER TABLE `product_href_to_category`
  ADD KEY `product_id` (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `user_backend`
--
ALTER TABLE `user_backend`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT для таблицы `product_href`
--
ALTER TABLE `product_href`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `product_href_category`
--
ALTER TABLE `product_href_category`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `user_backend`
--
ALTER TABLE `user_backend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
