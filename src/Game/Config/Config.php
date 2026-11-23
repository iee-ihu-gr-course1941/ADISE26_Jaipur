<?php

namespace Jaipur\Game\Config;

final readonly class Config {
    public function __construct(
        public DeckSize $deckSize = DeckSize::Standard,
        public bool $wildDeck = false // Randomly populated deck
    ) {}
}
