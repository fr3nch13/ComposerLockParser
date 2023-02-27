<?php declare(strict_types=1);

namespace ComposerLockParser\Tests;

use ComposerLockParser\ComposerInfo;
use ComposerLockParser\RuntimeException;
use PHPUnit\Framework\TestCase;

/**
 * Tests src/ComposerInfo.php
 */
final class ComposerInfoTest extends TestCase
{
    /**
     * Tests the parser
     * @return void
     */
    public function testParse(): void
    {
        $composerInfo = new ComposerInfo(dirname(__DIR__) . DIRECTORY_SEPARATOR. 'assets' . DIRECTORY_SEPARATOR . 'composer.lock');
        $result = $composerInfo->getPackages();

        $this->assertInstanceOf('\ComposerLockParser\PackagesCollection', $result);
        $this->assertSame(33, count($result));
    }

    /**
     * Tests missing lock file
     * @return void
     */
    public function testParseNoFile(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("not found or not readable.");
        $composerInfo = new ComposerInfo(__DIR__ . DIRECTORY_SEPARATOR. 'assets' . DIRECTORY_SEPARATOR . 'composer_dontexist.lock');
        $composerInfo->getPackages();
    }

    /**
     * Tests malformed json in lock file
     * @return void
     */
    public function testParseBad(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Json parser error: Syntax error, malformed JSON");
        $composerInfo = new ComposerInfo(dirname(__DIR__) . DIRECTORY_SEPARATOR. 'assets' . DIRECTORY_SEPARATOR . 'composer_bad.lock');
        $result = $composerInfo->getPackages();
    }

    /**
     * Tests the hash
     * @return void
     */
    public function testGetHash(): void
    {
        $composerInfo = new ComposerInfo(dirname(__DIR__) . DIRECTORY_SEPARATOR. 'assets' . DIRECTORY_SEPARATOR . 'composer.lock');

        $result = $composerInfo->getHash();
        $this->assertSame('0237925805aa43707df01262464d6bd8', $result);
    }

    /**
     * Tests the minimum stability
     * @return void
     */
    public function testGetMinimumStability(): void
    {
        $composerInfo = new ComposerInfo(dirname(__DIR__) . DIRECTORY_SEPARATOR. 'assets' . DIRECTORY_SEPARATOR . 'composer.lock');

        $result = $composerInfo->getMinimumStability();
        $this->assertSame('stable', $result);
    }

    /**
     * Tests the packages collection
     * @return void
     */
    public function testGetPackages(): void
    {
        $composerInfo = new ComposerInfo(dirname(__DIR__) . DIRECTORY_SEPARATOR. 'assets' . DIRECTORY_SEPARATOR . 'composer.lock');

        $result = $composerInfo->getPackages();
        $this->assertInstanceOf('\ComposerLockParser\PackagesCollection', $result);
        $this->assertSame(33, count($result));
        $result = $composerInfo->getPackages($composerInfo::ALL);
        $this->assertInstanceOf('\ComposerLockParser\PackagesCollection', $result);
        $this->assertSame(33, count($result));
        $result = $composerInfo->getPackages($composerInfo::PRODUCTION);
        $this->assertInstanceOf('\ComposerLockParser\PackagesCollection', $result);
        $this->assertSame(1, count($result));
        $result = $composerInfo->getPackages($composerInfo::DEVELOPMENT);
        $this->assertInstanceOf('\ComposerLockParser\PackagesCollection', $result);
        $this->assertSame(32, count($result));
    }
}
