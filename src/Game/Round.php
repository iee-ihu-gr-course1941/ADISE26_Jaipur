<?php

declare(strict_types=1);

namespace Jaipur\Game;

use Jaipur\Game\Config\Config;
use Jaipur\Game\Core\Card;
use Jaipur\Game\Zones\Bank;
use Jaipur\Game\Zones\Deck;
use Jaipur\Game\Zones\Market;
use Jaipur\Game\Zones\Player;

class Round {
    public private(set) Deck $deck;
    public private(set) Bank $bank;
    public private(set) Market $market;
    public private(set) Player $player1;
    public private(set) Player $player2;
    public private(set) bool $player1Turn = true;
    public private(set) bool $roundOver = false;
    private readonly int $handLimit;

    public function __construct(Config $config) {
        $this->deck = new Deck($config->wildDeck, $config->gameScale, $config->marketSize);
        $this->bank = new Bank($config->tokenPricing, $config->gameScale);
        $this->market = new Market($config->marketSize, $this->deck);
        $this->player1 = new Player($config->handLimit, $this->deck);
        $this->player2 = new Player($config->handLimit, $this->deck);
        $this->handLimit = $config->handLimit->value;
    }


    private function takeCardFromMarket(int $targetCardIndex, Player $player): void {
        $cardTaken = $this->market->takeCard($targetCardIndex);
        $player->addCard($cardTaken);
    }


    private function refillMarket(array $indices): void {
        foreach ($indices as $index) {
            $drawnCard = $this->deck->drawCard();

            if ($drawnCard === null) {
                $this->roundOver = true;
                return;
            }

            $this->market->addCard($drawnCard, $index);
        }
    }


    // $targetCardIndices = the indices of the market cards that the user selected to take, $exchangeCards = the cards in
    // the player's hand/herd that they selected to exchange
    public function takeAction(array $targetCardIndices, array $exchangeCards): TakeActionReturn {
        if (empty($targetCardIndices)) {
            return TakeActionReturn::NoSelection;
        }

        $targetCards = [];
        foreach ($targetCardIndices as $targetCardIndex) {
            $targetCards[] = $this->market->cards[$targetCardIndex];
        }

        // Check if the target cards include only goods or camels
        $onlyGoods = true;
        $onlyCamels = true;
        foreach ($targetCards as $targetCard) {
            if ($targetCard->isGood()) {
                $onlyCamels = false;
            }

            else {
                $onlyGoods = false;
            }
        }

        if (!$onlyGoods && !$onlyCamels) {
            return TakeActionReturn::MixedGoodsAndCamels;
        }

        $player = ($this->player1Turn) ? $this->player1 : $this->player2;
        $remainingHandCapacity = $this->handLimit - count($player->hand);

        // Take all the camel cards (the array targetCardIndices is expected to hold the indices of all the camel cards
        // in the market)
        if ($onlyCamels) {
            if (count($exchangeCards) !== 0) {
                return TakeActionReturn::ExchangeNotAllowed;
            }

            $camelIndices = array_keys($this->market->cards, Card::Camel, true);
            foreach ($camelIndices as $camelIndex) {
                $this->takeCardFromMarket($camelIndex, $player);
            }

            $this->refillMarket($camelIndices);
        }

        // Take a single good
        else if (count($targetCardIndices) === 1) {
            if (count($exchangeCards) !== 0) {
                return TakeActionReturn::ExchangeNotAllowed;
            }

            if ($remainingHandCapacity === 0) {
                return TakeActionReturn::HandLimitExceeded;
            }

            $this->takeCardFromMarket($targetCardIndices[0], $player);
            $this->refillMarket($targetCardIndices);
        }

        // Exchange several cards between the market and the player
        else if (count($targetCardIndices) === count($exchangeCards)) {
            // In an exchange only exchanging camel cards increases the hand size
            $camelCardsExchanged = count(array_keys($exchangeCards, Card::Camel, true));
            if ($camelCardsExchanged > $remainingHandCapacity) {
                return TakeActionReturn::HandLimitExceeded;
            }

            if (array_any($targetCards, fn ($targetCard) => in_array($targetCard, $exchangeCards, true))) {
                return TakeActionReturn::SameGoodExchange;
            }

            foreach ($targetCardIndices as $i => $targetCardIndex) {
                $cardTaken = $this->market->takeCard($targetCardIndex);
                $player->addCard($cardTaken);

                $cardExchanged = $player->takeCard($exchangeCards[$i]);
                $this->market->addCard($cardExchanged, $targetCardIndex);
            }
        }

        else {
            return TakeActionReturn::ExchangeCountMismatch;
        }

        if ($this->roundOver) {
            $this->triggerRoundOverSequence();
            return TakeActionReturn::SuccessRoundOver;
        }

        $this->player1Turn = !$this->player1Turn;
        return TakeActionReturn::Success;
    }


    private function triggerRoundOverSequence() : void {
        echo 'Round Over!';
    }
}
