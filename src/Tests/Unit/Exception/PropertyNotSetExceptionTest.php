<?php

namespace LeoVie\PhpNf\Tests\Unit\Configuration;

use LeoVie\PhpNf\Exception\ConfigurationFileNotFoundException;
use LeoVie\PhpNf\Exception\NamespaceIsNotValidException;
use LeoVie\PhpNf\Exception\PropertyNotSetException;
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