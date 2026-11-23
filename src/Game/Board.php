<?php

namespace Jaipur\Game;

use Jaipur\Game\Config\Config;

class Board {
    public private(set) Deck $deck;

    public function __construct(Config $config) {
        $this->deck = new Deck($config);

        var_export($this->deck->cards);
    }
}
