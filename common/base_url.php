<?php
require_once dirname(__DIR__). '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

define('BASE_DIR', __DIR__ . '/..');
