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

use App\Entity\Camera;
use PHPUnit\Framework\TestCase;

/**
 * Class to test camera.
 */
class CameraTest extends TestCase
{
    /**
     * Camera instance to test.
     *
     * @var Camera
     */
    private $camera;

    public function setUp()
    {
        parent::setUp();

        $this->camera = new Camera();
    }

    /**
     * Test the active getter and setter.
     */
    public function testActive()
    {
        self::assertEquals($this->camera, $this->camera->setActive(true));
        self::assertTrue($this->camera->isActive());

        self::assertEquals($this->camera, $this->camera->setActive(false));
        self::assertFalse($this->camera->isActive());
    }

    /**
     * Test the code getter and setter.
     */
    public function testCode()
    {
        $expected = $actual = 'toto';

        self::assertEquals($this->camera, $this->camera->setCode($actual));
        self::assertEquals($expected, $this->camera->getCode());
    }

    /**
     * Test the constructor.
     */
    public function testConstructor()
    {
        self::assertNull($this->camera->getCode());
        self::assertNull($this->camera->getDirectory());
        self::assertNull($this->camera->getImageDirectory());
        self::assertNull($this->camera->getId());
        self::assertNull($this->camera->getIpCamera());
        self::assertNull($this->camera->getIpRouter());
        self::assertEquals(29, $this->camera->getMasque());
        self::assertNull($this->camera->getName());
        self::assertNull($this->camera->getSerialNumber());
        self::assertNull($this->camera->getType());
        self::assertNotNull($this->camera->getPassages());
        self::assertEmpty($this->camera->getPassages());
        self::assertTrue($this->camera->isActive());
        self::assertFalse($this->camera->isTest());
    }

    /**
     * Test the ip camera getter and setter.
     */
    public function testIpCamera()
    {
        $expected = $actual = 'toto';

        self::assertEquals($this->camera, $this->camera->setIpCamera($actual));
        self::assertEquals($expected, $this->camera->getIpCamera());

        $expected = 'http://toto:8000/meci-L1/discr/output/';
        self::assertEquals($expected, $this->camera->getDirectory());

        $expected = 'http://toto:8000/meci-L1/discr/images/';
        self::assertEquals($expected, $this->camera->getImageDirectory());
    }

    /**
     * Test the ip router getter and setter.
     */
    public function testIpRouter()
    {
        $expected = $actual = 'toto';

        self::assertEquals($this->camera, $this->camera->setIpRouter($actual));
        self::assertEquals($expected, $this->camera->getIpRouter());
    }

    /**
     * Test the name getter and setter.
     */
    public function testName()
    {
        $expected = $actual = 'toto';

        self::assertEquals($this->camera, $this->camera->setName($actual));
        self::assertEquals($expected, $this->camera->getName());
    }

    /**
     * Test the serial number getter and setter.
     */
    public function testSerialNumber()
    {
        $expected = $actual = 'toto';

        self::assertEquals($this->camera, $this->camera->setSerialNumber($actual));
        self::assertEquals($expected, $this->camera->getSerialNumber());
    }

    /**
     * Test the test getter and setter.
     */
    public function testTest()
    {
        self::assertEquals($this->camera, $this->camera->setTest(true));
        self::assertTrue($this->camera->isTest());

        self::assertEquals($this->camera, $this->camera->setTest(false));
        self::assertFalse($this->camera->isTest());
    }

    /**
     * Test the type getter and setter.
     */
    public function testType()
    {
        $expected = $actual = 'toto';

        self::assertEquals($this->camera, $this->camera->setType($actual));
        self::assertEquals($expected, $this->camera->getType());
    }

    /**
     * Test the masque getter and setter.
     */
    public function testMasque()
    {
        $expected = $actual = 42;

        self::assertEquals($this->camera, $this->camera->setMasque($actual));
        self::assertEquals($expected, $this->camera->getMasque());
    }
}
