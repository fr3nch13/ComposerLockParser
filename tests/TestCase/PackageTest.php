<?php declare(strict_types=1);

namespace ComposerLockParser\Tests;

use ComposerLockParser\ComposerInfo;
use PHPUnit\Framework\TestCase;

/**
 * Tests src/Package.php
 */
final class PackageTest extends TestCase
{
    /**
     * @var \ComposerLockParser\ComposerInfo
     */
    private $ComposerInfo;
    /**
     * @var \ComposerLockParser\Package
     */
    private $Package;

    /**
     * Tests the parser
     * @return void
     */
    public function setUp(): void
    {
        $this->ComposerInfo = new ComposerInfo(dirname(__DIR__) . DIRECTORY_SEPARATOR. 'assets' . DIRECTORY_SEPARATOR . 'composer.lock');
        $Packages = $this->ComposerInfo->getPackages();
        $this->Package = $Packages[0];
    }

    /**
     * Tests package Name
     * @return void
     */
    public function testGetName(): void
    {
        $this->assertSame('t4web/composer-lock-parser', $this->Package->getName());
    }

    /**
     * Tests package Version
     * @return void
     */
    public function testGetVersion(): void
    {
        $this->assertSame('dev-updates', $this->Package->getVersion());
    }

    /**
     * Tests package Homepage
     * @return void
     */
    public function testGetHomepage(): void
    {
        $this->assertSame('https://github.com/t4web/ComposerLockParser', $this->Package->getHomepage());
    }

    /**
     * Tests package Source
     * @return void
     */
    public function testGetSource(): void
    {
        $this->assertSame([
            'type' => 'git',
            'url' => 'https://github.com/fr3nch13/ComposerLockParser.git',
            'reference' => '98844fe3c4b8f0c21f396aff88cca90b508f6f45'
        ], $this->Package->getSource());
    }

    /**
     * Tests package Dist
     * @return void
     */
    public function testGetDist(): void
    {
        $this->assertSame([
            'type' => 'zip',
            'url' => 'https://api.github.com/repos/fr3nch13/ComposerLockParser/zipball/98844fe3c4b8f0c21f396aff88cca90b508f6f45',
            'reference' => '98844fe3c4b8f0c21f396aff88cca90b508f6f45',
            'shasum' => '',
        ], $this->Package->getDist());
    }

    /**
     * Tests package Require
     * @return void
     */
    public function testGetRequire(): void
    {
        $this->assertSame([
            'php' => '>=5.4.0',
        ], $this->Package->getRequire());
    }

    /**
     * Tests package Require-dev
     * @return void
     */
    public function testGetRequireDev(): void
    {
        $this->assertSame([
            'codeception/codeception' => '<2',
        ], $this->Package->getRequireDev());
    }

    /**
     * Tests package Suggestions
     * @return void
     */
    public function testGeSuggest(): void
    {
        $this->assertSame([], $this->Package->getSuggest());
    }

    /**
     * Tests package Type
     * @return void
     */
    public function testGetType(): void
    {
        $this->assertSame('library', $this->Package->getType());
    }

    /**
     * Tests package Extra info
     * @return void
     */
    public function testGetExtra(): void
    {
        $this->assertSame([], $this->Package->getExtra());
    }

    /**
     * Tests package Autoload
     * @return void
     */
    public function testGetAutoload(): void
    {
        $this->assertSame([
            'psr-0' => [
                'ComposerLockParser\\' => 'src/',
            ],
        ], $this->Package->getAutoload());
    }

    /**
     * Tests package Notification URL
     * @return void
     */
    public function testGetNotificationUrl(): void
    {
        $this->assertSame('', $this->Package->getNotificationUrl());
    }

    /**
     * Tests package Namespace
     * @return void
     */
    public function testGetNamespace(): void
    {
        $this->assertSame('ComposerLockParser', $this->Package->getNamespace());
    }

    /**
     * Tests package License
     * @return void
     */
    public function testGetLicense(): void
    {
        $this->assertSame([
            'BSD-3-Clause',
        ], $this->Package->getLicense());
    }

    /**
     * Tests package Authors
     * @return void
     */
    public function testGetAuthors(): void
    {
        $this->assertSame([
            [
                'name' => 'Max Gulturyan',
                'email' => 'gulturyan@gmail.com',
                'homepage' => 'http://about.me/maxgu',
            ],
        ], $this->Package->getAuthors());
    }

    /**
     * Tests package Description
     * @return void
     */
    public function testGetDescription(): void
    {
        $this->assertSame('OOP reader of composer.lock file.', $this->Package->getDescription());
    }

    /**
     * Tests package Keywords
     * @return void
     */
    public function testGetKeywords(): void
    {
        $this->assertSame([
            'composer.lock reader',
        ], $this->Package->getKeywords());
    }

    /**
     * Tests package Time
     * @return void
     */
    public function testGetTime(): void
    {
        $this->assertInstanceOf(\DateTime::class, $this->Package->getTime());
    }
}
