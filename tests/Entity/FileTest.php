<?php
/**
 * This file is part of the LAPI application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Entity
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license   MIT
 *
 * @see https://github.com/Alexandre-T/casguard/blob/master/LICENSE
 */

namespace App\Tests;

use App\Entity\File;
use PHPUnit\Framework\TestCase;

/**
 * Class to test file.
 */
class FileTest extends TestCase
{
    /**
     * File instance to test.
     *
     * @var File
     */
    private $file;

    public function setUp()
    {
        parent::setUp();

        $this->file = new File();
    }

    /**
     * Test the constructor.
     */
    public function testConstructor()
    {
        self::assertNull($this->file->getId());
        self::assertNull($this->file->getDirectory());
        self::assertNull($this->file->getFilename());
        self::assertNull($this->file->getMd5sum());
    }

    /**
     * Test directory getter and setter.
     */
    public function testDirectory()
    {
        $expected = $actual = 'toto';

        self::assertEquals($this->file, $this->file->setDirectory($actual));
        self::assertEquals($expected, $this->file->getDirectory());
    }

    /**
     * Test filename getter and setter.
     */
    public function testFilename()
    {
        $expected = $actual = 'toto';

        self::assertEquals($this->file, $this->file->setFilename($actual));
        self::assertEquals($expected, $this->file->getFilename());
    }

    /**
     * Test md5sum getter and setter.
     */
    public function testMd5sum()
    {
        $expected = $actual = 'toto';

        self::assertEquals($this->file, $this->file->setMd5sum($actual));
        self::assertEquals($expected, $this->file->getMd5sum());
    }
}
