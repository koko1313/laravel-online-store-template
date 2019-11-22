CREATE DATABASE templatedb;
USE templatedb;

-- --------------------------------------------------------

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `products` (
  `id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL PRIMARY KEY,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `main_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` varchar(255) COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  FOREIGN KEY (`category_id`) REFERENCES categories(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------------------------------------

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text(500) COLLATE utf8mb4_unicode_ci,
  `role_id` int(10) UNSIGNED NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  FOREIGN KEY (`role_id`) REFERENCES roles(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cart` (
  `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quanity` int(10) NOT NULL,
  
  UNIQUE(`user_id`, `product_id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES products(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; 

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  FOREIGN KEY (`user_id`) REFERENCES users(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `order_products` (
  `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quanity` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  FOREIGN KEY (`order_id`) REFERENCES orders(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

CREATE TABLE `carousel` (
  `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

INSERT INTO `roles` (`id`, `role`) VALUES (1, 'admin'), (2, 'user');

INSERT INTO `users` (`email`, `first_name`, `last_name`, `phone`, `password`, `role_id`) VALUES ('admin@admin.com', 'Admin', 'Admin', '0000000000', 'password', 1);

-- --------------------------------------------------------

CREATE VIEW products_view AS
SELECT products.id, products.title, products.price, products.description, products.category_id, categories.category, products.main_image, products.images
FROM products
INNER JOIN categories
ON products.category_id = categories.id;

CREATE VIEW users_view AS
SELECT users.id, users.email, users.first_name, users.last_name, users.phone, users.password, users.address, roles.role
FROM users
INNER JOIN roles
ON users.role_id = roles.id;

CREATE VIEW `cart_view` AS
SELECT cart.user_id, GROUP_CONCAT(cart.product_id) AS 'product_id_list', GROUP_CONCAT(products.title) AS 'product_title_list', GROUP_CONCAT(products.price) AS 'product_price_list', GROUP_CONCAT(cart.quanity) AS 'product_quanity_list', GROUP_CONCAT(products.price*cart.quanity) AS 'product_total_price_list', SUM(products.price * cart.quanity) AS 'grand_total_price'
FROM cart
INNER JOIN products ON cart.product_id = products.id
GROUP BY cart.user_id;

CREATE VIEW orders_view AS
SELECT orders.id AS 'order_id', CONCAT(users.first_name, ' ', users.last_name) AS 'user_name', users.phone AS 'user_phone', users.email AS 'user_email', users.id AS 'user_id', GROUP_CONCAT(order_products.product_id) AS 'product_id_list', GROUP_CONCAT(order_products.product_title) AS 'product_title_list', GROUP_CONCAT(order_products.quanity) AS 'quanity_list', GROUP_CONCAT(order_products.price) AS 'price_list', GROUP_CONCAT(order_products.price*order_products.quanity) AS 'total_price_list',  SUM(order_products.quanity * order_products.price) AS 'grand_total_price', orders.status
FROM orders
INNER JOIN order_products ON orders.id = order_products.order_id
INNER JOIN users ON orders.user_id = users.id
GROUP BY order_products.order_id;