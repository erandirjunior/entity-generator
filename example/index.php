<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

$application = new \Symfony\Component\Console\Application();

$application->add(new \EntityGenerator\EntityGenerator());

$application->run();