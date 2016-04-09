CREATE TABLE `deed` (
    `id` INT(11) UNSIGNED NOT NULL auto_increment,
    `subject` varchar(256) collate utf8_swedish_ci NOT NULL,
    `description` text collate utf8_swedish_ci default NULL,
    PRIMARY KEY (`id`),
    `created` TIMESTAMP DEFAULT '0000-00-00 00:00:00',
    `last_updated` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;
CREATE TRIGGER `deed_trigger` BEFORE INSERT ON `deed` FOR EACH ROW SET NEW.created = CURRENT_TIMESTAMP;
