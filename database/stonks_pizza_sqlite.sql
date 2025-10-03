
CREATE TABLE `bestelregels` (
  `id` INTEGER NOT NULL,
  `order_id` INTEGER NOT NULL,
  `pizza_id` INTEGER NOT NULL,
  `aantal` INTEGER NOT NULL,
  `prijs` REAL NOT NULL,
  `totaal_prijs` REAL GENERATED ALWAYS AS (`aantal` * `prijs`) VIRTUAL,
  `afmeting` varchar(255) NOT NULL DEFAULT 'normaal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;
INSERT INTO `bestelregels` (`id`, `order_id`, `pizza_id`, `aantal`, `prijs`, `afmeting`, `created_at`, `updated_at`) VALUES
(2, 2, 1, 1, 1.88, 'normaal', '2025-10-03 07:15:49', '2025-10-03 07:15:49');
CREATE TABLE `bestelregel_ingredient` (
  `id` INTEGER NOT NULL,
  `bestelregel_id` INTEGER NOT NULL,
  `ingredient_id` INTEGER NOT NULL
) ;
INSERT INTO `bestelregel_ingredient` (`id`, `bestelregel_id`, `ingredient_id`) VALUES
(4, 2, 1),
(5, 2, 2),
(6, 2, 14);
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` TEXT NOT NULL,
  `expiration` INTEGER NOT NULL
) ;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` INTEGER NOT NULL
) ;
CREATE TABLE `customers` (
  `id` INTEGER NOT NULL,
  `naam` varchar(255) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `woonplaats` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefoon` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;
INSERT INTO `customers` (`id`, `naam`, `adres`, `woonplaats`, `email`, `telefoon`, `created_at`, `updated_at`) VALUES
(1, 'Jan Jansen', 'Straatweg 123', 'Utrecht', 'jan@example.com', '0612345678', '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(2, 'henk', 'eyJpdiI6InhPOHRjSHcwK3FJRWNhUTh1ZmI2N1E9PSIsInZhbHVlIjoiTXgyVVNmUGY1ejBJL3dmdGMzbjFsUT09IiwibWFjIjoiMTZmYTdmMDk3MGUyNGM1OWY3MzRkYWYzZTY5NGI5NDk5OWFkMDgxMGQ3ZDBhNjIxNmQwNGE2YjE4ZjIwYzYzOCIsInRhZyI6IiJ9', 'mbhsxhberjh', 'eyJpdiI6Ik5XRXJEV3l5cTJaNG93VHhpNkdGZ2c9PSIsInZhbHVlIjoiRUtLQmh1Z1A0bGZrQ0dibk9IbHRhb3Jhaktva0x6Y0ZOQjA1TXk4RU5BTT0iLCJtYWMiOiJkMzdmZWRjYmQzNjNkZWUwMGIwNWIyMzM1YTE1NTBjNGU4NzgzYTQxZWFiMDgxYmFlMzBiNDJmNWZjNjBlNDcxIiwidGFnIjoiIn0=', 'eyJpdiI6IjdEcGV1L09OeDZHZ3h1Z2IyQUE4YlE9PSIsInZhbHVlIjoic08zMHcrVG54dDdNNnhuWGM0UHNWa0NIeGtVU1MwWFZ5d05aOXhNa2cxUT0iLCJtYWMiOiI5NmMxM2E0OGI0ZGU1NGQxZDY3MzQ5MzEyMmJkYTA2MDZhOTUyNDQxYWJjMGUwNzhjNWI0ZWZjNDAzMGJmY2UzIiwidGFnIjoiIn0=', '2025-10-03 06:58:48', '2025-10-03 06:58:48'),
(3, 'henk', 'eyJpdiI6IjFlT0pZajU4UFZWSEU0YklHaUpmc0E9PSIsInZhbHVlIjoiR1ZlZzdGWlkyckhndWZ4UDhWQkRDQT09IiwibWFjIjoiMDJiMTFlMGRmOGI3ODlkMTU1MTE2MGIzZTNkYjIwN2RkMmU4NDcyNTliYTgxNDk4NDQxOTM1MzgxODkwMDQ3MCIsInRhZyI6IiJ9', 'mbhsxhberjh', 'eyJpdiI6Ii9JTUlSVGt5TkxUMm5LN0VKZTNScXc9PSIsInZhbHVlIjoiZjFXZlVERzNveGdTUmlid29COWVmV3FRZnBBMElITHdrbEFPaG54TEhDQT0iLCJtYWMiOiJlNmVlZGU3MWEzNWMxOGVjYjY0OGY1ZDg3MTdmOTFmMGRlNTNhNGM5OTc2MWNjYTRlZDNhNWQ2MzRmNDhlZjM5IiwidGFnIjoiIn0=', 'eyJpdiI6IndQSnYzTzZCd0EvNi9ZVStaRDZZNmc9PSIsInZhbHVlIjoiZUY2V3NaNkt1OURzRXcyNXVvanFaUFhsamdHMWVocDB3TVhaeEY0SGkrTT0iLCJtYWMiOiIzMjRkYTg2M2ZiN2U2MzhhZDc4OGJiOTFiYzU1ZmEwNjE3YmI5ZjE5OTlkNWI5ZmRiMjJjYWJjMWY4ODFlMTc4IiwidGFnIjoiIn0=', '2025-10-03 07:15:49', '2025-10-03 07:15:49');
CREATE TABLE `failed_jobs` (
  `id` INTEGER NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` TEXT NOT NULL,
  `queue` TEXT NOT NULL,
  `payload` TEXT NOT NULL,
  `exception` TEXT NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ;
CREATE TABLE `ingredients` (
  `id` INTEGER NOT NULL,
  `naam` varchar(255) NOT NULL,
  `prijs` REAL NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;
INSERT INTO `ingredients` (`id`, `naam`, `prijs`, `created_at`, `updated_at`) VALUES
(1, 'Kaas', 1.00, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(2, 'Tomatensaus', 0.50, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(3, 'Salami', 1.50, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(4, 'Champignons', 1.20, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(5, 'Paprika', 1.00, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(6, 'Olijven', 1.30, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(7, 'Ananas', 1.00, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(8, 'Ham', 1.50, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(9, 'Tonijn', 2.00, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(10, 'Garnalen', 2.50, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(11, 'Kip', 1.80, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(12, 'Spinazie', 1.20, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(13, 'Parmezaanse kaas', 2.00, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(14, 'Basilicum', 0.80, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(15, 'Aubergine', 1.00, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(16, 'Courgette', 1.00, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(17, 'Knoflook', 0.50, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(18, 'Pepperoni', 1.50, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(19, 'Bacon', 1.80, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(20, 'Gorgonzola', 2.00, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(21, 'Ricotta', 1.80, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(22, 'Truffelolie', 2.50, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(23, 'Koriander', 0.80, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(24, 'Mosterd', 0.50, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(25, 'Sesamzaadjes', 0.50, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(26, 'Augurken', 1.00, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(27, 'Ketchup', 0.50, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(28, 'Mayonaise', 0.50, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(29, 'Barbecuesaus', 0.50, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(30, 'Guacamole', 1.50, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(31, 'Chili saus', 0.80, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(32, 'Teriyaki saus', 1.00, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(33, 'Sojasaus', 0.50, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(34, 'rode ui', 0.80, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(35, 'BBQ saus', 1.50, '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(36, 'mais', 1.00, '2025-10-03 06:54:58', '2025-10-03 06:54:58');
CREATE TABLE `ingredient_pizza` (
  `id` INTEGER NOT NULL,
  `pizza_id` INTEGER NOT NULL,
  `ingredient_id` INTEGER NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hoeveelheid` TEXT NOT NULL
) ;
INSERT INTO `ingredient_pizza` (`id`, `pizza_id`, `ingredient_id`, `created_at`, `updated_at`, `hoeveelheid`) VALUES
(1, 1, 1, NULL, NULL, 'Klein'),
(2, 1, 2, NULL, NULL, 'Klein'),
(3, 1, 14, NULL, NULL, 'Klein'),
(4, 2, 1, NULL, NULL, 'Klein'),
(5, 2, 2, NULL, NULL, 'Klein'),
(6, 2, 3, NULL, NULL, 'Klein'),
(7, 3, 1, NULL, NULL, 'Klein'),
(8, 3, 2, NULL, NULL, 'Klein'),
(9, 3, 8, NULL, NULL, 'Klein'),
(10, 3, 7, NULL, NULL, 'Klein'),
(11, 4, 1, NULL, NULL, 'Klein'),
(12, 4, 2, NULL, NULL, 'Klein'),
(13, 4, 5, NULL, NULL, 'Klein'),
(14, 4, 4, NULL, NULL, 'Klein'),
(15, 4, 6, NULL, NULL, 'Klein'),
(16, 5, 1, NULL, NULL, 'Klein'),
(17, 5, 2, NULL, NULL, 'Klein'),
(18, 5, 18, NULL, NULL, 'Klein'),
(19, 6, 1, NULL, NULL, 'Klein'),
(20, 6, 35, NULL, NULL, 'Klein'),
(21, 6, 11, NULL, NULL, 'Klein'),
(22, 6, 34, NULL, NULL, 'Klein');
CREATE TABLE `jobs` (
  `id` INTEGER NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` TEXT NOT NULL,
  `attempts` INTEGER NOT NULL,
  `reserved_at` INTEGER DEFAULT NULL,
  `available_at` INTEGER NOT NULL,
  `created_at` INTEGER NOT NULL
) ;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` INTEGER NOT NULL,
  `pending_jobs` INTEGER NOT NULL,
  `failed_jobs` INTEGER NOT NULL,
  `failed_job_ids` TEXT NOT NULL,
  `options` TEXT DEFAULT NULL,
  `cancelled_at` INTEGER DEFAULT NULL,
  `created_at` INTEGER NOT NULL,
  `finished_at` INTEGER DEFAULT NULL
) ;
CREATE TABLE `migrations` (
  `id` INTEGER NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` INTEGER NOT NULL
) ;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_14_105443_create_customers_table', 1),
(5, '2025_04_14_105444_create_bestellings_table', 1),
(6, '2025_04_14_105547_create_pizzas_table', 1),
(7, '2025_04_14_105624_create_ingredients_table', 1),
(8, '2025_04_14_105708_create_ingredient_pizza_table', 1),
(9, '2025_04_14_105710_create_bestelregels_table', 1),
(10, '2025_06_11_124725_add_afmeting_to_bestelregels_table', 1);
CREATE TABLE `orders` (
  `id` INTEGER NOT NULL,
  `customer_id` INTEGER NOT NULL,
  `datum` datetime NOT NULL,
  `status` TEXT NOT NULL DEFAULT 'Initieel',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;
INSERT INTO `orders` (`id`, `customer_id`, `datum`, `status`, `created_at`, `updated_at`) VALUES
(2, 3, '2025-10-03 09:15:49', 'Bereiden', '2025-10-03 07:15:49', '2025-10-03 07:17:54');
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ;
CREATE TABLE `pizzas` (
  `id` INTEGER NOT NULL,
  `naam` varchar(255) NOT NULL,
  `prijs` REAL NOT NULL DEFAULT 0.00,
  `afmeting` TEXT NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;
INSERT INTO `pizzas` (`id`, `naam`, `prijs`, `afmeting`, `created_at`, `updated_at`) VALUES
(1, 'Margherita', 1.50, 'Klein', '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(2, 'Salami', 1.80, 'Klein', '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(3, 'Hawaii', 2.00, 'Klein', '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(4, 'Vegetarisch', 1.70, 'Klein', '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(5, 'Pepperoni', 1.90, 'Klein', '2025-10-03 06:54:58', '2025-10-03 06:54:58'),
(6, 'BBQ Chicken', 2.20, 'Klein', '2025-10-03 06:54:58', '2025-10-03 06:54:58');
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` INTEGER DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` TEXT DEFAULT NULL,
  `payload` TEXT NOT NULL,
  `last_activity` INTEGER NOT NULL
) ;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('eQjIUkWALJUoNLrKT26nDM4JYx6wBc0JA6Lmpq9h', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMDljbE9MQ0RkdkpmNDlqUDVaT3NoQklkaXFtTjM5R1IyWGJjWXBoZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9vcmRlci8xIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1759483334);
CREATE TABLE `users` (
  `id` INTEGER NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;
