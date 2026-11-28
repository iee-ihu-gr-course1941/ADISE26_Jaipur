<?php

declare(strict_types=1);

namespace Jaipur\Game\Config;

final readonly class Config {
    public function __construct(
        public bool $wildDeck = false, // Randomly populated deck
        public GameScale $gameScale = GameScale::Standard,
        public TokenPricing $tokenPricing = TokenPricing::Standard,
        public MarketSize $marketSize = MarketSize::Standard,
        public HandLimit $handLimit = HandLimit::Standard
    ) {}
}
