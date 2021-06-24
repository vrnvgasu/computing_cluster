<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

$envPath = __DIR__ . '/../../.env';
if (file_exists($envPath)) {
    (new Dotenv())->load($envPath);
}
print_r(1);
