<?php

declare(strict_types=1);

namespace Jaipur\Game\Core;

// A class is needed because unline cards which are identical, tokens can hold different values
class Token {
    public private(set) TokenType $type;
    public private(set) int $value;

    public function __construct(TokenType $type, int $value) {
        $this->type = $type;
        $this->value = $value;
    }
}
