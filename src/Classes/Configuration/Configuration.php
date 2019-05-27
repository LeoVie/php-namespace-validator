<?php

namespace LeoVie\PhpNamespaceValidator\Configuration;

class Configuration
{
    private $baseNamespace = '';
    private $classesDir = '';

    public function getBaseNamespace(): string
    {
        return $this->baseNamespace;
    }

    public function setBaseNamespace(string $baseNamespace): void
    {
        $this->baseNamespace = $baseNamespace;
    }

    public function getClassesDir(): string
    {
        return $this->classesDir;
    }

    public function setClassesDir(string $classesDir): void
    {
        $this->classesDir = $classesDir;
    }
}