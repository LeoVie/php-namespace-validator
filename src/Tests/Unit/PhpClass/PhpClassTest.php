<?php

namespace LeoVie\PhpNf\Tests\Unit\Configuration;

use LeoVie\PhpNf\Exception\NamespaceIsNotValidException;
use LeoVie\PhpNf\PhpClass\PhpClass;
use PHPUnit\Framework\TestCase;

class PhpClassTest extends TestCase
{
    private const BASE_NAMESPACE = 'FancyVendor\\FancyBaseNamespace';
    private const CLASSNAME = 'FancyClass';
    private const NAMESPACE_NOT_MATCHING_BASE_NAMESPACE = 'OtherFancyVendor\\FancyBaseNamespace\\NextLevel';
    private const NAMESPACE_MATCHING_BASE_NAMESPACE_NOT_MATCHING_PATH = 'FancyVendor\\FancyBaseNamespace\\NextLevel\\NotAnotherLevel';
    private const NAMESPACE_MATCHING_BASE_NAMESPACE_MATCHING_PATH = 'FancyVendor\\FancyBaseNamespace\\NextLevel\\AnotherLevel';
    private const RELATIVE_PATH = 'NextLevel/AnotherLevel';
    private const ABSOLUTE_PATH = 'src/Classes/';

    /** @var PhpClass $phpClass */
    private $phpClass;

    public function setUp(): void
    {
        $this->phpClass = new PhpClass();
        $this->phpClass->setBaseNamespace(self::BASE_NAMESPACE);
        $this->phpClass->setClassname(self::CLASSNAME);
        $this->phpClass->setRelativePath(self::RELATIVE_PATH);
        $this->phpClass->setAbsolutePath(self::ABSOLUTE_PATH);
    }

    public function testThrowsIfNamespaceDoesNotBelongToBaseNamespace(): void
    {
        $this->setNamespaceNotBelongingToBaseNamespace();

        self::expectException(NamespaceIsNotValidException::class);
        $this->phpClass->throwIfNamespaceIsNotValid();
    }

    private function setNamespaceNotBelongingToBaseNamespace(): void
    {
        $this->phpClass->setNamespace(self::NAMESPACE_NOT_MATCHING_BASE_NAMESPACE);
    }

    public function testThrowsIfNamespaceDoesNotMatchPath(): void
    {
        $this->setNamespaceNotMatchingPath();

        self::expectException(NamespaceIsNotValidException::class);
        $this->phpClass->throwIfNamespaceIsNotValid();
    }

    private function setNamespaceNotMatchingPath(): void
    {
        $this->phpClass->setNamespace(self::NAMESPACE_MATCHING_BASE_NAMESPACE_NOT_MATCHING_PATH);
    }

    public function testThrowsNotIfNamespaceBelongsToBaseNamespaceAndMatchesPath(): void
    {
        $this->setNamespaceBelongingToBaseNamespaceAndMatchingPath();

        self::addToAssertionCount(1);
    }

    private function setNamespaceBelongingToBaseNamespaceAndMatchingPath(): void
    {
        $this->phpClass->setNamespace(self::NAMESPACE_MATCHING_BASE_NAMESPACE_MATCHING_PATH);
    }
}