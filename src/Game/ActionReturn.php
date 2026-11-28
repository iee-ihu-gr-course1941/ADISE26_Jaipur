<?php

declare(strict_types=1);

namespace Jaipur\Game;

// Return types for the takeAction/saleAction functions. The non-success returns indicate a wrong input by the user
enum ActionReturn {
    case NoSelection;
    case MixedMarketTake;
    case ExchangeNotAllowed;
    case HandLimitExceeded;
    case SameGoodExchange;
    case ExchangeCountMismatch;
    case MultipleGoodsSale;
    case CamelSaleNotAllowed;
    case InvalidSaleQuantity;
    case SuccessRoundOver;
    case Success;
}
