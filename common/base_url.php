<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';
die(dirname(__DIR__) . '/vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$baseUrl = getenv('BASE_URL');