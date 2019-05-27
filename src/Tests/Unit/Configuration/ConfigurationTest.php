<?php

namespace LeoVie\PhpNf\Tests\Unit\Configuration;

use LeoVie\PhpNf\Configuration\Configuration;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    private const INITIAL_BASE_NAMESPACE = '';
    private const BASE_NAMESPACE = 'FancyVendor\\FancyBaseNamespace';
    private const INITIAL_CLASSES_DIR = '';
    private const CLASSES_DIR_WINDOWS = 'src/Classes';
    private const CLASSES_DIR_LINUX = 'src\\Classes';

    /** @var Configuration $configuration */
    private $configuration;

    public function setUp(): void
    {
        $this->configuration = new Configuration();
    }

    public function testGetBaseNamespaceReturnsInitialValue(): void
    {
        $expected = self::INITIAL_BASE_NAMESPACE;
        $actual = $this->configuration->getBaseNamespace();

        self::assertEquals($expected, $actual);
    }

    public function testSetBaseNamespaceSets(): void
    {
        $this->configuration->setBaseNamespace(self::BASE_NAMESPACE);

        $expectedBaseNamespace = self::BASE_NAMESPACE;
        $actualBaseNamespace = $this->configuration->getBaseNamespace();

        self::assertEquals($expectedBaseNamespace, $actualBaseNamespace);
    }

    public function testGetClassesDirReturnsInitialValue(): void
    {
        $expected = self::INITIAL_CLASSES_DIR;
        $actual = $this->configuration->getClassesDir();

        self::assertEquals($expected, $actual);
    }

    public function testSetClassesDirSetsWithWindowsFormat(): void
    {
        $this->configuration->setClassesDir(self::CLASSES_DIR_WINDOWS);

        $expectedClassDir = self::CLASSES_DIR_WINDOWS;
        $actualClassDir = $this->configuration->getClassesDir();

        self::assertEquals($expectedClassDir, $actualClassDir);
    }

    public function testSetClassesDirSetsWithUnixFormat(): void
    {
        $this->configuration->setClassesDir(self::CLASSES_DIR_LINUX);

        $expectedClassDir = self::CLASSES_DIR_LINUX;
        $actualClassDir = $this->configuration->getClassesDir();

        self::assertEquals($expectedClassDir, $actualClassDir);
    }
}