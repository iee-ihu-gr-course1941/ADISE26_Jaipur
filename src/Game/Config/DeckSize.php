<?php

declare(strict_types=1);

namespace Jaipur\Game\Config;

use Jaipur\Game\Core\Deck;

enum DeckSize: int {
    case Standard = 0;
    case Reduced = 1;
    case Extended = 2;


    /**
     * @see Deck::loadNonRandomCardCopies() to better understand the count values
     */
    public function count(): int {
        return match ($this) {
            self::Standard => 55,
            self::Reduced => 42,
            self::Extended => 68
        };
    }
}
