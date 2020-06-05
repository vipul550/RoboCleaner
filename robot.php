#!/usr/bin/env php
<?php
require_once __DIR__ . '/vendor/autoload.php';
use Symfony\Component\Console\Application;
use App\Http\Controllers\CommandTool;


$app = new Application('Robo Cleaner','1.0.0.');
$app->add(new CommandTool());
$app->run();

?>
