<?php

declare(strict_types=1);

namespace Jaipur\Game\Config;

final readonly class Config {
    public function __construct(
        public GameScale $gameScale = GameScale::Standard,
        public HandLimit $handLimit = HandLimit::Standard,
        public MarketSize $marketSize = MarketSize::Standard,
        public TokenPricing $tokenPricing = TokenPricing::Standard,
        public bool $wildDeck = false // Randomly populated deck
    ) {}
}
