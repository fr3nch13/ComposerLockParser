<?php declare(strict_types=1);

namespace ComposerLockParser\Tests;

use ComposerLockParser\ComposerInfo;
use PHPUnit\Framework\TestCase;

/**
 * Tests src/Package.php
 */
final class PackagesCollectionTest extends TestCase
{
    /**
     * @var \ComposerLockParser\ComposerInfo
     */
    private $ComposerInfo;
    /**
     * @var \ComposerLockParser\PackagesCollection
     */
    private $Packages;

    /**
     * Tests the parser
     * @return void
     */
    public function setUp(): void
    {
        $this->ComposerInfo = new ComposerInfo(dirname(__DIR__) . DIRECTORY_SEPARATOR. 'assets' . DIRECTORY_SEPARATOR . 'composer.lock');
        $this->Packages = $this->ComposerInfo->getPackages();
    }

    /**
     * Tests packages Get By Name
     * @return void
     */
    public function testGetByName(): void
    {
        $package = $this->Packages->getByName('t4web/composer-lock-parser');
        $this->assertSame('t4web/composer-lock-parser', $package->getName());

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage("Package fr3nch13/dont-exist not exists");
        $package = $this->Packages->getByName('fr3nch13/dont-exist');
    }

    /**
     * Tests packages Get By Name
     * @return void
     */
    public function testGetByNamespace(): void
    {
        $package = $this->Packages->getByNamespace('ComposerLockParser');
        $this->assertSame('t4web/composer-lock-parser', $package->getName());

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage("Package ComposerLockParserNope not exists");
        $package = $this->Packages->getByNamespace('ComposerLockParserNope');
    }

    /**
     * Tests packages Has By Name
     * @return void
     */
    public function testHasByName(): void
    {
        $result = $this->Packages->hasByName('t4web/composer-lock-parser');
        $this->assertTrue($result);

        $result = $this->Packages->hasByName('fr3nch13/dont-exist');
        $this->assertFalse($result);
    }

    /**
     * Tests packages Has By Namespace
     * @return void
     */
    public function testHasByNamespace(): void
    {
        $result = $this->Packages->hasByNamespace('ComposerLockParser');
        $this->assertTrue($result);

        $result = $this->Packages->hasByNamespace('ComposerLockParserNope');
        $this->assertFalse($result);
    }

    /**
     * Tests packages index by name
     * @return void
     */
    public function testGetIndexedByName(): void
    {
        $this->Packages->resetIndex();
        $result = $this->Packages->hasByName('t4web/composer-lock-parser');
        $this->assertTrue($result);

        $result = $this->Packages->hasByNamespace('ComposerLockParserNope');
        $this->assertFalse($result);
    }
}
