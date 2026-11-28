<?php

declare(strict_types=1);

namespace Jaipur\Game\Zones;

use Jaipur\Game\Config\HandLimit;
use Jaipur\Game\Core\Card;
use Jaipur\Game\Core\Token;
use LogicException;

class Player {
    public private(set) array $hand = []; // Non camel cards
    public private(set) array $herd = []; // Camel cards
    public private(set) array $tokens;
    private readonly int $handLimit;

    public function __construct(HandLimit $handLimit, Deck $deck) {
        $this->handLimit = $handLimit->value;

        for ($i = 0; $i < $handLimit->initialDealSize(); $i += 1) {
            $card = $deck->drawCard();
            $this->addCard($card);
        }
    }


    // Referencing by card because a player's hand is an unordered collection where only the card type matters
    public function takeCard(Card $targetCard): Card {
        if ($targetCard === Card::Camel) {
            return array_pop($this->herd);
        }

        else {
            $targetCardIndex = array_search($targetCard, $this->hand, true);
            return array_splice($this->hand, $targetCardIndex, 1)[0];
        }
    }


    public function addCard(Card $card): void {
        if ($card === Card::Camel) {
            $this->herd[] = $card;
        }

        else if (count($this->hand) === $this->handLimit) {
            throw new LogicException("Cannot add $card->name. Hand is already full!");
        }

        else {
            $this->hand[] = $card;
        }
    }


    public function addToken(Token $token): void {
        $this->tokens[] = $token;
    }


    public function score(): int {
        return array_sum(array_column($this->tokens, 'value'));
    }
}
