<?php

declare(strict_types=1);

use Jaipur\Game\Core\Card;
use Jaipur\Game\Round;
use Jaipur\Game\Config\Config;

require __DIR__ . '/vendor/autoload.php';

$config = new Config();
$board = new Round($config);

var_export($board->player1);
echo "\n\n";

echo "Array 1: ";
$tempGivenArray1 = explode(' ', readline());
$givenArray1 = array_map(fn($n) => constant(Card::class . '::' . ucfirst(strtolower(trim($n)))), array_values(array_filter($tempGivenArray1 ?? [], fn($v) => trim((string) $v) !== '')));
echo "\n";

$saleActionReturn = $board->saleAction($givenArray1);
var_export($saleActionReturn);
echo "\n\n";

var_export($board->player1);
echo "\n\n";
