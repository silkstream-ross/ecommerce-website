CREATE TABLE `categories`
(
    `category_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(255) NOT NULL DEFAULT '',
    `description` TEXT         NOT NULL DEFAULT '',
    PRIMARY KEY (`category_id`)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_unicode_ci;