<?php

declare(strict_types=1);

namespace Jaipur\Game\Core;

enum TokenType: int {
    case Leather = Card::Leather->value;
    case Spice = Card::Spice->value;
    case Cloth = Card::Cloth->value;
    case Silver = Card::Silver->value;
    case Gold = Card::Gold->value;
    case Diamond = Card::Diamond->value;
    case Camel = Card::Camel->value;
    case Bonus_3 = 7;
    case Bonus_4 = 8;
    case Bonus_5 = 9;


    public function isGood(): bool {
        return match ($this) {
            self::Leather, self::Spice, self::Cloth, self::Silver, self::Gold, self::Diamond => true,
            self::Camel, self::Bonus_3, self::Bonus_4, self::Bonus_5 => false
        };
    }


    public static function bonusForSaleCount(int $cardCount): ?self {
        return match (true) {
            $cardCount === 3 => self::Bonus_3,
            $cardCount === 4 => self::Bonus_4,
            $cardCount >= 5 => self::Bonus_5,
            default => null,
        };
    }
}
