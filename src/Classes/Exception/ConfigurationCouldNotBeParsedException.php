<?php

namespace LeoVie\PhpNf\Exception;

use Exception;
use Throwable;

class ConfigurationCouldNotBeParsedException extends Exception
{
    const DEFAULT_MESSAGE = 'Configuration could not be parsed';

    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        if (empty($message)) {
            $message = self::DEFAULT_MESSAGE;
        }
        parent::__construct($message, $code, $previous);
    }
}