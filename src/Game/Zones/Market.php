<?php

declare(strict_types=1);

namespace Jaipur\Game\Zones;

use Jaipur\Game\Config\MarketSize;
use Jaipur\Game\Core\Card;
use LogicException;

class Market {
    public private(set) array $cards = [];

    // Initializes the market with the required starting camels and the remaining starting cards
    public function __construct(MarketSize $marketSize, Deck $deck) {
        for ($i = 0; $i < $marketSize->value; $i += 1) {
            if ($i < $marketSize->initialCamels()) {
                $this->cards[] = $deck->drawSpecificCard(Card::Camel);
            }

            else {
                $this->cards[] = $deck->drawCard();
            }
        }
    }


    // Referencing by index because the market cards are fixed positional slots on the table
    public function takeCard(int $targetIndex): Card {
        $targetCard = $this->cards[$targetIndex];
        $this->cards[$targetIndex] = null;
        return $targetCard;
    }


    public function addCard(Card $card, int $targetIndex): void {
        if (isset($this->cards[$targetIndex])) {
            throw new LogicException("Cannot add $card->name. Slot $targetIndex is already occupied!");
        }

        $this->cards[$targetIndex] = $card;
    }
}
