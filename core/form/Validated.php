<?php

abstract class Validated {
    static function valid($it): Valid
    {
        return new Valid($it);
    }

    static function invalid($messages): Invalid
    {
        return new Invalid($messages);
    }
}

class Valid extends Validated {
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}

class Invalid extends Validated {
    private array $messages;

    public function __construct($messages)
    {
        $this->messages = $messages;
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}