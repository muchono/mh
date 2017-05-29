-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 29 2017 г., 11:24
-- Версия сервера: 5.5.40
-- Версия PHP: 5.4.35-0+deb7u2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `netger`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bitcoin_address`
--

CREATE TABLE IF NOT EXISTS `bitcoin_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(100) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Структура таблицы `bitcoin_payment`
--

CREATE TABLE IF NOT EXISTS `bitcoin_payment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `address` varchar(100) NOT NULL,
  `total` float NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `confirmation_amount` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `transaction_hash` varchar(255) NOT NULL DEFAULT '',
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `address` (`address`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `index` int(3) unsigned NOT NULL,
  `time` datetime NOT NULL,
  `anchor` varchar(255) NOT NULL DEFAULT '',
  `comment` varchar(1000) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `time_interval` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`),
  KEY `time` (`time`),
  KEY `user_id_2` (`user_id`,`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=441 ;

-- --------------------------------------------------------

--
-- Структура таблицы `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=243 ;

-- --------------------------------------------------------

--
-- Структура таблицы `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `popular_question` tinyint(1) DEFAULT '0',
  `order` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

-- --------------------------------------------------------

--
-- Структура таблицы `faq_category`
--

CREATE TABLE IF NOT EXISTS `faq_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Структура таблицы `faq_to_category`
--

CREATE TABLE IF NOT EXISTS `faq_to_category` (
  `faq_id` int(11) unsigned NOT NULL,
  `category_id` int(11) unsigned NOT NULL,
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `faq_id` (`faq_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=109 ;

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date_added` datetime DEFAULT NULL,
  `title` varchar(500) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `content` text CHARACTER SET utf8,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `img` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) unsigned NOT NULL,
  `time` datetime NOT NULL,
  `status` int(2) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `time_interval` int(5) unsigned NOT NULL DEFAULT '1',
  `total` float NOT NULL DEFAULT '0',
  `payment_method` varchar(50) NOT NULL,
  `payment_status` int(2) unsigned NOT NULL,
  `transaction_id` int(11) NOT NULL DEFAULT '0',
  `notif_frequency` smallint(5) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `order_to_product`
--

CREATE TABLE IF NOT EXISTS `order_to_product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `anchor` varchar(255) NOT NULL,
  `comment` varchar(1000) NOT NULL DEFAULT '',
  `status` int(2) unsigned NOT NULL DEFAULT '0',
  `price` float NOT NULL DEFAULT '0',
  `task_date` date NOT NULL,
  `writer_id` int(11) unsigned NOT NULL DEFAULT '0',
  `date_start` date NOT NULL,
  `url` varchar(500) NOT NULL,
  `url_res` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`,`product_id`),
  KEY `status` (`status`),
  KEY `task_date` (`task_date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=213 ;

-- --------------------------------------------------------

--
-- Структура таблицы `pages_content`
--

CREATE TABLE IF NOT EXISTS `pages_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `content` text CHARACTER SET utf8 NOT NULL,
  `href` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `static` tinyint(1) DEFAULT '0',
  `submenu` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Структура таблицы `pages_content_hide`
--

CREATE TABLE IF NOT EXISTS `pages_content_hide` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `href` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`href`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100 ;

-- --------------------------------------------------------

--
-- Структура таблицы `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `content` text,
  `author_name` varchar(255) NOT NULL DEFAULT '',
  `author_image` varchar(255) NOT NULL DEFAULT '',
  `author_content` text,
  `show_author` int(1) unsigned NOT NULL DEFAULT '0',
  `meta_description` varchar(500) NOT NULL DEFAULT '',
  `meta_keywords` varchar(500) NOT NULL DEFAULT '',
  `url_anckor` varchar(100) NOT NULL DEFAULT '',
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  `sent` tinyint(1) NOT NULL DEFAULT '0',
  `active` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `views` (`views`),
  KEY `url_anckor` (`url_anckor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

-- --------------------------------------------------------

--
-- Структура таблицы `post_category`
--

CREATE TABLE IF NOT EXISTS `post_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Структура таблицы `post_to_category`
--

CREATE TABLE IF NOT EXISTS `post_to_category` (
  `post_id` int(11) unsigned NOT NULL,
  `category_id` int(11) unsigned NOT NULL,
  KEY `post_id` (`post_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT '',
  `age` int(4) unsigned NOT NULL DEFAULT '0',
  `price` float unsigned NOT NULL,
  `link` int(2) unsigned NOT NULL DEFAULT '0',
  `anchor` int(2) unsigned NOT NULL DEFAULT '0',
  `status` int(2) unsigned NOT NULL DEFAULT '0',
  `traffic` bigint(20) NOT NULL DEFAULT '0',
  `google_pr` int(2) unsigned NOT NULL DEFAULT '0',
  `alexa_rank` int(11) unsigned NOT NULL DEFAULT '0',
  `orders` int(11) unsigned NOT NULL DEFAULT '0',
  `traffic_update_date` datetime DEFAULT NULL,
  `domain_zone` varchar(10) NOT NULL DEFAULT '',
  `da_rank` float NOT NULL DEFAULT '0',
  `stat_update_date` datetime DEFAULT NULL,
  `about` text,
  PRIMARY KEY (`id`),
  KEY `orders` (`orders`),
  KEY `age` (`age`),
  KEY `status` (`status`),
  KEY `traffic` (`traffic`),
  KEY `price` (`price`),
  KEY `google_pr` (`google_pr`),
  KEY `domain_zone` (`domain_zone`),
  KEY `anchor` (`anchor`),
  KEY `link` (`link`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=291 ;

-- --------------------------------------------------------

--
-- Структура таблицы `product_category`
--

CREATE TABLE IF NOT EXISTS `product_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `view_num` int(11) unsigned NOT NULL DEFAULT '0',
  `sale_num` int(11) unsigned NOT NULL DEFAULT '0',
  `product_num` int(11) unsigned NOT NULL DEFAULT '0',
  `product_general_num` int(11) unsigned NOT NULL DEFAULT '0',
  `editable` int(1) unsigned NOT NULL DEFAULT '1',
  `sort_order` int(3) unsigned NOT NULL DEFAULT '1',
  `coefficient` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Структура таблицы `product_to_category`
--

CREATE TABLE IF NOT EXISTS `product_to_category` (
  `product_id` int(11) unsigned NOT NULL,
  `category_id` int(11) unsigned NOT NULL,
  KEY `product_id` (`product_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `password` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `subscriber`
--

CREATE TABLE IF NOT EXISTS `subscriber` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Структура таблицы `transaction`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=286 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `orders_num` int(11) unsigned NOT NULL DEFAULT '0',
  `websites_num` int(11) unsigned NOT NULL DEFAULT '0',
  `subscribe` int(1) unsigned NOT NULL DEFAULT '0',
  `active` int(1) unsigned NOT NULL DEFAULT '0',
  `password` varchar(50) NOT NULL DEFAULT '',
  `resource` varchar(50) NOT NULL DEFAULT '',
  `registration_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `fb` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=357 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user_billing`
--

CREATE TABLE IF NOT EXISTS `user_billing` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `full_name` varchar(255) NOT NULL DEFAULT '',
  `company_name` varchar(255) NOT NULL DEFAULT '',
  `country` int(11) unsigned NOT NULL DEFAULT '0',
  `address` varchar(255) NOT NULL DEFAULT '',
  `zip` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  `payment` varchar(50) NOT NULL DEFAULT '',
  `agreed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

-- --------------------------------------------------------

--
-- Структура таблицы `writer`
--

CREATE TABLE IF NOT EXISTS `writer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `payment_id` varchar(255) NOT NULL DEFAULT '',
  `assign_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assign_date` (`assign_date`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
