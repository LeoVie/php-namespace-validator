<?php

namespace LeoVie\PhpNamespaceValidator\Tests\Unit\Configuration;

require_once(__DIR__ . '/../../../../vendor/autoload.php');

use LeoVie\PhpNamespaceValidator\Exception\NamespaceIsNotValidException;
use LeoVie\PhpNamespaceValidator\PhpClass\PhpClass;
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

    public function testThrowsIfNamespaceDoesNotBelongToBaseNamespace()
    {
        $this->setNamespaceNotBelongingToBaseNamespace();

        $this->expectException(NamespaceIsNotValidException::class);
        $this->phpClass->throwIfNamespaceIsNotValid();
    }

    private function setNamespaceNotBelongingToBaseNamespace()
    {
        $this->phpClass->setNamespace(self::NAMESPACE_NOT_MATCHING_BASE_NAMESPACE);
    }

    public function testThrowsIfNamespaceDoesNotMatchPath()
    {
        $this->setNamespaceNotMatchingPath();

        $this->expectException(NamespaceIsNotValidException::class);
        $this->phpClass->throwIfNamespaceIsNotValid();
    }

    private function setNamespaceNotMatchingPath()
    {
        $this->phpClass->setNamespace(self::NAMESPACE_MATCHING_BASE_NAMESPACE_NOT_MATCHING_PATH);
    }

    public function testThrowsNotIfNamespaceBelongsToBaseNamespaceAndMatchesPath()
    {
        $this->setNamespaceBelongingToBaseNamespaceAndMatchingPath();

        $this->addToAssertionCount(1);
    }

    private function setNamespaceBelongingToBaseNamespaceAndMatchingPath()
    {
        $this->phpClass->setNamespace(self::NAMESPACE_MATCHING_BASE_NAMESPACE_MATCHING_PATH);
    }
}