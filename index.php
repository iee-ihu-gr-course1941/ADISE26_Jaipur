<?php

use Jaipur\Game\Board;
use Jaipur\Game\Config\Config;

require __DIR__ . '/vendor/autoload.php';

$config = new Config();
new Board($config);
