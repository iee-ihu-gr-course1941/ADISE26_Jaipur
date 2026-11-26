<?php

declare(strict_types=1);

namespace Jaipur\Game\Config;

use Jaipur\Game\Zones\Deck;

/**
 * @see Deck::loadNonRandomCardCopies() to better understand the values
 */
enum DeckSize: int {
    case Standard = 55;
    case Reduced = 42;
    case Extended = 68;
}
