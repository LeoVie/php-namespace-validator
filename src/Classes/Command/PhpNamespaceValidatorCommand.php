<?php

namespace LeoVie\PhpNamespaceValidator\Command;

use LeoVie\PhpNamespaceValidator\Configuration\Configuration;
use LeoVie\PhpNamespaceValidator\Configuration\ConfigurationLoader;
use LeoVie\PhpNamespaceValidator\Exception\ConfigurationCouldNotBeParsedException;
use LeoVie\PhpNamespaceValidator\Exception\ConfigurationFileNotFoundException;
use LeoVie\PhpNamespaceValidator\Exception\NamespaceIsNotValidException;
use LeoVie\PhpNamespaceValidator\Exception\PropertyNotSetException;
use LeoVie\PhpNamespaceValidator\PhpClass\PhpClass;
use LeoVie\PhpNamespaceValidator\PhpClass\PhpClassLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PhpNamespaceValidatorCommand extends Command
{
    protected static $defaultName = 'php-namespace-validator:validate';

    /** @var Configuration $configuration */
    private $configuration;

    private $configurationPath;

    public function __construct(?string $name = null, ?string $configurationPath = null)
    {
        parent::__construct($name);
        $this->configurationPath = $configurationPath;
    }

    /**
     * @throws ConfigurationCouldNotBeParsedException
     * @throws ConfigurationFileNotFoundException
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $configurationLoader = new ConfigurationLoader();
        $this->configuration = $configurationLoader->loadConfiguration($this->configurationPath);

        $phpClassLoader = new PhpClassLoader();
        $phpClassLoader->setBaseNamespace($this->configuration->getBaseNamespace());
        $phpClassLoader->loadPhpClassesInPath($this->configuration->getClassesDir());
        $phpClasses = $phpClassLoader->getPhpClasses();

        /** @var PhpClass[] $phpClasses */
        foreach ($phpClasses as $phpClass) {
            try {
                $phpClass->throwIfNamespaceIsNotValid();
            } catch (NamespaceIsNotValidException $e) {
                $output->writeln($e->getMessage());
            } catch (PropertyNotSetException $e) {
                $output->writeln($e->getMessage());
            }
        }
    }
}