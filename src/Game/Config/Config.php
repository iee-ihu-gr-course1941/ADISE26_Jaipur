<?php

declare(strict_types=1);

namespace Jaipur\Game\Config;

final readonly class Config {
    public function __construct(
        public DeckSize $deckSize = DeckSize::Standard,
        public bool $wildDeck = false, // Randomly populated deck
        public TokenPricing $tokenPricing = TokenPricing::Standard
    ) {}
}
