<?php

declare(strict_types=1);

namespace Jaipur\Game\Config;

enum TokenPricing: int {
    case Standard = 0;
    case Reverse = 1;
    case Fixed = 2;
}
