<?php

namespace LeoVie\PhpNamespaceValidator\Tests\Unit\Configuration;

use LeoVie\PhpNamespaceValidator\Exception\ConfigurationFileNotFoundException;
use LeoVie\PhpNamespaceValidator\Exception\NamespaceIsNotValidException;
use LeoVie\PhpNamespaceValidator\Exception\PropertyNotSetException;
use PHPUnit\Framework\TestCase;

class PropertyNotSetExceptionTest extends TestCase
{
    private const PROPERTY_NAME = 'fancyProperty';

    public function testExceptionMessageContainsPropertyName(): void
    {
        try {
            throw new PropertyNotSetException(self::PROPERTY_NAME);
        } catch (PropertyNotSetException $e) {
            $message = $e->getMessage();
        }

        self::assertStringContainsString(self::PROPERTY_NAME, $message);
    }
}