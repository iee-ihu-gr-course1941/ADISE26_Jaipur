<?php

declare(strict_types=1);

use Jaipur\Game\Core\Card;
use Jaipur\Game\Round;
use Jaipur\Game\Config\Config;

require __DIR__ . '/vendor/autoload.php';

$config = new Config();
$board = new Round($config);

var_export(count($board->deck->cards));
echo "\n\n";
var_export($board->market);
echo "\n\n";
var_export($board->player1);
echo "\n\n";

echo "Array 1: ";
$givenArray1 = array_map('intval', preg_split('/\s+/', trim((string) readline()), -1, PREG_SPLIT_NO_EMPTY));
echo "Array 2: ";
$tempGivenArray2 = explode(' ', readline());
$givenArray2 = array_map(fn($n) => constant(Card::class . '::' . ucfirst(strtolower(trim($n)))), array_values(array_filter($tempGivenArray2 ?? [], fn($v) => trim((string) $v) !== '')));
echo "\n";

$takeActionReturn = $board->takeAction($givenArray1, $givenArray2);
var_export($takeActionReturn);
echo "\n\n";

var_export($board->market);
echo "\n\n";
var_export($board->player1);
echo "\n\n";
var_export(count($board->deck->cards));
