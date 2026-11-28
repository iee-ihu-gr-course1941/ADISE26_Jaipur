<?php

declare(strict_types=1);

namespace Jaipur\Game;

enum TakeActionReturn {
    case NoSelection;
    case MixedGoodsAndCamels;
    case ExchangeNotAllowed;
    case HandLimitExceeded;
    case SameGoodExchange;
    case ExchangeCountMismatch;
    case SuccessRoundOver;
    case Success;
}
