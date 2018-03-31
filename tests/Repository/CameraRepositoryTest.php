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

namespace App\Tests\Repository;

use App\DataFixtures\CameraFixtures;
use App\Repository\CameraRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CameraRepositoryTest extends KernelTestCase
{
    /**
     * The entity manager.
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * The repository to test.
     *
     * @var CameraRepository
     */
    private $repository;

    /**
     * Boots the Kernel for each test.
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->repository = $this->entityManager->getRepository('App:Camera');
    }

    /**
     * Test the search active method.
     */
    public function testSearchActive()
    {
        $cameras = $this->repository
            ->searchActive()
        ;

        $this->assertCount(CameraFixtures::ACTIVES, $cameras);
    }

    /**
     * Test the search inactive method.
     */
    public function testSearchInactive()
    {
        $cameras = $this->repository
            ->searchInactive()
        ;

        $this->assertCount(CameraFixtures::INACTIVES, $cameras);
    }

    /**
     * Clean up Kernel usage in this test.
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}
