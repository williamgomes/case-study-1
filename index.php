<?php
$loader = require_once __DIR__ . "/./vendor/autoload.php";

date_default_timezone_set( 'Europe/Berlin' );

use Symfony\Component\Console\Application;
use App\HotelDataValidatorCommand;

$console = new Application();
$console->add(new HotelDataValidatorCommand());
$console->run();