<?php

declare(strict_types=1);

namespace Jaipur\Game\Config;

use Jaipur\Game\Zones\Bank;
use Jaipur\Game\Zones\Deck;

/**
 * Change deck size, @see Deck::loadNonRandomCardCopies() to better understand the values
 * @see Bank::$tokens also get scaled appropriately
 */
enum GameScale: int {
    case Standard = 55;
    case Reduced = 42;
    case Extended = 68;
}
