<?php

namespace LeoVie\PhpNamespaceValidator\Tests\Unit\Configuration;

require_once(__DIR__ . '/../../../../vendor/autoload.php');

use LeoVie\PhpNamespaceValidator\Configuration\Configuration;
use LeoVie\PhpNamespaceValidator\Configuration\ConfigurationLoader;
use LeoVie\PhpNamespaceValidator\Exception\ConfigurationCouldNotBeParsedException;
use LeoVie\PhpNamespaceValidator\Exception\ConfigurationFileNotFoundException;
use PHPUnit\Framework\TestCase;

class ConfigurationLoaderTest extends TestCase
{
    private const TESTDATA_DIRECTORY = __DIR__ . '/testdata/';

    /** @var ConfigurationLoader $configurationLoader */
    private $configurationLoader;

    public function setUp(): void
    {
        $this->configurationLoader = new ConfigurationLoader();
    }

    public function testThrowsIfConfigurationPathDoesNotExist(): void
    {
        $configurationPath = 'ABC';

        $this->expectException(ConfigurationFileNotFoundException::class);
        $this->configurationLoader->loadConfiguration($configurationPath);
    }

    public function testThrowsIfBadJson(): void
    {
        $configurationPath = self::TESTDATA_DIRECTORY . 'php-namespace-validator-bad-json.json';

        $this->expectException(ConfigurationCouldNotBeParsedException::class);
        $this->configurationLoader->loadConfiguration($configurationPath);
    }

    public function testReturnsConfigurationHolderWithCorrectValues()
    {
        $configurationPath = self::TESTDATA_DIRECTORY . 'php-namespace-validator-good.json';

        $expectedBaseNamespace = "LeoVie\\PhpNamespaceValidator";
        $expectedClassesDir = "./src/Classes/";

        /** @var Configuration $configurationHolder */
        $configurationHolder = $this->configurationLoader->loadConfiguration($configurationPath);

        $actualBaseNamespace = $configurationHolder->getBaseNamespace();
        $actualClassesDir = $configurationHolder->getClassesDir();

        $this->assertEquals($expectedBaseNamespace, $actualBaseNamespace);
        $this->assertEquals($expectedClassesDir, $actualClassesDir);
    }
}