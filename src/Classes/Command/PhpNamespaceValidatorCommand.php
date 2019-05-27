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
    public const NAME = 'php-nf';
    protected static $defaultName = self::NAME;

    /** @var Configuration $configuration */
    private $configuration;

    private $configurationPath;

    /** @var ConfigurationLoader */
    private $configurationLoader;

    /** @var PhpClassLoader */
    private $phpClassLoader;

    public function __construct(
        ConfigurationLoader $configurationLoader,
        PhpClassLoader $phpClassLoader
    )
    {
        parent::__construct();
        $this->configurationLoader = $configurationLoader;
        $this->phpClassLoader = $phpClassLoader;
    }

    /**
     * @throws ConfigurationCouldNotBeParsedException
     * @throws ConfigurationFileNotFoundException
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->configuration = $this->configurationLoader->loadConfiguration($this->configurationPath);
        $this->phpClassLoader->setBaseNamespace($this->configuration->getBaseNamespace());
        $this->phpClassLoader->loadPhpClassesInPath($this->configuration->getClassesDir());
        $phpClasses = $this->phpClassLoader->getPhpClasses();

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