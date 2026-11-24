<?php

declare(strict_types=1);

namespace Jaipur\Game\Core;

use Jaipur\Game\Config\Config;
use Jaipur\Game\Config\DeckSize;

class Deck {
    public private(set) array $cards;

    public function __construct(Config $config) {
        // Fetches the number of copies of each card in the deck
        $cardCopies = $config->wildDeck ? $this->generateRandomCardCopies($config->deckSize) : $this->loadNonRandomCardCopies($config->deckSize);

        // Generates the cards of the deck based on the card copy numbers
        $allCards = Card::cases();
        for ($i = 0; $i < count($allCards); $i += 1) {
            for ($j = 0; $j < $cardCopies[$i]; $j += 1) {
                $this->cards[] = $allCards[$i];
            }
        }

        shuffle($this->cards);
    }


    private function loadNonRandomCardCopies(DeckSize $deckSize): array {
        return match ($deckSize) {
            DeckSize::Standard => [
                Card::Leather->value => 10,
                Card::Spice->value => 8,
                Card::Cloth->value => 8,
                Card::Silver->value => 6,
                Card::Gold->value => 6,
                Card::Diamond->value => 6,
                Card::Camel->value => 11
            ],

            DeckSize::Reduced => [
                Card::Leather->value => 7,
                Card::Spice->value => 6,
                Card::Cloth->value => 6,
                Card::Silver->value => 5,
                Card::Gold->value => 5,
                Card::Diamond->value => 5,
                Card::Camel->value => 8
            ],

            DeckSize::Extended => [
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


    // Because Jaipur setup requires 3 camels in the starting market, regenerate the random card copies if fewer than 3
    // camel cards were created
    private function generateRandomCardCopies(DeckSize $deckSize): array {
        $allCards = Card::cases();

        do {
            $randomCardCopies = array_fill(0, count($allCards), 0);

            for ($i = 0; $i < $deckSize->count(); $i += 1) {
                $randomCard = $allCards[array_rand($allCards)];
                $randomCardCopies[$randomCard->value] += 1;
            }
        } while ($randomCardCopies[Card::Camel->value] < 3);

        return $randomCardCopies;
    }


    public function drawCard() : Card {
        return array_pop($this->cards);
    }
}
