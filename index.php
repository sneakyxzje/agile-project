<?php 

session_start();

require_once __DIR__ . "/env.php"; 

require_once __DIR__ . "/src/helpers.php";

flash_next_request();

require __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . "/routes/route.php";
