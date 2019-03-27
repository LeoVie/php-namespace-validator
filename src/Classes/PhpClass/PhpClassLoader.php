<?php

namespace LeoVie\PhpNamespaceValidator\PhpClass;

use Symfony\Component\Finder\Finder;

require_once(__DIR__ . '/../../../vendor/autoload.php');

class PhpClassLoader
{
    private $phpClasses = [];
    private $baseNamespace;

    public function setBaseNamespace(string $baseNamespace): void
    {
        $this->baseNamespace = $baseNamespace;
    }

    public function getPhpClasses(): array
    {
        return $this->phpClasses;
    }

    public function loadPhpClassesInPath(string $path)
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
        $finder = new Finder();
        $finder->in($path);
        $finder->files();

        return $finder;
    }

    private function extractNamespaceFromClassContent(string $classContent)
    {
        $pattern = '@namespace\s+(.+);@i';

        preg_match($pattern, $classContent, $matches);

        $namespace = $matches[1];

        return $namespace;
    }

    private function extractClassnameFromClassContent(string $classContent)
    {
        $pattern = '@class\s+(.+)@i';

        preg_match($pattern, $classContent, $matches);

        $classname = $matches[1];

        return $classname;
    }
}