<?php

namespace LeoVie\PhpNamespaceValidator\PhpClass;

class PhpClass
{
    private $baseNamespace;
    private $classname;
    private $namespace;
    private $relativePath;
    private $absolutePath;

    public function setBaseNamespace(string $baseNamespace): void
    {
        $this->baseNamespace = $baseNamespace;
    }

    public function setClassname(string $classname): void
    {
        $this->classname = $classname;
    }

    public function setNamespace(string $namespace): void
    {
        $this->namespace = $namespace;
    }

    public function setRelativePath(string $relativePath): void
    {
        $this->relativePath = $relativePath;
    }

    public function setAbsolutePath(string $absolutePath): void
    {
        $this->absolutePath = $absolutePath;
    }

    public function validateNamespaceMatchesPath(): bool
    {
        $relativePath = str_replace('/', '\\', $this->relativePath);
        $expectedNamespace = "$this->baseNamespace\\$relativePath";

        if (!$this->namespaceBelongsToBaseNamespace()) {
            return false;
        }

        $expectedNamespace = trim($expectedNamespace, '\\');

        if ($this->namespace !== $expectedNamespace) {
            return false;
        }


        return true;
    }

    private function namespaceBelongsToBaseNamespace(): bool
    {
        if (strpos($this->namespace, $this->baseNamespace) !== 0) {
            return false;
        }
        return true;
    }

    public function getDoesNotMatchMessage(): string
    {
        $message
            = 'Class ' . $this->absolutePath . ' '
            . 'does not match namespace ' . $this->namespace;

        return $message;
    }
}