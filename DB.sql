ALTER TABLE `order` ADD INDEX (`transaction_id`);

CREATE TABLE IF NOT EXISTS `transaction_fasts*pring` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,    
  `order_id` varchar(50) NOT NULL,
  `subscription_id` varchar(50) NOT NULL DEFAULT '',
  `transaction_id` int(11) unsigned NOT NULL,
  `price` float unsigned NOT NULL DEFAULT '0',
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  key(`order_id`),
  key(`subscription_id`),
  key(`transaction_id`)
);

ALTER TABLE `product` ADD `links_available` int(2) unsigned NOT NULL DEFAULT '1';

ALTER TABLE `product` ADD `questions` TEXT;

ALTER TABLE `product_page` CHANGE `content` `content` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

CREATE TABLE IF NOT EXISTS `user_access_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `time` datetime NOT NULL,
  `hash` varchar(200),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),  
  KEY `timestamp` (`timestamp`)
);

CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `payment` varchar(40) DEFAULT '',
  `price` float unsigned NOT NULL DEFAULT '0',
  `success` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `response_details` text,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `user_billing` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `full_name` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL  DEFAULT '',  
  `phone_number` varchar(255) NOT NULL  DEFAULT '',  
  `company_name` varchar(255) NOT NULL DEFAULT '',
  `country` int(11) unsigned NOT NULL DEFAULT '0',
  `address` varchar(255) NOT NULL DEFAULT '',
  `zip` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  `payment` varchar(50) NOT NULL DEFAULT '',
  `agreed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `subscribe_offers` int(1) unsigned NOT NULL DEFAULT '0',
  `subscribe_blog` int(1) unsigned NOT NULL DEFAULT '0',  
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
)

--
-- Структура таблицы `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_name` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=243 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `countries`
--

INSERT INTO `countries` (`id`, `country_code`, `country_name`) VALUES
(1, 'US', 'United States'),
(2, 'CA', 'Canada'),
(3, 'AF', 'Afghanistan'),
(4, 'AL', 'Albania'),
(5, 'DZ', 'Algeria'),
(6, 'DS', 'American Samoa'),
(7, 'AD', 'Andorra'),
(8, 'AO', 'Angola'),
(9, 'AI', 'Anguilla'),
(10, 'AQ', 'Antarctica'),
(11, 'AG', 'Antigua and/or Barbuda'),
(12, 'AR', 'Argentina'),
(13, 'AM', 'Armenia'),
(14, 'AW', 'Aruba'),
(15, 'AU', 'Australia'),
(16, 'AT', 'Austria'),
(17, 'AZ', 'Azerbaijan'),
(18, 'BS', 'Bahamas'),
(19, 'BH', 'Bahrain'),
(20, 'BD', 'Bangladesh'),
(21, 'BB', 'Barbados'),
(22, 'BY', 'Belarus'),
(23, 'BE', 'Belgium'),
(24, 'BZ', 'Belize'),
(25, 'BJ', 'Benin'),
(26, 'BM', 'Bermuda'),
(27, 'BT', 'Bhutan'),
(28, 'BO', 'Bolivia'),
(29, 'BA', 'Bosnia and Herzegovina'),
(30, 'BW', 'Botswana'),
(31, 'BV', 'Bouvet Island'),
(32, 'BR', 'Brazil'),
(33, 'IO', 'British lndian Ocean Territory'),
(34, 'BN', 'Brunei Darussalam'),
(35, 'BG', 'Bulgaria'),
(36, 'BF', 'Burkina Faso'),
(37, 'BI', 'Burundi'),
(38, 'KH', 'Cambodia'),
(39, 'CM', 'Cameroon'),
(40, 'CV', 'Cape Verde'),
(41, 'KY', 'Cayman Islands'),
(42, 'CF', 'Central African Republic'),
(43, 'TD', 'Chad'),
(44, 'CL', 'Chile'),
(45, 'CN', 'China'),
(46, 'CX', 'Christmas Island'),
(47, 'CC', 'Cocos (Keeling) Islands'),
(48, 'CO', 'Colombia'),
(49, 'KM', 'Comoros'),
(50, 'CG', 'Congo'),
(51, 'CK', 'Cook Islands'),
(52, 'CR', 'Costa Rica'),
(53, 'HR', 'Croatia (Hrvatska)'),
(54, 'CU', 'Cuba'),
(55, 'CY', 'Cyprus'),
(56, 'CZ', 'Czech Republic'),
(57, 'DK', 'Denmark'),
(58, 'DJ', 'Djibouti'),
(59, 'DM', 'Dominica'),
(60, 'DO', 'Dominican Republic'),
(61, 'TP', 'East Timor'),
(62, 'EC', 'Ecuador'),
(63, 'EG', 'Egypt'),
(64, 'SV', 'El Salvador'),
(65, 'GQ', 'Equatorial Guinea'),
(66, 'ER', 'Eritrea'),
(67, 'EE', 'Estonia'),
(68, 'ET', 'Ethiopia'),
(69, 'FK', 'Falkland Islands (Malvinas)'),
(70, 'FO', 'Faroe Islands'),
(71, 'FJ', 'Fiji'),
(72, 'FI', 'Finland'),
(73, 'FR', 'France'),
(74, 'FX', 'France, Metropolitan'),
(75, 'GF', 'French Guiana'),
(76, 'PF', 'French Polynesia'),
(77, 'TF', 'French Southern Territories'),
(78, 'GA', 'Gabon'),
(79, 'GM', 'Gambia'),
(80, 'GE', 'Georgia'),
(81, 'DE', 'Germany'),
(82, 'GH', 'Ghana'),
(83, 'GI', 'Gibraltar'),
(84, 'GR', 'Greece'),
(85, 'GL', 'Greenland'),
(86, 'GD', 'Grenada'),
(87, 'GP', 'Guadeloupe'),
(88, 'GU', 'Guam'),
(89, 'GT', 'Guatemala'),
(90, 'GN', 'Guinea'),
(91, 'GW', 'Guinea-Bissau'),
(92, 'GY', 'Guyana'),
(93, 'HT', 'Haiti'),
(94, 'HM', 'Heard and Mc Donald Islands'),
(95, 'HN', 'Honduras'),
(96, 'HK', 'Hong Kong'),
(97, 'HU', 'Hungary'),
(98, 'IS', 'Iceland'),
(99, 'IN', 'India'),
(100, 'ID', 'Indonesia'),
(101, 'IR', 'Iran (Islamic Republic of)'),
(102, 'IQ', 'Iraq'),
(103, 'IE', 'Ireland'),
(104, 'IL', 'Israel'),
(105, 'IT', 'Italy'),
(106, 'CI', 'Ivory Coast'),
(107, 'JM', 'Jamaica'),
(108, 'JP', 'Japan'),
(109, 'JO', 'Jordan'),
(110, 'KZ', 'Kazakhstan'),
(111, 'KE', 'Kenya'),
(112, 'KI', 'Kiribati'),
(113, 'KP', 'Korea, Democratic People''s Republic of'),
(114, 'KR', 'Korea, Republic of'),
(115, 'XK', 'Kosovo'),
(116, 'KW', 'Kuwait'),
(117, 'KG', 'Kyrgyzstan'),
(118, 'LA', 'Lao People''s Democratic Republic'),
(119, 'LV', 'Latvia'),
(120, 'LB', 'Lebanon'),
(121, 'LS', 'Lesotho'),
(122, 'LR', 'Liberia'),
(123, 'LY', 'Libyan Arab Jamahiriya'),
(124, 'LI', 'Liechtenstein'),
(125, 'LT', 'Lithuania'),
(126, 'LU', 'Luxembourg'),
(127, 'MO', 'Macau'),
(128, 'MK', 'Macedonia'),
(129, 'MG', 'Madagascar'),
(130, 'MW', 'Malawi'),
(131, 'MY', 'Malaysia'),
(132, 'MV', 'Maldives'),
(133, 'ML', 'Mali'),
(134, 'MT', 'Malta'),
(135, 'MH', 'Marshall Islands'),
(136, 'MQ', 'Martinique'),
(137, 'MR', 'Mauritania'),
(138, 'MU', 'Mauritius'),
(139, 'TY', 'Mayotte'),
(140, 'MX', 'Mexico'),
(141, 'FM', 'Micronesia, Federated States of'),
(142, 'MD', 'Moldova, Republic of'),
(143, 'MC', 'Monaco'),
(144, 'MN', 'Mongolia'),
(145, 'ME', 'Montenegro'),
(146, 'MS', 'Montserrat'),
(147, 'MA', 'Morocco'),
(148, 'MZ', 'Mozambique'),
(149, 'MM', 'Myanmar'),
(150, 'NA', 'Namibia'),
(151, 'NR', 'Nauru'),
(152, 'NP', 'Nepal'),
(153, 'NL', 'Netherlands'),
(154, 'AN', 'Netherlands Antilles'),
(155, 'NC', 'New Caledonia'),
(156, 'NZ', 'New Zealand'),
(157, 'NI', 'Nicaragua'),
(158, 'NE', 'Niger'),
(159, 'NG', 'Nigeria'),
(160, 'NU', 'Niue'),
(161, 'NF', 'Norfork Island'),
(162, 'MP', 'Northern Mariana Islands'),
(163, 'NO', 'Norway'),
(164, 'OM', 'Oman'),
(165, 'PK', 'Pakistan'),
(166, 'PW', 'Palau'),
(167, 'PA', 'Panama'),
(168, 'PG', 'Papua New Guinea'),
(169, 'PY', 'Paraguay'),
(170, 'PE', 'Peru'),
(171, 'PH', 'Philippines'),
(172, 'PN', 'Pitcairn'),
(173, 'PL', 'Poland'),
(174, 'PT', 'Portugal'),
(175, 'PR', 'Puerto Rico'),
(176, 'QA', 'Qatar'),
(177, 'RE', 'Reunion'),
(178, 'RO', 'Romania'),
(179, 'RU', 'Russian Federation'),
(180, 'RW', 'Rwanda'),
(181, 'KN', 'Saint Kitts and Nevis'),
(182, 'LC', 'Saint Lucia'),
(183, 'VC', 'Saint Vincent and the Grenadines'),
(184, 'WS', 'Samoa'),
(185, 'SM', 'San Marino'),
(186, 'ST', 'Sao Tome and Principe'),
(187, 'SA', 'Saudi Arabia'),
(188, 'SN', 'Senegal'),
(189, 'RS', 'Serbia'),
(190, 'SC', 'Seychelles'),
(191, 'SL', 'Sierra Leone'),
(192, 'SG', 'Singapore'),
(193, 'SK', 'Slovakia'),
(194, 'SI', 'Slovenia'),
(195, 'SB', 'Solomon Islands'),
(196, 'SO', 'Somalia'),
(197, 'ZA', 'South Africa'),
(198, 'GS', 'South Georgia South Sandwich Islands'),
(199, 'ES', 'Spain'),
(200, 'LK', 'Sri Lanka'),
(201, 'SH', 'St. Helena'),
(202, 'PM', 'St. Pierre and Miquelon'),
(203, 'SD', 'Sudan'),
(204, 'SR', 'Suriname'),
(205, 'SJ', 'Svalbarn and Jan Mayen Islands'),
(206, 'SZ', 'Swaziland'),
(207, 'SE', 'Sweden'),
(208, 'CH', 'Switzerland'),
(209, 'SY', 'Syrian Arab Republic'),
(210, 'TW', 'Taiwan'),
(211, 'TJ', 'Tajikistan'),
(212, 'TZ', 'Tanzania, United Republic of'),
(213, 'TH', 'Thailand'),
(214, 'TG', 'Togo'),
(215, 'TK', 'Tokelau'),
(216, 'TO', 'Tonga'),
(217, 'TT', 'Trinidad and Tobago'),
(218, 'TN', 'Tunisia'),
(219, 'TR', 'Turkey'),
(220, 'TM', 'Turkmenistan'),
(221, 'TC', 'Turks and Caicos Islands'),
(222, 'TV', 'Tuvalu'),
(223, 'UG', 'Uganda'),
(224, 'UA', 'Ukraine'),
(225, 'AE', 'United Arab Emirates'),
(226, 'GB', 'United Kingdom'),
(227, 'UM', 'United States minor outlying islands'),
(228, 'UY', 'Uruguay'),
(229, 'UZ', 'Uzbekistan'),
(230, 'VU', 'Vanuatu'),
(231, 'VA', 'Vatican City State'),
(232, 'VE', 'Venezuela'),
(233, 'VN', 'Vietnam'),
(234, 'VG', 'Virgin Islands (British)'),
(235, 'VI', 'Virgin Islands (U.S.)'),
(236, 'WF', 'Wallis and Futuna Islands'),
(237, 'EH', 'Western Sahara'),
(238, 'YE', 'Yemen'),
(239, 'YU', 'Yugoslavia'),
(240, 'ZR', 'Zaire'),
(241, 'ZM', 'Zambia'),
(242, 'ZW', 'Zimbabwe');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=243;
  

CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `months` int(3) unsigned NOT NULL,
  `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`),
  KEY `timestamp` (`timestamp`),
  KEY `user_id_2` (`user_id`,`product_id`)
);

ALTER TABLE product_href ADD `last_update` int(11) unsigned NOT NULL;

CREATE TABLE IF NOT EXISTS `product_href_mark` (
  `id` int(10) unsigned NOT NULL,
  `href_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB;

ALTER TABLE product_href ADD `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;


-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 25 2017 г., 00:10
-- Версия сервера: 5.5.50
-- Версия PHP: 5.4.45

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `mh`
--

-- --------------------------------------------------------

--
-- Структура таблицы `about_us_content`
--

CREATE TABLE IF NOT EXISTS `about_us_content` (
  `id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `href` varchar(255) NOT NULL DEFAULT '',
  `author_name` varchar(255) NOT NULL DEFAULT '',
  `author_bio` varchar(255) NOT NULL DEFAULT '',
  `avatar_image` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `about_us_content`
--

INSERT INTO `about_us_content` (`id`, `title`, `content`, `href`, `author_name`, `author_bio`, `avatar_image`, `image`) VALUES
(1, 'Press 1', '<p>The claim is true: you do not have to write your own backend for a lot of application and for a lot of common needs. It is exciting where the industry is going in the future with more APIs and the marketplace-style direction.</p>', 'type1', '', '', '', 'main_1.png'),
(2, 'Press 2', '<p>The claim is true: you do not have to write your own backend for a lot of application and for a lot of common needs. It is exciting where the industry is going in the future with more APIs and the marketplace-style direction.</p>', 'type1', '', '', '', 'main_2.png'),
(3, 'Press 3', '<p>The claim is true: you do not have to write your own backend for a lot of application and for a lot of common needs. It is exciting where the industry is going in the future with more APIs and the marketplace-style direction.</p>', 'type1', '', '', '', 'main_3.jpg'),
(4, 'Think 1', '<p>&ldquo;The claim is true: you do not have to write your own backend for a lot of application and for a lot of common needs. It is exciting where the industry is going in the future with more APIs and the marketplace&rdquo;</p>', 'type2', 'Gary Meyer', 'CEO, Framework7', '', 'main_4.png'),
(5, 'Think 2', '<p>&ldquo;The claim is true: you do not have to write your own backend for a lot of application and for a lot of common needs. It is exciting where the industry is going in the future with more APIs and the marketplace-style direction. We will see it being easier and easier to build pretty sophisticated applications and not writing any server-side code. We will see it being easier and easier to build pretty sophisticated applications and not writing any server-side code.&rdquo;</p>', 'type2', 'Drew Ashlock', 'Product Manager, Invidio', '', 'main_5.png'),
(6, 'Think 3', '<p>&ldquo;The claim is true: you do not have to write your own backend for a lot of application and for a lot of common needs. It is exciting where the industry is going in the future with more APIs and the marketplace-style direction. We will see it being easier and easier to build pretty sophisticated applications and not writing any server-side code.&rdquo;</p>', 'type2', 'Alexey Malcev', 'General Marcetolog, SEOtrust', '', 'main_6.png'),
(7, 'Think 4', '<p>&ldquo;The claim is true: you do not have to write your own backend for a lot of application and for a lot of common needs. It is exciting where the industry is going in the future with more APIs and the marketplace&rdquo;</p>', 'type2', 'Gary Meyer', 'CEO, Framework7', '', 'main_7.jpg'),
(8, 'Think 5', '<p>&ldquo;The claim is true: you do not have to write your own backend for a lot of application and for a lot of common needs. It is exciting where the industry is going in the future with more APIs and the marketplace-style direction. We will see it being easier and easier to build pretty sophisticated applications and not writing any server-side code. We will see it being easier and easier to build pretty sophisticated applications and not writing any server-side code.&rdquo;</p>', 'type2', 'Drew Ashlock', 'Product Manager, Invidio', '', 'main_8.png');

-- --------------------------------------------------------

--
-- Структура таблицы `discount`
--

CREATE TABLE IF NOT EXISTS `discount` (
  `id` int(11) unsigned NOT NULL,
  `date_from` int(11) NOT NULL,
  `date_to` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` int(2) unsigned NOT NULL,
  `percent` int(11) unsigned NOT NULL,
  `file1` varchar(255) NOT NULL DEFAULT '',
  `file2` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `discount`
--

INSERT INTO `discount` (`id`, `date_from`, `date_to`, `title`, `status`, `percent`, `file1`, `file2`) VALUES
(6, 1496782800, 1499461200, 'Discount 11', 0, 2, 'discount_file1_6.png', 'discount_file2_6.png'),
(7, 1496782800, 1497560400, 'Discoun 2', 0, 10, 'discount_file1_7.png', 'discount_file2_7.jpg'),
(8, 1496869200, 1498078800, 'jfghjfgjh', 0, 11, 'discount_file1_8.png', 'discount_file2_8.png'),
(9, 1496523600, 1504126800, 'Free', 1, 100, 'discount_file1_9.jpg', 'discount_file2_9.png');

-- --------------------------------------------------------

--
-- Структура таблицы `discount_to_product`
--

CREATE TABLE IF NOT EXISTS `discount_to_product` (
  `id` int(11) unsigned NOT NULL,
  `discount_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `discount_to_product`
--

INSERT INTO `discount_to_product` (`id`, `discount_id`, `product_id`) VALUES
(1, 6, 14),
(3, 6, 11),
(4, 6, 15),
(5, 7, 16),
(6, 7, 9),
(7, 8, 11),
(8, 9, 11);

-- --------------------------------------------------------

--
-- Структура таблицы `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `popular_question` tinyint(1) DEFAULT '0',
  `order` tinyint(3) unsigned NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `faq`
--

INSERT INTO `faq` (`id`, `title`, `answer`, `popular_question`, `order`) VALUES
(1, 'Faq Title 1', '<p>TExt</p>', 0, 1),
(2, 'Faq Title 2', '<p>TExt</p>', 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `faq_category`
--

CREATE TABLE IF NOT EXISTS `faq_category` (
  `id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `faq_category`
--

INSERT INTO `faq_category` (`id`, `title`) VALUES
(1, 'Faq Category 1'),
(2, 'Faq Category 2');

-- --------------------------------------------------------

--
-- Структура таблицы `faq_to_category`
--

CREATE TABLE IF NOT EXISTS `faq_to_category` (
  `faq_id` int(11) unsigned NOT NULL,
  `category_id` int(11) unsigned NOT NULL,
  `id` int(11) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `faq_to_category`
--

INSERT INTO `faq_to_category` (`faq_id`, `category_id`, `id`) VALUES
(1, 1, 1),
(2, 2, 2),
(1, 2, 3);

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
-- Структура таблицы `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) unsigned NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` int(2) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `total` float NOT NULL DEFAULT '0',
  `payment_method` varchar(50) NOT NULL,
  `payment_status` int(2) unsigned NOT NULL,
  `transaction_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`id`, `created_at`, `updated_at`, `status`, `user_id`, `total`, `payment_method`, `payment_status`, `transaction_id`) VALUES
(1, 1496236963, 1496236963, 1, 1, 3000, '1', 1, 1);

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `order_to_product` (
  `id` int(11) unsigned NOT NULL,
  `order_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  `discount` float NOT NULL DEFAULT '0',
  `months` int(11) unsigned NOT NULL DEFAULT '0',
  `expires`  int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `order_to_product`
--

INSERT INTO `order_to_product` (`id`, `order_id`, `product_id`, `price`, `months`) VALUES
(1, 1, 8, 0, 1),
(2, 1, 9, 0, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `pages_content`
--

CREATE TABLE IF NOT EXISTS `pages_content` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `href` varchar(255) NOT NULL DEFAULT '',
  `static` tinyint(1) DEFAULT '0',
  `submenu` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pages_content`
--

INSERT INTO `pages_content` (`id`, `name`, `content`, `href`, `static`, `submenu`) VALUES
(1, 'Main Page Content', '<p>TExt</p>', '', 0, ''),
(2, 'Maine Page Left Description', '<p>TEst</p>', '', 0, ''),
(3, 'About Us Content', '<p>text</p>', '', 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `content` text,
  `meta_description` varchar(500) NOT NULL DEFAULT '',
  `meta_keywords` varchar(500) NOT NULL DEFAULT '',
  `url_anckor` varchar(100) NOT NULL DEFAULT '',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `sent` tinyint(1) NOT NULL DEFAULT '0',
  `active` int(1) unsigned NOT NULL DEFAULT '0',
  `author_name` varchar(100) NOT NULL DEFAULT '',
  `author_bio` text NOT NULL,
  `avatar_image` varchar(255) NOT NULL,
  `about_us_content` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `post`
--

INSERT INTO `post` (`id`, `title`, `image`, `content`, `meta_description`, `meta_keywords`, `url_anckor`, `views`, `created_at`, `updated_at`, `sent`, `active`, `author_name`, `author_bio`, `avatar_image`, `about_us_content`) VALUES
(9, 'Last', 'main_9.jpg', '<p>asdf</p>', 'Today, we will explain the most common problems related to the efficiency of sponsored posts, guest posts and articles hosted on GUI websites.', 'guest posts, sponsored posts, guest posting, GUI websites, backlinks, Wikipedia', 'why-sponsored-posts-do-not-work-and-how-to-correct-this', 0, 1496950779, 1499330127, 0, 1, '', '', '', ''),
(10, 'Why Some Sponsored Posts and Guest Posts Sometimes Do Not Work and How to Correct This?', 'main_10.jpg', '<p>asdfsd</p>', 'Today, we will explain the most common problems related to the efficiency of sponsored posts, guest posts and articles hosted on GUI websites.', 'guest posts, sponsored posts, guest posting, GUI websites, backlinks, Wikipedia', 'why-sponsored-posts-do-not-work-and-how-to-correct-this', 0, 1496950803, 1499323973, 0, 1, '', '', '', ''),
(11, 'Why Some Sponsored Posts and Guest Posts Sometimes Do Not Work and How to Correct This?', 'main_11.jpg', '<p>asdf</p>', 'Today, we will explain the most common problems related to the efficiency of sponsored posts, guest posts and articles hosted on GUI websites.', 'guest posts, sponsored posts, guest posting, GUI websites, backlinks, Wikipedia', 'why-sponsored-posts-do-not-work-and-how-to-correct-this', 0, 1496950821, 1499286799, 0, 1, '', '', '', ''),
(12, 'Why Some Sponsored Posts and Guest Posts Sometimes Do Not Work and How to Correct This?', 'main_12.jpg', '<p>asdf</p>', 'Today, we will explain the most common problems related to the efficiency of sponsored posts, guest posts and articles hosted on GUI websites.', 'guest posts, sponsored posts, guest posting, GUI websites, backlinks, Wikipedia', 'why-sponsored-posts-do-not-work-and-how-to-correct-this', 0, 1496950835, 1499287277, 0, 1, 'Anna Talerico', '', '', ''),
(13, 'Why Some Sponsored Posts and Guest Posts Sometimes Do Not Work and How to Correct This?', 'main_13.jpg', '<p>sdfgsdfgsdfg</p>', 'Today, we will explain the most common problems related to the efficiency of sponsored posts, guest posts and articles hosted on GUI websites.', 'guest posts, sponsored posts, guest posting, GUI websites, backlinks, Wikipedia', 'why-sponsored-posts-do-not-work-and-how-to-correct-this', 0, 1499324018, 1499324018, 0, 1, '', '', '', ''),
(14, 'Why Some Sponsored Posts and Guest Posts Sometimes Do Not Work and How to Correct This?', 'main_14.jpg', '<p>sdfgsdfgsdfg</p>', 'Today, we will explain the most common problems related to the efficiency of sponsored posts, guest posts and articles hosted on GUI websites.', 'guest posts, sponsored posts, guest posting, GUI websites, backlinks, Wikipedia', 'why-sponsored-posts-do-not-work-and-how-to-correct-this', 0, 1499324056, 1499324056, 0, 1, '', '', '', ''),
(15, 'Why Some Sponsored Posts and Guest Posts Sometimes Do Not Work and How to Correct This?', 'main_15.jpg', '<p>asdf</p>', 'Today, we will explain the most common problems related to the efficiency of sponsored posts, guest posts and articles hosted on GUI websites.', 'guest posts, sponsored posts, guest posting, GUI websites, backlinks, Wikipedia', 'why-sponsored-posts-do-not-work-and-how-to-correct-this', 0, 1499334500, 1499334500, 0, 1, '', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `post_category`
--

CREATE TABLE IF NOT EXISTS `post_category` (
  `id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `post_category`
--

INSERT INTO `post_category` (`id`, `title`) VALUES
(1, 'Google Optimization'),
(2, 'Google Filters'),
(3, 'Link Building2');

-- --------------------------------------------------------

--
-- Структура таблицы `post_to_category`
--

CREATE TABLE IF NOT EXISTS `post_to_category` (
  `post_id` int(11) unsigned NOT NULL,
  `category_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `post_to_category`
--

INSERT INTO `post_to_category` (`post_id`, `category_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 1),
(9, 3),
(10, 1),
(10, 3),
(11, 1),
(11, 3),
(12, 1),
(12, 3),
(13, 2),
(14, 2),
(15, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` float unsigned NOT NULL,
  `status` int(2) unsigned NOT NULL DEFAULT '0',
  `order` smallint(6) NOT NULL,
  `short_title` varchar(255) NOT NULL,
  `full_title` varchar(1000) NOT NULL,
  `link_name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `title`, `price`, `status`, `order`, `short_title`, `full_title`, `link_name`) VALUES
(8, 'Guest Posting Marketing', 2000, 1, 3, 'Guest Posting Marketing', 'Guest Posting Marketing', 'Learn more'),
(9, 'Q&A Link Building Techniques', 1000, 1, 2, 'Q&A Link Building Techniques', 'Q&A Link Building Techniques', 'Learn more'),
(11, 'Forum Link Building Techniques', 655.99, 1, 0, 'Forum Link Building Techniques', 'Forum Link Building Techniques', 'Learn more'),
(15, 'Guest Posting Marketing ', 2345, 1, 1, 'Guest Posting Marketing ', 'Guest Posting Marketing ', 'Learn more'),
(16, 'Forum Link Building Techniques 2', 123, 1, 4, 'Forum Link Building Techniques', 'Forum Link Building Techniques', 'Learn more');

-- --------------------------------------------------------

--
-- Структура таблицы `product_guide`
--

CREATE TABLE IF NOT EXISTS `product_guide` (
  `id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `status` int(2) unsigned NOT NULL DEFAULT '0',
  `about` text,
  `order` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product_guide`
--

INSERT INTO `product_guide` (`id`, `product_id`, `title`, `status`, `about`, `order`) VALUES
(1, 11, 'Title 1', 1, '<p style="text-align: center;"><img src="index.php?r=product-guide%2Fget-image&amp;id=1495055008.4528.png" alt="" width="236" height="213" />testsdfgsdfg</p>', 0),
(2, 11, 'Title 2', 1, '<p>sdsdfgsdfgsdfg</p>', 1),
(3, 17, 'Item 1', 1, '<p>dfsgsdfgsdfg</p>', 2),
(4, 17, 'Item 3', 1, '<p>sdfgsdfgsdfg</p>', 3),
(5, 15, 'How to get traffic and backlinks on popular forums?', 1, '<p>How to get traffic and backlinks on popular forums?</p>', 4),
(6, 15, 'How to place links and do not look like spammer?', 1, '<p>How to place links and do not look like spammer?</p>', 5),
(7, 15, 'Which links on forums do work and which one not and why?', 1, '<p>Which links on forums do work and which one not and why?&lt;/</p>', 6),
(8, 15, 'How to make big traffic from forums?', 1, '<p>How to make big traffic from forums?</p>', 7),
(9, 15, 'Where and how to find new forums?', 1, '<p>Where and how to find new forums?</p>', 8);

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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product_href`
--

INSERT INTO `product_href` (`id`, `product_id`, `url`, `status`, `alexa_rank`, `da_rank`, `about`, `example_url`, `type_links`) VALUES
(1, 15, 'http://korrespondent.net/', 1, 2933, 67.31, '', 'http://www.yiiframework.com/do', 'nolinks'),
(2, 15, 'http://auto.ria.com/', 1, 0, 60.62, 'Details', 'http://www.yiiframework.com/do', 'redirect'),
(3, 11, 'http://auto.ria.com/22', 1, 0, 60.62, 'sasdfasdf', 'http://www.yiiframework.com/do', 'follow'),
(27, 11, 'http://www.yiiframework.com/do', 1, 0, 72.48, 'sdfgs', 'http://www.yiiframework.com/do', 'nofollow'),
(28, 11, 'http://www.yiiframework.com/do', 1, 0, 72.48, 'dfgsdfg', 'http://www.yiiframework.com/do', 'nofollow'),
(29, 11, 'http://www.yiiframework.com/do', 1, 0, 72.48, '4', 'http://www.yiiframework.com/do', 'nolinks'),
(30, 11, 'http://www.yiiframework.com/do', 1, 0, 72.48, '5', 'http://www.yiiframework.com/do', 'redirect'),
(31, 11, 'http://www.yiiframework.com/do', 1, 0, 72.48, '6', 'http://www.yiiframework.com/do', 'nolinks'),
(32, 11, 'http://www.yiiframework.com/do', 1, 0, 72.48, '7', 'http://www.yiiframework.com/do', 'redirect'),
(33, 17, 'https://stackoverflow.com', 1, 53, 91.25, 'Details', 'https://stackoverflow.com', 'nolinks'),
(34, 17, 'https://stackoverflow.com', 1, 53, 91.25, 'Details', 'https://stackoverflow.com', 'redirect');

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
(3, 2),
(3, 3),
(27, 3),
(28, 3),
(29, 3),
(30, 4),
(31, 2),
(32, 3),
(33, 2),
(33, 4),
(34, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `product_page`
--

CREATE TABLE IF NOT EXISTS `product_page` (
  `id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `guide_description` varchar(500) NOT NULL DEFAULT '',
  `list_description` varchar(500) NOT NULL DEFAULT '',
  `feature1` varchar(500) NOT NULL DEFAULT '',
  `feature2` varchar(500) NOT NULL DEFAULT '',
  `feature3` varchar(500) NOT NULL DEFAULT '',
  `feature4` varchar(500) NOT NULL DEFAULT '',
  `feature5` varchar(500) NOT NULL DEFAULT '',
  `content` text
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product_page`
--

INSERT INTO `product_page` (`id`, `product_id`, `title`, `description`, `guide_description`, `list_description`, `feature1`, `feature2`, `feature3`, `feature4`, `feature5`, `content`) VALUES
(1, 11, 'Product Page Titlw', 'Feature 5', 'Guide Description', 'Guide Description', 'Feature 1', 'Feature 2', 'Feature 3', 'Feature 3', 'Feature 5', '<p><strong>Content Con</strong>tentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent Cont<strong>entC</strong></p>\r\n<p>&nbsp;</p>\r\n<p style="text-align: center;"><strong>ontent </strong></p>\r\n<p style="text-align: justify;">&nbsp;</p>\r\n<p style="text-align: justify;"><strong>ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent</strong></p>\r\n<p>&nbsp;</p>\r\n<p><strong> ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent Cont</strong>entContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent Con<strong>tentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent Con</strong>tentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent ContentContent Content</p>');

-- --------------------------------------------------------

--
-- Структура таблицы `product_review`
--

CREATE TABLE IF NOT EXISTS `product_review` (
  `id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `raiting` int(1) unsigned NOT NULL DEFAULT '0',
  `content` text,
  `active` int(1) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `product_review`
--

INSERT INTO `product_review` (`id`, `product_id`, `user_id`, `name`, `email`, `raiting`, `content`, `active`, `created_at`) VALUES
(1, 11, 0, 'sdf', 'sdf@sdsfd.com', 3, 'sdfsdf', 1, '2017-07-11 21:00:00'),
(2, 11, 0, 'sdfsdf', 'sdfsdf@sdfsdf.xom', 2, 'sdfsdf', 1, '0000-00-00 00:00:00'),
(3, 11, 0, 'Review name', 'masdas@sdfsdf.xom', 5, 'asdfasd fasdf asdf asdf asdf', 1, '2017-07-21 07:53:44'),
(4, 11, 0, 'sdfg', 'sdf@sdsfd.com', 4, 'sdf gsdf g', 0, '2017-07-21 08:05:39'),
(5, 11, 0, 'Name', 'sdfsdf@sdfsdf.xom', 2, 'fgjhfg fghj fgj fjh', 1, '2017-07-21 08:07:33'),
(6, 11, 0, 'Review name', 'masdas@sdfsdf.xom', 1, 'sdfgsdfg', 1, '2017-07-21 08:09:09');

-- --------------------------------------------------------

--
-- Структура таблицы `subscriber`
--

CREATE TABLE IF NOT EXISTS `subscriber` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  `ip` int(11) unsigned NOT NULL,
  `active` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `subscriber`
--

INSERT INTO `subscriber` (`id`, `name`, `email`, `created_at`, `updated_at`, `ip`, `active`) VALUES
(1, 'name', 'dfsfd@sdfsdf.com', 1500927768, 1500927768, 2130706433, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int(1) unsigned NOT NULL DEFAULT '0',
  `subscribe` int(1) unsigned NOT NULL DEFAULT '0',
  `password` varchar(50) NOT NULL DEFAULT '',
  `registration_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `phone`, `name`, `subscribe`, `active`, `password`, `registration_confirmed`, `created_at`, `updated_at`) VALUES
(1, '', '', NULL, 'email@ddddd.com', '123123123123123', 'User name', 1, 1, '$2y$13$pUhBtYNrU7j3uk.JvB5AHeM2WlbQOX4YOAgvseScTil', 0, 1496127679, 1497515902);

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
-- Индексы таблицы `about_us_content`
--
ALTER TABLE `about_us_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `href` (`href`);

--
-- Индексы таблицы `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date_from` (`date_from`),
  ADD KEY `date_to` (`date_to`);

--
-- Индексы таблицы `discount_to_product`
--
ALTER TABLE `discount_to_product`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `faq_category`
--
ALTER TABLE `faq_category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `faq_to_category`
--
ALTER TABLE `faq_to_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faq_id` (`faq_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `created_at` (`created_at`);

--
-- Индексы таблицы `order_to_product`
--
ALTER TABLE `order_to_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `pages_content`
--
ALTER TABLE `pages_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `href` (`href`);

--
-- Индексы таблицы `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `views` (`views`),
  ADD KEY `url_anckor` (`url_anckor`);

--
-- Индексы таблицы `post_category`
--
ALTER TABLE `post_category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `post_to_category`
--
ALTER TABLE `post_to_category`
  ADD KEY `post_id` (`post_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `price` (`price`),
  ADD KEY `title` (`title`);

--
-- Индексы таблицы `product_guide`
--
ALTER TABLE `product_guide`
  ADD PRIMARY KEY (`id`);

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
-- Индексы таблицы `product_page`
--
ALTER TABLE `product_page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `product_review`
--
ALTER TABLE `product_review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `subscriber`
--
ALTER TABLE `subscriber`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `ip` (`ip`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`),
  ADD KEY `email` (`email`),
  ADD KEY `name` (`name`);

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
-- AUTO_INCREMENT для таблицы `about_us_content`
--
ALTER TABLE `about_us_content`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `discount`
--
ALTER TABLE `discount`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `discount_to_product`
--
ALTER TABLE `discount_to_product`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `faq_category`
--
ALTER TABLE `faq_category`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `faq_to_category`
--
ALTER TABLE `faq_to_category`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `order_to_product`
--
ALTER TABLE `order_to_product`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `pages_content`
--
ALTER TABLE `pages_content`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT для таблицы `post_category`
--
ALTER TABLE `post_category`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT для таблицы `product_guide`
--
ALTER TABLE `product_guide`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `product_href`
--
ALTER TABLE `product_href`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT для таблицы `product_href_category`
--
ALTER TABLE `product_href_category`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `product_page`
--
ALTER TABLE `product_page`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `product_review`
--
ALTER TABLE `product_review`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `subscriber`
--
ALTER TABLE `subscriber`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `user_backend`
--
ALTER TABLE `user_backend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;