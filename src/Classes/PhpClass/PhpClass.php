<?php

namespace LeoVie\PhpNf\PhpClass;

use LeoVie\PhpNf\Exception\NamespaceIsNotValidException;
use LeoVie\PhpNf\Exception\PropertyNotSetException;

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

    /**
     * @throws NamespaceIsNotValidException
     * @throws PropertyNotSetException
     */
    public function throwIfNamespaceIsNotValid(): bool
    {
        if ($this->absolutePath === null) {
            throw new PropertyNotSetException('absolutePath');
        }
        if ($this->namespace === null) {
            throw new PropertyNotSetException('namespace');
        }

        $relativePath = str_replace('/', '\\', $this->relativePath);
        $expectedNamespace = "$this->baseNamespace\\$relativePath";

        if (!$this->namespaceBelongsToBaseNamespace()) {
            throw new NamespaceIsNotValidException($this->absolutePath, $this->namespace, NamespaceIsNotValidException::NAMESPACE_DOES_NOT_BELONG_TO_BASE_NAMESPACE);
        }

        $expectedNamespace = trim($expectedNamespace, '\\');

        if ($this->namespace !== $expectedNamespace) {
            throw new NamespaceIsNotValidException($this->absolutePath, $this->namespace, NamespaceIsNotValidException::NAMESPACE_DOES_NOT_MATCH_PATH);
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
}