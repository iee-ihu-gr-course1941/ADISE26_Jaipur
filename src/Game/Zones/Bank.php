<?php

declare(strict_types=1);

namespace Jaipur\Game\Zones;

use Jaipur\Game\Config\TokenPricing;
use Jaipur\Game\Core\Token;
use Jaipur\Game\Core\TokenType;

class Bank {
    // 2D array of all the tokens: rows = token types, columns = token values
    public private(set) array $tokens;

    public function __construct(TokenPricing $tokenPricing) {
        foreach (TokenType::cases() as $tokenType) {
            foreach ($this->loadTokenValues($tokenType, $tokenPricing) as $tokenValue) {
                $this->tokens[$tokenType->value][] = new Token($tokenType, $tokenValue);
            }
        }

        shuffle($this->tokens[TokenType::Bonus_3->value]);
        shuffle($this->tokens[TokenType::Bonus_4->value]);
        shuffle($this->tokens[TokenType::Bonus_5->value]);
    }


    private function loadStandardGoodsTokenValues(TokenType $tokenType): array {
        return match ($tokenType) {
            TokenType::Leather => [1, 1, 1, 1, 1, 1, 2, 3, 4],
            TokenType::Spice, TokenType::Cloth => [1, 1, 2, 2, 3, 3, 5],
            TokenType::Silver => [5, 5, 5, 5, 5],
            TokenType::Gold => [5, 5, 5, 6, 6],
            TokenType::Diamond => [5, 5, 5, 7, 7]
        };
    }

    private function loadTokenValues(TokenType $tokenType, TokenPricing $tokenPricing): array {
        return match ($tokenType) {
            TokenType::Camel => [5],
            TokenType::Bonus_3 => [1, 1, 2, 2, 2, 3, 3],
            TokenType::Bonus_4 => [4, 4, 5, 5, 6, 6],
            TokenType::Bonus_5 => [8, 8, 9, 10, 10],
            default => match ($tokenPricing) {
                TokenPricing::Standard => $this->loadStandardGoodsTokenValues($tokenType),
                TokenPricing::Reverse => array_reverse($this->loadStandardGoodsTokenValues($tokenType)),
                TokenPricing::Fixed => match ($tokenType) {
                    TokenType::Leather => [1, 1, 1, 1, 1, 1, 1, 1, 1],
                    TokenType::Spice => [2, 2, 2, 2, 2, 2, 2],
                    TokenType::Cloth => [3, 3, 3, 3, 3, 3, 3],
                    TokenType::Silver => [5, 5, 5, 5, 5],
                    TokenType::Gold => [6, 6, 6, 6, 6],
                    TokenType::Diamond => [7, 7, 7, 7, 7]
                },
            },
        };
    }


    public function takeToken(TokenType $type): ?Token {
        return array_pop($this->tokens[$type->value]);
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
