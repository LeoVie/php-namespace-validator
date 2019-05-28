<?php

namespace LeoVie\PhpNf\Exception;

use Exception;
use Throwable;

class NamespaceIsNotValidException extends Exception
{
    const NAMESPACE_DOES_NOT_BELONG_TO_BASE_NAMESPACE = 10;
    const NAMESPACE_DOES_NOT_MATCH_PATH = 20;
    private const ABSOLUTE_PATH_PLACEHOLDER = '__ABSOLUTE_PATH__';
    private const NAMESPACE_PLACEHOLDER = '__NAMESPACE__';
    const MESSAGE_TEMPLATE = 'Class "__ABSOLUTE_PATH__" does not match namespace "__NAMESPACE__".';

    private $absolutePath;
    private $namespace;
    private $messageType;

    public function __construct(string $absolutePath, string $namespace, int $messageType)
    {
        $this->absolutePath = $absolutePath;
        $this->namespace = $namespace;
        $this->messageType = $messageType;

        $message = $this->constructMessage();

        parent::__construct($message);
    }

    private function constructMessage(): string
    {
        $message = self::MESSAGE_TEMPLATE;
        $message = str_replace(self::ABSOLUTE_PATH_PLACEHOLDER, $this->absolutePath, $message);
        $message = str_replace(self::NAMESPACE_PLACEHOLDER, $this->namespace, $message);

        return $message;
    }
}