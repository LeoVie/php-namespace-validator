<?php

namespace LeoVie\PhpNamespaceValidator\Tests\Unit\Configuration;

require_once(__DIR__ . '/../../../../vendor/autoload.php');

use LeoVie\PhpNamespaceValidator\Configuration\Configuration;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    private const BASE_NAMESPACE = 'FancyVendor\\FancyBaseNamespace';
    private const CLASS_DIR_WINDOWS = 'src/Classes';
    private const CLASS_DIR_UNIX = 'src\\Classes';

    /** @var Configuration $configuration */
    private $configuration;

    public function setUp(): void
    {
        $this->configuration = new Configuration();
    }

    public function testSetAndGetBaseNamespace()
    {
        $this->configuration->setBaseNamespace(self::BASE_NAMESPACE);

        $expectedBaseNamespace = self::BASE_NAMESPACE;
        $actualBaseNamespace = $this->configuration->getBaseNamespace();

        $this->assertEquals($expectedBaseNamespace, $actualBaseNamespace);
    }

    public function testSetAndGetClassesDirWindowsFormat()
    {
        $this->configuration->setClassesDir(self::CLASS_DIR_WINDOWS);

        $expectedClassDir = self::CLASS_DIR_WINDOWS;
        $actualClassDir = $this->configuration->getClassesDir();

        $this->assertEquals($expectedClassDir, $actualClassDir);
    }

    public function testSetAndGetClassesDirUnixFormat()
    {
        $this->configuration->setClassesDir(self::CLASS_DIR_UNIX);

        $expectedClassDir = self::CLASS_DIR_UNIX;
        $actualClassDir = $this->configuration->getClassesDir();

        $this->assertEquals($expectedClassDir, $actualClassDir);
    }
}