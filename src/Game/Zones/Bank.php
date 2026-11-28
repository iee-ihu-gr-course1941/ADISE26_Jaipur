<?php

declare(strict_types=1);

namespace Jaipur\Game\Zones;

use Jaipur\Game\Config\GameScale;
use Jaipur\Game\Config\TokenPricing;
use Jaipur\Game\Core\Token;
use Jaipur\Game\Core\TokenType;

class Bank {
    // 2D array of all the tokens: rows = token types, columns = token values
    public private(set) array $tokens;

    public function __construct(TokenPricing $tokenPricing, GameScale $gameScale) {
        foreach (TokenType::cases() as $tokenType) {
            foreach ($this->loadTokenValues($tokenType, $tokenPricing, $gameScale) as $tokenValue) {
                $this->tokens[$tokenType->value][] = new Token($tokenType, $tokenValue);
            }
        }

        shuffle($this->tokens[TokenType::Bonus_3->value]);
        shuffle($this->tokens[TokenType::Bonus_4->value]);
        shuffle($this->tokens[TokenType::Bonus_5->value]);
    }


    // In a reduced/extended game scale, the tokens need to be scaled to keep them from either never running out or always
    // running out. There is always one fewer token than the number of cards, except in the wild deck variant. Because this
    // deck is randomly populated, the tokens are still scaled based on the game scale rather than the card count to avoid
    // revealing the deck's distribution. The reduced variant reduces the lowest-value goods tokens, the extended variant
    // extends the highest-value ones. For the bonus tokens, the goal is to keep the average bonus payout the same. The
    // camel token doesn't get scaled because an alternative texture doesn't exist
    private function loadGoodsTokenValues(TokenType $tokenType, GameScale $gameScale): array {
        return match ($gameScale) {
            GameScale::Reduced => match ($tokenType) {
                TokenType::Leather => [1, 1, 1, 2, 3, 4],
                TokenType::Spice, TokenType::Cloth => [2, 2, 3, 3, 5],
                TokenType::Silver => [5, 5, 5, 5],
                TokenType::Gold => [5, 5, 6, 6],
                TokenType::Diamond => [5, 5, 7, 7]
            },

            GameScale::Standard => match ($tokenType) {
                TokenType::Leather => [1, 1, 1, 1, 1, 1, 2, 3, 4],
                TokenType::Spice, TokenType::Cloth => [1, 1, 2, 2, 3, 3, 5],
                TokenType::Silver => [5, 5, 5, 5, 5],
                TokenType::Gold => [5, 5, 5, 6, 6],
                TokenType::Diamond => [5, 5, 5, 7, 7]
            },

            GameScale::Extended => match ($tokenType) {
                TokenType::Leather => [1, 1, 1, 1, 1, 1, 2, 3, 4, 4, 4, 4],
                TokenType::Spice, TokenType::Cloth => [1, 1, 2, 2, 3, 3, 5, 5, 5],
                TokenType::Silver => [5, 5, 5, 5, 5, 5],
                TokenType::Gold => [5, 5, 5, 6, 6, 6],
                TokenType::Diamond => [5, 5, 5, 7, 7, 7]
            },
        };
    }

    private function loadBonusTokenValues(TokenType $tokenType, GameScale $gameScale): array {
        return match ($gameScale) {
            GameScale::Reduced => match ($tokenType) {
                TokenType::Bonus_3 => [1, 2, 2, 2, 3],
                TokenType::Bonus_4 => [4, 5, 5, 6],
                TokenType::Bonus_5 => [8, 9, 10]
            },

            GameScale::Standard => match ($tokenType) {
                TokenType::Bonus_3 => [1, 1, 2, 2, 2, 3, 3],
                TokenType::Bonus_4 => [4, 4, 5, 5, 6, 6],
                TokenType::Bonus_5 => [8, 8, 9, 10, 10]
            },

            GameScale::Extended => match ($tokenType) {
                TokenType::Bonus_3 => [1, 1, 1, 2, 2, 2, 3, 3, 3],
                TokenType::Bonus_4 => [4, 4, 4, 5, 5, 6, 6, 6],
                TokenType::Bonus_5 => [8, 8, 9, 9, 9, 10, 10]
            },
        };
    }

    private function loadTokenValues(TokenType $tokenType, TokenPricing $tokenPricing, GameScale $gameScale): array {
        return match ($tokenType) {
            TokenType::Camel => [5],
            TokenType::Bonus_3, TokenType::Bonus_4, TokenType::Bonus_5 => $this->loadBonusTokenValues($tokenType, $gameScale),
            default => match ($tokenPricing) {
                TokenPricing::Standard => $this->loadGoodsTokenValues($tokenType, $gameScale),
                TokenPricing::Reverse => array_reverse($this->loadGoodsTokenValues($tokenType, $gameScale)),
                TokenPricing::Fixed => match ($gameScale) {
                    GameScale::Reduced => match ($tokenType) {
                        TokenType::Leather => [1, 1, 1, 1, 1, 1],
                        TokenType::Spice => [2, 2, 2, 2, 2],
                        TokenType::Cloth => [3, 3, 3, 3, 3],
                        TokenType::Silver => [5, 5, 5, 5],
                        TokenType::Gold => [6, 6, 6, 6],
                        TokenType::Diamond => [7, 7, 7, 7]
                    },

                    GameScale::Standard => match ($tokenType) {
                        TokenType::Leather => [1, 1, 1, 1, 1, 1, 1, 1, 1],
                        TokenType::Spice => [2, 2, 2, 2, 2, 2, 2],
                        TokenType::Cloth => [3, 3, 3, 3, 3, 3, 3],
                        TokenType::Silver => [5, 5, 5, 5, 5],
                        TokenType::Gold => [6, 6, 6, 6, 6],
                        TokenType::Diamond => [7, 7, 7, 7, 7]
                    },

                    GameScale::Extended => match ($tokenType) {
                        TokenType::Leather => [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                        TokenType::Spice => [2, 2, 2, 2, 2, 2, 2, 2, 2],
                        TokenType::Cloth => [3, 3, 3, 3, 3, 3, 3, 3, 3],
                        TokenType::Silver => [5, 5, 5, 5, 5, 5],
                        TokenType::Gold => [6, 6, 6, 6, 6, 6],
                        TokenType::Diamond => [7, 7, 7, 7, 7, 7]
                    },
                },
            },
        };
    }


    // Return null if this goods token is depleted
    public function takeToken(TokenType $tokenType): ?Token {
        return array_pop($this->tokens[$tokenType->value]);
    }


    public function countDepletedGoodsTokens(): int {
        $count = 0;
        foreach (TokenType::cases() as $tokenType) {
            if ($tokenType->isGood() && empty($this->tokens[$tokenType->value])) {
                $count += 1;
            }
        }

        return $count;
    }
}
