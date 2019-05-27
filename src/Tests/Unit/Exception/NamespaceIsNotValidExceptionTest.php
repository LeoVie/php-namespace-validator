<?php

namespace LeoVie\PhpNf\Tests\Unit\Configuration;

use LeoVie\PhpNf\Exception\NamespaceIsNotValidException;
use PHPUnit\Framework\TestCase;

class NamespaceIsNotValidExceptionTest extends TestCase
{
    private const ABSOLUTE_PATH = 'foo/bar/path';
    private const NAMESPACE = 'Foo\\Foo\\Bar';
    private const MESSAGE_TYPE = NamespaceIsNotValidException::NAMESPACE_DOES_NOT_BELONG_TO_BASE_NAMESPACE;

    public function testExceptionMessageContainsAbsolutePath(): void
    {
        try {
            throw new NamespaceIsNotValidException(self::ABSOLUTE_PATH, self::NAMESPACE, self::MESSAGE_TYPE);
        } catch (NamespaceIsNotValidException $e) {
            $message = $e->getMessage();
        }

        self::assertStringContainsString(self::ABSOLUTE_PATH, $message);
    }

    public function testExceptionMessageContainsNamespace(): void
    {
        try {
            throw new NamespaceIsNotValidException(self::ABSOLUTE_PATH, self::NAMESPACE, self::MESSAGE_TYPE);
        } catch (NamespaceIsNotValidException $e) {
            $message = $e->getMessage();
        }

        self::assertStringContainsString(self::NAMESPACE, $message);
    }
}