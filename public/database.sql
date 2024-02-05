CREATE TABLE IF NOT EXISTS `users` (
    `id` int NOT NULL AUTO_INCREMENT,
    `first_name` varchar(30) NOT NULL,
    `last_name` varchar(30) NOT NULL,
    `username` varchar(30) NOT NULL,
    `email` varchar(30) NOT NULL,
    `is_admin` int NOT NULL DEFAULT '2' COMMENT '1 for admin and 2 for users',
    `reset_link_token` varchar(255) DEFAULT NULL,
    `reset_token_exp` datetime DEFAULT NULL,
    `password` varchar(255) NOT NULL,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`),
    UNIQUE KEY `email` (`email`)
) AUTO_INCREMENT=2;