<?php

namespace LeoVie\PhpNf\PhpClass;

use Symfony\Component\Finder\Finder;

class PhpClassLoader
{
    private $phpClasses = [];
    private $baseNamespace;

    /** @var Finder */
    private $finder;

    public function __construct(Finder $finder)
    {
        $this->finder = $finder;
    }

    public function setBaseNamespace(string $baseNamespace): void
    {
        $this->baseNamespace = $baseNamespace;
    }

    public function getPhpClasses(): array
    {
        return $this->phpClasses;
    }

    public function loadPhpClassesInPath(string $path): void
    {
        $phpFiles = $this->findPhpFilesInPath($path);

        foreach ($phpFiles as $phpFile) {
            $phpClass = new PhpClass();

            $phpClass->setBaseNamespace($this->baseNamespace);

            $relativeFilePath = $phpFile->getRelativePath();
            $phpClass->setRelativePath($relativeFilePath);

            $absoluteFilePath = $phpFile->getRealPath();
            $phpClass->setAbsolutePath($absoluteFilePath);

            $fileContents = $phpFile->getContents();

            $namespace = $this->extractNamespaceFromClassContent($fileContents);
            $phpClass->setNamespace($namespace);

            $classname = $this->extractClassnameFromClassContent($fileContents);
            $phpClass->setClassname($classname);

            $this->phpClasses[] = $phpClass;
        }
    }

    private function findPhpFilesInPath(string $path): Finder
    {
        $this->finder->in($path);
        $this->finder->files();

        return $this->finder;
    }

    private function extractNamespaceFromClassContent(string $classContent): string
    {
        $pattern = '@namespace\s+(.+);@i';

        preg_match($pattern, $classContent, $matches);

        $namespace = $matches[1];

        return $namespace;
    }

    private function extractClassnameFromClassContent(string $classContent): string
    {
        $pattern = '@(?>class|interface|trait)\s+(.+)@i';

        preg_match($pattern, $classContent, $matches);

        $classname = $matches[1];

        return $classname;
    }
}