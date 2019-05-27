<?php

namespace LeoVie\PhpNf\Tests\Unit\Configuration;

use LeoVie\PhpNf\Configuration\Configuration;
use LeoVie\PhpNf\Configuration\ConfigurationLoader;
use LeoVie\PhpNf\Exception\ConfigurationCouldNotBeParsedException;
use LeoVie\PhpNf\Exception\ConfigurationFileNotFoundException;
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

        self::expectException(ConfigurationFileNotFoundException::class);
        $this->configurationLoader->loadConfiguration($configurationPath);
    }

    public function testThrowsIfBadJson(): void
    {
        $configurationPath = self::TESTDATA_DIRECTORY . 'php-nf-bad-json.json';

        self::expectException(ConfigurationCouldNotBeParsedException::class);
        $this->configurationLoader->loadConfiguration($configurationPath);
    }

    public function testReturnsConfigurationHolderWithCorrectValues(): void
    {
        $configurationPath = self::TESTDATA_DIRECTORY . 'php-nf-good.json';

        $expectedBaseNamespace = "LeoVie\\PhpNf";
        $expectedClassesDir = "./src/Classes/";

        /** @var Configuration $configurationHolder */
        $configurationHolder = $this->configurationLoader->loadConfiguration($configurationPath);

        $actualBaseNamespace = $configurationHolder->getBaseNamespace();
        $actualClassesDir = $configurationHolder->getClassesDir();

        self::assertEquals($expectedBaseNamespace, $actualBaseNamespace);
        self::assertEquals($expectedClassesDir, $actualClassesDir);
    }
}