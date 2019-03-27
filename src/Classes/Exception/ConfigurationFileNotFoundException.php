<?php

namespace LeoVie\PhpNamespaceValidator\Exception;

use Exception;
use Throwable;

class ConfigurationFileNotFoundException extends Exception
{
    private const DEFAULT_MESSAGE_PREFIX = 'No configuration file found at ';

    public function __construct(string $configurationPath, string $message = "", int $code = 0, Throwable $previous = null)
    {
        if (empty($message)) {
            $message = self::DEFAULT_MESSAGE_PREFIX . $configurationPath;
        }
        parent::__construct($message, $code, $previous);
    }
}