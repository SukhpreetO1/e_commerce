CREATE TABLE user (
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL,
    is_admin INT(1) NOT NULL DEFAULT 1, -- 0 for admin and 1 for Users
    reset_link_token VARCHAR(255) NOT NULL,
    reset_token_exp DATE NULL,
    password VARCHAR(255) NOT NULL
);