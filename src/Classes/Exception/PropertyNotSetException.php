<?php

namespace LeoVie\PhpNf\Exception;

use Exception;
use Throwable;

class PropertyNotSetException extends Exception
{
    private const PROPERTY_NAME_PLACEHOLDER = '__PROPERTY_NAME__';
    private const DEFAULT_MESSAGE_TEMPLATE = 'Property "__PROPERTY_NAME__" has not been set.';

    public function __construct(string $propertyName, string $messageTemplate = "")
    {
        if (empty($messageTemplate)) {
            $messageTemplate = self::DEFAULT_MESSAGE_TEMPLATE;
        }
        $message = str_replace(self::PROPERTY_NAME_PLACEHOLDER, $propertyName, $messageTemplate);

        parent::__construct($message);
    }
}