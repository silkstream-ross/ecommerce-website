
CREATE TABLE `categories` (
    `category_id` bigint(20) UNSIGNED NOT NULL,
    `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
    `description` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `categories` (`category_id`, `name`, `description`) VALUES
    (1, 'Playstation 4 ', 'Games for the Playstation 4/Playstation 4 Pro.'),
    (2, 'Xbox One', 'Games for the Xbox One/Xbox One S/Xbox One X');

CREATE TABLE `customers` (
    `customer_id` bigint(20) UNSIGNED NOT NULL,
    `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
    `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
    `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
    `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `orderitems` (
    `items_id` bigint(20) UNSIGNED NOT NULL,
    `order_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
    `product_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
    `quantity` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `total` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `orders` (
    `order_id` bigint(20) UNSIGNED NOT NULL,
    `customer_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
    `order_date` date NOT NULL,
    `cost` decimal(10,2) NOT NULL DEFAULT '0.00',
    `status` enum('On Hold','In Progress','Delivered','') COLLATE utf8_unicode_ci NOT NULL,
    `comments` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `products` (
    `product_id` bigint(20) UNSIGNED NOT NULL,
    `category_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
    `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
    `description` text COLLATE utf8_unicode_ci NOT NULL,
    `sku` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
    `price` decimal(10,2) NOT NULL DEFAULT '0.00',
    `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `products` (`product_id`, `category_id`, `name`, `description`, `sku`, `price`, `img`) VALUES
    (1, 1, 'God Of War (2018)', '4th God of War game', '11FDFS445GFDG7', '39.99', 'God_of_War_4_box.jpg'),
    (2, 2, 'Halo 3', 'Third installment in the bungie trilogy.', 'QWE1EWWFSDF44', '15.00', 'Halo_3_box.png');

CREATE TABLE `users` (
    `users_id` bigint(20) UNSIGNED NOT NULL,
    `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
    `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
    `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
    `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
    `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`users_id`, `username`, `email`, `first_name`, `last_name`, `password`) VALUES
    (1, 'RossW', 'ross@silkstream.net', 'Ross', 'Wallings', '1234');


ALTER TABLE `categories`
    ADD PRIMARY KEY (`category_id`);

ALTER TABLE `customers`
    ADD PRIMARY KEY (`customer_id`);

ALTER TABLE `orderitems`
    ADD PRIMARY KEY (`items_id`),
    ADD KEY `order_id` (`order_id`),
    ADD KEY `product_id` (`product_id`);

ALTER TABLE `orders`
    ADD PRIMARY KEY (`order_id`),
    ADD KEY `customer_id` (`customer_id`);

ALTER TABLE `products`
    ADD PRIMARY KEY (`product_id`),
    ADD KEY `category_id` (`category_id`);

ALTER TABLE `users`
    ADD PRIMARY KEY (`users_id`);


ALTER TABLE `categories`
    MODIFY `category_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `customers`
    MODIFY `customer_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `orderitems`
    MODIFY `items_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `orders`
    MODIFY `order_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `products`
    MODIFY `product_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `users`
    MODIFY `users_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `orderitems`
    ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
    ADD CONSTRAINT `orderitems_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

ALTER TABLE `orders`
    ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE;

ALTER TABLE `products`
    ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;

