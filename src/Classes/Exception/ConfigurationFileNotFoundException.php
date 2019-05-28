<?php

namespace LeoVie\PhpNf\Exception;

use Exception;
use Throwable;

class ConfigurationFileNotFoundException extends Exception
{
    const DEFAULT_MESSAGE_PREFIX = 'No configuration file found at ';

    public function __construct(string $configurationPath, string $message = "")
    {
        if (empty($message)) {
            $message = self::DEFAULT_MESSAGE_PREFIX . $configurationPath;
        }
        parent::__construct($message);
    }
}