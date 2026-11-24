<?php

use Jaipur\Game\Config\Config;
use Jaipur\Game\Core\Deck;

require __DIR__ . '/vendor/autoload.php';

$config = new Config();
$deck = new Deck($config);
