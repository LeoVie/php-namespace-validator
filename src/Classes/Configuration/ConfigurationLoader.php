<?php

namespace LeoVie\PhpNamespaceValidator\Configuration;

use LeoVie\PhpNamespaceValidator\Exception\ConfigurationCouldNotBeParsedException;
use LeoVie\PhpNamespaceValidator\Exception\ConfigurationFileNotFoundException;

class ConfigurationLoader
{
    private const DEFAULT_CONFIGURATION_PATH = __DIR__ . '/../../../php-namespace-validator.json';

    private $configurationPath;

    /**
     * @throws ConfigurationCouldNotBeParsedException
     * @throws ConfigurationFileNotFoundException
     */
    public function loadConfiguration(?string $configurationPath = null): Configuration
    {
        if ($configurationPath === null) {
            $configurationPath = self::DEFAULT_CONFIGURATION_PATH;
        }
        $this->configurationPath = $configurationPath;
        $configurationHolder = $this->populateConfigurationHolder();

        return $configurationHolder;
    }

    /**
     * @throws ConfigurationCouldNotBeParsedException
     * @throws ConfigurationFileNotFoundException
     */
    private function populateConfigurationHolder(): Configuration
    {
        $configurationHolder = new Configuration();

        $configurationEntries = $this->loadAndDecodeJson();
        foreach ($configurationEntries as $configurationEntryKey => $configurationEntryValue) {

            $this->setValueToConfigurationHolderIfMethodExists(
                $configurationHolder,
                $configurationEntryKey,
                $configurationEntryValue
            );
        }

        return $configurationHolder;
    }

    private function constructSetterMethodNameForConfigurationEntryKey(
        string $configurationEntryKey
    ): string
    {
        $camelCaseKey = $this->convertHyphenatedToCamelCase($configurationEntryKey);
        $methodName = 'set' . $camelCaseKey;

        return $methodName;
    }

    private function convertHyphenatedToCamelCase(string $hyphenatedString): string
    {
        $uppercasedWordsString = ucwords($hyphenatedString, '-');
        $camelCaseString = str_replace('-', '', $uppercasedWordsString);

        return $camelCaseString;
    }

    private function setValueToConfigurationHolderIfMethodExists(
        Configuration &$configurationHolder,
        string $configurationEntryKey,
        $configurationEntryValue
    )
    {
        $setterMethodName = $this->constructSetterMethodNameForConfigurationEntryKey($configurationEntryKey);
        if (method_exists($configurationHolder, $setterMethodName)) {
            call_user_func_array([$configurationHolder, $setterMethodName], [$configurationEntryValue]);
        }
    }

    /**
     * @throws ConfigurationFileNotFoundException
     * @throws ConfigurationCouldNotBeParsedException
     */
    private function loadAndDecodeJson()
    {
        $configurationJson = @file_get_contents($this->configurationPath);
        if ($configurationJson === false) {
            throw new ConfigurationFileNotFoundException($this->configurationPath);
        }

        $configurationEntries = json_decode($configurationJson);
        if ($configurationEntries === null) {
            throw new ConfigurationCouldNotBeParsedException();
        }

        return $configurationEntries;
    }
}