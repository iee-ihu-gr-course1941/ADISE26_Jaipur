<?php

namespace Jaipur\Game\Config;

enum DeckSize: int {
    case Standard = 0;
    case Reduced = 1;
    case Extended = 2;


    /**
     * @see Deck::loadNonRandomCardCopies() to better understand the count values
     */
    public function count(): int {
        return match ($this) {
            DeckSize::Standard => 55,
            DeckSize::Reduced => 42,
            DeckSize::Extended => 68
        };
    }
}
