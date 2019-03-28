<?php

namespace LeoVie\PhpNamespaceValidator\Tests\Unit\Configuration;

require_once(__DIR__ . '/../../../../vendor/autoload.php');

use LeoVie\PhpNamespaceValidator\Exception\ConfigurationFileNotFoundException;
use LeoVie\PhpNamespaceValidator\Exception\NamespaceIsNotValidException;
use LeoVie\PhpNamespaceValidator\Exception\PropertyNotSetException;
use PHPUnit\Framework\TestCase;

class PropertyNotSetExceptionTest extends TestCase
{
    private const PROPERTY_NAME = 'fancyProperty';

    public function testExceptionMessageContainsPropertyName()
    {
        try {
            throw new PropertyNotSetException(self::PROPERTY_NAME);
        } catch (PropertyNotSetException $e) {
            $message = $e->getMessage();
        }

        $this->assertStringContainsString(self::PROPERTY_NAME, $message);
    }
}