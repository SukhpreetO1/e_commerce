<?php
require_once dirname(__DIR__). '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

define('BASE_DIR', __DIR__ . '/..');
