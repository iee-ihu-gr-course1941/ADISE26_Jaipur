<?php

declare(strict_types=1);

use Jaipur\Game\Config\Config;
use Jaipur\Game\Zones\Deck;
use Jaipur\Game\Zones\Player;

require __DIR__ . '/vendor/autoload.php';

$config = new Config();
$deck = new Deck($config->wildDeck, $config->deckSize, $config->marketSize);
$player = new Player($config->handLimit, $deck);
