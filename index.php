<?php

declare(strict_types=1);

use Jaipur\Game\Config\Config;
use Jaipur\Game\Core\Bank;

require __DIR__ . '/vendor/autoload.php';

$config = new Config();
$bank = new Bank($config);
