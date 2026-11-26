<?php

declare(strict_types=1);

namespace Jaipur\Game\Config;

enum MarketSize: int {
    case Tiny = 3;
    case Reduced = 4;
    case Standard = 5;
    case Extended = 6;
    case Vast = 7;


    public function initialCamels(): int {
        return match ($this) {
            self::Tiny => 1,
            self::Reduced => 2,
            self::Standard, self::Extended => 3,
            self::Vast => 4
        };
    }
}
