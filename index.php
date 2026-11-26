<?php

declare(strict_types=1);

use Jaipur\Game\Config\Config;
use Jaipur\Game\Zones\Bank;
use Jaipur\Game\Zones\Deck;

require __DIR__ . '/vendor/autoload.php';

$config = new Config();
$deck = new Deck($config->wildDeck, $config->gameScale, $config->marketSize);
$bank = new Bank($config->tokenPricing, $config->gameScale);

var_export($bank->tokens);
