<?php

// System Info
define("APP_NAME", "DiscountFinder");
define("APP_DEV", "x-Team");
// Database Info
define("DB_HOST", "localhost");
define("DB_USERNAME", "discountFinderUser");
define("DB_PASSWORD", "PASSWORD");
define("DB_DATABASE", "discountfinderdb");
define("DB_PORT", "3306");
define("DB_CODE", "UTF8");

// Include Core Files
require_once ("../connection/IConnection.php");
require_once ("../connection/MySQL.php");
require_once ("../connection/PostgreSQL.php");
