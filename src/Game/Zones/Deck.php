<?php

declare(strict_types=1);

namespace Jaipur\Game\Zones;

use Jaipur\Game\Config\GameScale;
use Jaipur\Game\Config\MarketSize;
use Jaipur\Game\Core\Card;

class Deck {
    public private(set) array $cards = [];

    public function __construct(bool $wildDeck, GameScale $gameScale, MarketSize $marketSize) {
        // Fetch the number of copies of each card in the deck
        $cardCopies = $wildDeck ? $this->generateRandomCardCopies($gameScale, $marketSize) : $this->loadNonRandomCardCopies($gameScale);

        // Generate the cards of the deck based on the card copy numbers
        foreach (Card::cases() as $i => $card) {
            array_push($this->cards, ...array_fill(0, $cardCopies[$i], $card));
        }

        shuffle($this->cards);
    }


    private function loadNonRandomCardCopies(GameScale $gameScale): array {
        return match ($gameScale) {
            GameScale::Standard => [
                Card::Leather->value => 10,
                Card::Spice->value => 8,
                Card::Cloth->value => 8,
                Card::Silver->value => 6,
                Card::Gold->value => 6,
                Card::Diamond->value => 6,
                Card::Camel->value => 11
            ],

            GameScale::Reduced => [
                Card::Leather->value => 7,
                Card::Spice->value => 6,
                Card::Cloth->value => 6,
                Card::Silver->value => 5,
                Card::Gold->value => 5,
                Card::Diamond->value => 5,
                Card::Camel->value => 8
            ],

            GameScale::Extended => [
                Card::Leather->value => 13,
                Card::Spice->value => 10,
                Card::Cloth->value => 10,
                Card::Silver->value => 7,
                Card::Gold->value => 7,
                Card::Diamond->value => 7,
                Card::Camel->value => 14,
            ]
        };
    }


    // Because the Jaipur setup requires x camel cards in the starting market, regenerate the random card copies if fewer
    // than x camel cards were created
    private function generateRandomCardCopies(GameScale $gameScale, MarketSize $marketSize): array {
        $allCards = Card::cases();

        do {
            $randomCardCopies = array_fill(0, count($allCards), 0);

            for ($i = 0; $i < $gameScale->value; $i += 1) {
                $randomCard = $allCards[array_rand($allCards)];
                $randomCardCopies[$randomCard->value] += 1;
            }
        } while ($randomCardCopies[Card::Camel->value] < $marketSize->initialCamels());

        return $randomCardCopies;
    }


    public function drawCard() : ?Card {
        return array_pop($this->cards);
    }


    public function drawSpecificCard(Card $targetCard): ?Card {
        $targetCardIndex = array_search($targetCard, $this->cards, true);

        if ($targetCardIndex === false) {
            return null;
        }

        return array_splice($this->cards, $targetCardIndex, 1)[0];
    }
}
