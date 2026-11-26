<?php

declare(strict_types=1);

namespace Jaipur\Game\Config;

enum HandLimit: int {
    case Standard = 7;
    case Reduced = 5;
    case Extended = 9;


    public function initialDealSize(): int {
        return match ($this) {
            self::Standard => 5,
            self::Reduced => 3,
            self::Extended => 7
        };
    }
}
