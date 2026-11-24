<?php

declare(strict_types=1);

namespace Jaipur\Game\Core;

use Jaipur\Game\Config\Config;
use Jaipur\Game\Config\TokenPricing;

class Bank {
    // 2D array of all the tokens: rows = token types, columns = token values
    public private(set) array $tokens;

    public function __construct(Config $config) {
        foreach (TokenType::cases() as $tokenType) {
            foreach ($this->loadTokenValues($config, $tokenType) as $tokenValue) {
                $this->tokens[$tokenType->value][] = new Token($tokenType, $tokenValue);
            }
        }

        var_export($this->tokens);

        shuffle($this->tokens[TokenType::Bonus_3->value]);
        shuffle($this->tokens[TokenType::Bonus_4->value]);
        shuffle($this->tokens[TokenType::Bonus_5->value]);
    }


    private function loadStandardGoodsTokenValues(TokenType $tokenType): array {
        return match ($tokenType) {
            TokenType::Leather => [4, 3, 2, 1, 1, 1, 1, 1, 1],
            TokenType::Spice, TokenType::Cloth => [5, 3, 3, 2, 2, 1, 1],
            TokenType::Silver => [5, 5, 5, 5, 5],
            TokenType::Gold => [6, 6, 5, 5, 5],
            TokenType::Diamond => [7, 7, 5, 5, 5]
        };
    }

    private function loadTokenValues(Config $config, TokenType $tokenType): array {
        return match ($tokenType) {
            TokenType::Camel => [5],
            TokenType::Bonus_3 => [1, 1, 2, 2, 2, 3, 3],
            TokenType::Bonus_4 => [4, 4, 5, 5, 6, 6],
            TokenType::Bonus_5 => [8, 8, 9, 10, 10],
            default => match ($config->tokenPricing) {
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
}
