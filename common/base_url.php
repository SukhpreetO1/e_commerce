<?php
require_once __DIR__ . '/../vendor/autoload.php';;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

define('BASE_DIR', __DIR__ . '/..');
