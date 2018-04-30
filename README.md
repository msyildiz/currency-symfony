# DÖVİZ KURLARI

Main Controller: CurrencyController



#TABLE SCHEMA

CREATE TABLE `datas` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `symbol` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
 `amount` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
 `rand_key` int(11) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
