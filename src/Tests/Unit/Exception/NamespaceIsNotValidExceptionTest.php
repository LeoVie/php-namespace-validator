<?php

namespace LeoVie\PhpNamespaceValidator\Tests\Unit\Configuration;

require_once(__DIR__ . '/../../../../vendor/autoload.php');

use LeoVie\PhpNamespaceValidator\Exception\ConfigurationFileNotFoundException;
use LeoVie\PhpNamespaceValidator\Exception\NamespaceIsNotValidException;
use PHPUnit\Framework\TestCase;

class NamespaceIsNotValidExceptionTest extends TestCase
{
    private const ABSOLUTE_PATH = 'foo/bar/path';
    private const NAMESPACE = 'Foo\\Foo\\Bar';
    private const MESSAGE_TYPE = NamespaceIsNotValidException::NAMESPACE_DOES_NOT_BELONG_TO_BASE_NAMESPACE;

    public function testExceptionMessageContainsAbsolutePath()
    {
        try {
            throw new NamespaceIsNotValidException(self::ABSOLUTE_PATH, self::NAMESPACE, self::MESSAGE_TYPE);
        } catch (NamespaceIsNotValidException $e) {
            $message = $e->getMessage();
        }

        $this->assertStringContainsString(self::ABSOLUTE_PATH, $message);
    }

    public function testExceptionMessageContainsNamespace()
    {
        try {
            throw new NamespaceIsNotValidException(self::ABSOLUTE_PATH, self::NAMESPACE, self::MESSAGE_TYPE);
        } catch (NamespaceIsNotValidException $e) {
            $message = $e->getMessage();
        }

        $this->assertStringContainsString(self::NAMESPACE, $message);
    }
}