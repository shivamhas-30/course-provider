<?php
// config.php
require_once 'vendor/autoload.php';

// Load the .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Get the Telegram Bot Token
$telegramBotToken = $_ENV['TELEGRAM_BOT_TOKEN'];
?>
