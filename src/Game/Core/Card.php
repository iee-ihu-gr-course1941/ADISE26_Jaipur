<?php

declare(strict_types=1);

namespace Jaipur\Game\Core;

use LogicException;

enum Card: int {
    case Leather = 0;
    case Spice = 1;
    case Cloth = 2;
    case Silver = 3;
    case Gold = 4;
    case Diamond = 5;
    case Camel = 6;


    public function isGood(): bool {
        return match ($this) {
            self::Leather, self::Spice, self::Cloth, self::Silver, self::Gold, self::Diamond => true,
            self::Camel => false
        };
    }


    // When selling the 3 most expensive cards (silver, diamond, gold), the sale must include a minimum of 2 cards
    public function minimumSaleQuantity(): int {
        return match ($this) {
            self::Silver, self::Gold, self::Diamond => 2,
            self::Leather, self::Spice, self::Cloth => 1,
            self::Camel => throw new LogicException('Camels cannot be sold!')
        };
    }
}
