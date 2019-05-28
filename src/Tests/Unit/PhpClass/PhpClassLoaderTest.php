<?php

namespace LeoVie\PhpNf\Tests\Unit\Configuration;

use Iterator;
use LeoVie\PhpNf\PhpClass\PhpClass;
use LeoVie\PhpNf\PhpClass\PhpClassLoader;
use LeoVie\PhpNf\Tests\MockHelper;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class PhpClassLoaderTest extends TestCase
{
    private const BASE_NAMESPACE = 'Base\\Namespace';
    private const RELATIVE_PATH = './relative/path';
    private const ABSOLUTE_PATH = 'absolute/path';
    private const CLASS_NAME = 'FancyClass';
    private const INTERFACE_NAME = 'FancyInterface';
    private const TRAIT_NAME = 'FancyTrait';
    private const CLASS_CONTENT = '<?php namespace ' . self::BASE_NAMESPACE . '\\Classes; class ' . self::CLASS_NAME;
    private const INTERFACE_CONTENT = '<?php namespace ' . self::BASE_NAMESPACE . '\\Interfaces; interface ' . self::INTERFACE_NAME;
    private const TRAIT_CONTENT = '<?php namespace ' . self::BASE_NAMESPACE . '\\Traits; trait ' . self::TRAIT_NAME;

    /** @var PhpClassLoader $phpClassLoader */
    private $phpClassLoader;

    public function setUp(): void
    {
        $finder = $this->getMockedFinder();
        $this->phpClassLoader = new PhpClassLoader($finder);
        $this->phpClassLoader->setBaseNamespace(self::BASE_NAMESPACE);
    }

    /** @return Finder|Mockery\MockInterface */
    private function getMockedFinder()
    {
        $finder = Mockery::mock(Finder::class);

        $finder
            ->shouldReceive('in');

        $finder
            ->shouldReceive('files')
            ->andReturn($finder);

        $files = [
            $this->getMockedSplFileInfo(self::CLASS_CONTENT),
            $this->getMockedSplFileInfo(self::INTERFACE_CONTENT),
            $this->getMockedSplFileInfo(self::TRAIT_CONTENT),
        ];
        $iterator = MockHelper::mockArrayIterator(Iterator::class, $files);
        $finder
            ->shouldReceive('getIterator')
            ->andReturn($iterator);

        return $finder;
    }

    private function getMockedSplFileInfo(string $contents)
    {
        $splFileInfo = Mockery::mock(SplFileInfo::class);

        $splFileInfo
            ->shouldReceive('getRelativePath')
            ->andReturn(self::RELATIVE_PATH);

        $splFileInfo
            ->shouldReceive('getRealPath')
            ->andReturn(self::ABSOLUTE_PATH);

        $splFileInfo
            ->shouldReceive('getContents')
            ->andReturn($contents);

        return $splFileInfo;
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

    public function testLoadPhpClassesInPath(): void
    {
        $expected = [
            $this->createPhpClass(self::BASE_NAMESPACE, self::CLASS_NAME, self::BASE_NAMESPACE . '\\Classes', self::RELATIVE_PATH, self::ABSOLUTE_PATH),
            $this->createPhpClass(self::BASE_NAMESPACE, self::INTERFACE_NAME, self::BASE_NAMESPACE . '\\Interfaces', self::RELATIVE_PATH, self::ABSOLUTE_PATH),
            $this->createPhpClass(self::BASE_NAMESPACE, self::TRAIT_NAME, self::BASE_NAMESPACE . '\\Traits', self::RELATIVE_PATH, self::ABSOLUTE_PATH),
        ];

        $this->phpClassLoader->loadPhpClassesInPath('');

        $actual = $this->phpClassLoader->getPhpClasses();

        self::assertEquals($expected, $actual);
    }

    /** @return PhpClass|Mockery\MockInterface */
    private function createPhpClass(string $baseNamespace, string $name, string $namespace, string $relativePath, string $absolutePath)
    {
        $phpClass = new PhpClass();
        $phpClass->setBaseNamespace($baseNamespace);
        $phpClass->setClassname($name);
        $phpClass->setNamespace($namespace);
        $phpClass->setRelativePath($relativePath);
        $phpClass->setAbsolutePath($absolutePath);

        return $phpClass;
    }
}