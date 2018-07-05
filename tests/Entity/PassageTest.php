<?php
/**
 * This passage is part of the LAPI application.
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

use App\Entity\Camera;
use App\Entity\File;
use App\Entity\Passage;
use PHPUnit\Framework\TestCase;

/**
 * Class to test passage.
 */
class PassageTest extends TestCase
{
    /**
     * Passage instance to test.
     *
     * @var Passage
     */
    private $passage;

    public function setUp()
    {
        parent::setUp();

        $this->passage = new Passage();
    }

    /**
     * Test the constructor.
     */
    public function testConstructor()
    {
        self::assertNull($this->passage->getId());
        self::assertNull($this->passage->getCamera());
        self::assertNull($this->passage->getCoord());
        self::assertNull($this->passage->getCreated());
        self::assertNull($this->passage->getFiability());
        self::assertNull($this->passage->getFile());
        self::assertNull($this->passage->getImage());
        self::assertNull($this->passage->getImmat());
        self::assertNull($this->passage->getImmatriculation());
        self::assertNull($this->passage->getIncrement());
        self::assertNull($this->passage->getH());
        self::assertNull($this->passage->getR());
        self::assertNull($this->passage->getS());
        self::assertNull($this->passage->getState());
    }

    /**
     * Test camera getter and setter.
     */
    public function testCamera()
    {
        $expected = $actual = new Camera();

        self::assertEquals($this->passage, $this->passage->setCamera($actual));
        self::assertEquals($expected, $this->passage->getCamera());
    }

    /**
     * Test coord getter and setter.
     */
    public function testCoord()
    {
        $expected = $actual = 'toto';

        self::assertEquals($this->passage, $this->passage->setCoord($actual));
        self::assertEquals($expected, $this->passage->getCoord());
    }

    /**
     * Test created getter and setter.
     */
    public function testCreated()
    {
        $expected = $actual = new \DateTime();

        self::assertEquals($this->passage, $this->passage->setCreated($actual));
        self::assertEquals($expected, $this->passage->getCreated());
    }

    /**
     * Test fiability getter and setter.
     */
    public function testFiability()
    {
        $expected = $actual = 42;

        self::assertEquals($this->passage, $this->passage->setFiability($actual));
        self::assertEquals($expected, $this->passage->getFiability());
    }

    /**
     * Test file getter and setter.
     */
    public function testFile()
    {
        $expected = $actual = new File();

        self::assertEquals($this->passage, $this->passage->setFile($actual));
        self::assertEquals($expected, $this->passage->getFile());
    }

    /**
     * Test image getter and setter.
     */
    public function testImage()
    {
        $expected = $actual = 'toto';

        self::assertEquals($this->passage, $this->passage->setImage($actual));
        self::assertEquals($expected, $this->passage->getImage());
    }
    
    /**
     * Test immat getter and setter.
     */
    public function testImmat()
    {
        $expected = $actual = 'toto';

        self::assertEquals($this->passage, $this->passage->setImmat($actual));
        self::assertEquals($expected, $this->passage->getImmat());
    }

    /**
     * Test immatriculation getter and setter.
     */
    public function testImmatriculation()
    {
        $expected = $actual = 'toto';

        self::assertEquals($this->passage, $this->passage->setImmatriculation($actual));
        self::assertEquals($expected, $this->passage->getImmatriculation());
    }

    /**
     * Test increment getter and setter.
     */
    public function testIncrement()
    {
        $expected = $actual = 42;

        self::assertEquals($this->passage, $this->passage->setIncrement($actual));
        self::assertEquals($expected, $this->passage->getIncrement());
    }

    /**
     * Test h getter and setter.
     */
    public function testH()
    {
        $expected = $actual = 42;

        self::assertEquals($this->passage, $this->passage->setH($actual));
        self::assertEquals($expected, $this->passage->getH());
    }

    /**
     * Test r getter and setter.
     */
    public function testR()
    {
        $expected = $actual = 42;

        self::assertEquals($this->passage, $this->passage->setR($actual));
        self::assertEquals($expected, $this->passage->getR());
    }

    /**
     * Test s getter and setter.
     */
    public function testS()
    {
        $expected = $actual = 42;

        self::assertEquals($this->passage, $this->passage->setS($actual));
        self::assertEquals($expected, $this->passage->getS());
    }

    /**
     * Test state getter and setter.
     */
    public function testState()
    {
        $expected = $actual = 'toto';

        self::assertEquals($this->passage, $this->passage->setState($actual));
        self::assertEquals($expected, $this->passage->getState());
    }
}
