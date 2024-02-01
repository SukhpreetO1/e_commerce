CREATE TABLE user (
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL,
    username VARCHAR(30) NOT NULL,
    email VARCHAR(30) NOT NULL,
    is_admin INT(1) NOT NULL DEFAULT 2, -- 1 for admin and 2 for Users
    reset_link_token VARCHAR(255) NULL,
    reset_token_exp DATE NULL,
    password VARCHAR(255) NOT NULL
);