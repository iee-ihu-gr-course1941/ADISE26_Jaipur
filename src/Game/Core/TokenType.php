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
}
