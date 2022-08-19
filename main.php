<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\App;
use App\Game\ConfigReader;
use Symfony\Component\Console\Application;
use App\Command\GameCommand;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Config\FileLocator;

$container = new ContainerBuilder();
$loader    = new YamlFileLoader($container, new FileLocator(__DIR__ . '/config'));

$loader->load('services.yml');
$container->compile();

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');

//throws exception when config is invalid
ConfigReader::validateConfig();

$app = $container->get(App::class);
$app->run();
