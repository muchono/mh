
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1493834717),
('m130524_201442_init', 1493834724);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` float unsigned NOT NULL,
  `status` int(2) unsigned NOT NULL DEFAULT '0',
  `orders` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `product_guide`
--

CREATE TABLE IF NOT EXISTS `product_guide` (
  `id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `status` int(2) unsigned NOT NULL DEFAULT '0',
  `traffic` bigint(20) NOT NULL DEFAULT '0',
  `google_pr` int(2) unsigned NOT NULL DEFAULT '0',
  `alexa_rank` int(11) unsigned NOT NULL DEFAULT '0',
  `da_rank` float NOT NULL DEFAULT '0',
  `about` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_href`
--

CREATE TABLE IF NOT EXISTS `product_href` (
  `id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `category_id` int(11) unsigned NOT NULL,
  `url` varchar(255) NOT NULL,
  `status` int(2) unsigned NOT NULL DEFAULT '0',
  `alexa_rank` int(11) unsigned NOT NULL DEFAULT '0',
  `da_rank` float NOT NULL DEFAULT '0',
  `about` text,
  `example_url` varchar(255) NOT NULL,
  `type_links` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
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
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', '', '$2y$13$C0fkgk3txcpzrEcgo.sUzuMnRW8lXJ6RDrYL1.o/Tem7iO5Wm4VJS', NULL, '', 10, 1493838079, 1493838079);

--
-- Indexes for dumped tables
--
CREATE TABLE IF NOT EXISTS `product_href_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `product_href_to_category` (
  `product_id` int(11) unsigned NOT NULL,
  `category_id` int(11) unsigned NOT NULL,
  KEY `product_id` (`product_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `price` (`price`);

--
-- Indexes for table `product_guide`
--
ALTER TABLE `product_guide`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_href`
--
ALTER TABLE `product_href`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `product_href`
--
ALTER TABLE `product_href`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;