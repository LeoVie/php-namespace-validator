<?php

namespace LeoVie\PhpNf\Tests\Unit\Configuration;

use LeoVie\PhpNf\PhpClass\PhpClassLoader;
use PHPUnit\Framework\TestCase;

class PhpClassLoaderTest extends TestCase
{
    private const BASE_NAMESPACE = 'Base\\Namespace';

    /** @var PhpClassLoader $phpClassLoader */
    private $phpClassLoader;

    public function setUp(): void
    {
        $this->phpClassLoader = new PhpClassLoader();
    }

    public function testSetBaseNamespaceDoesNotFail(): void
    {
        $this->phpClassLoader->setBaseNamespace(self::BASE_NAMESPACE);

        self::addToAssertionCount(1);
    }

    public function testGetPhpClassesReturnsInitialValue(): void
    {
        $expected = [];
        $actual = $this->phpClassLoader->getPhpClasses();

        self::assertEquals($expected, $actual);
    }
}