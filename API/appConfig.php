<?php

// System Info
define("APP_NAME", "DiscountFinder");
define("APP_DEV", "x-Team");

// Database Info
define("DB_HOST", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "discountfinderdb");
define("DB_PORT", "3306");
define("DB_CODE", "utf8");

// Include Core Files
require_once (__DIR__ . "/connection/IConnection.php");
require_once (__DIR__ . "/connection/MySQL.php");
require_once (__DIR__ . "/connection/PostgreSQL.php");
