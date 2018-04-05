<?php
/**
 * This file is part of the LAPI application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @license   MIT
 *
 * @see https://github.com/Alexandre-T/casguard/blob/master/LICENSE
 */

namespace App\Tests;

use App\Command\DownloadCommand;
use App\Entity\Camera;
use App\Repository\CameraRepository;
use App\Utils\DownloadUtils;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class to test download command.
 */
class DownloadCommandTest extends KernelTestCase
{
    /**
     * Download command instance to test.
     *
     * @var DownloadCommand
     */
    private $downloadCommand;

    /**
     * Download service mocked.
     *
     * @var DownloadUtils|MockObject
     */
    private $downloader;

    /**
     * Entity manager mocked.
     *
     * @var EntityManagerInterface|MockObject
     */
    private $entityManager;

    /**
     * Camera repository mocked.
     *
     * @var CameraRepository|MockObject
     */
    private $repository;

    /**
     * Application from kernel test case.
     *
     * @var Application
     */
    private $application;

    public function setUp()
    {
        parent::setUp();

        $this->repository = self::getMockBuilder(CameraRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->entityManager = self::getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        //FIXME self::any must be replaced by self::once()
        $this->entityManager->expects(self::any())
            ->method('getRepository')
            ->with('App:Camera')
            ->willReturn($this->repository);

        $this->downloader = self::getMockBuilder(DownloadUtils::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->downloadCommand = new DownloadCommand($this->entityManager, $this->downloader);

        $kernel = self::bootKernel();
        $this->application = new Application($kernel);

        $this->application->add(new DownloadCommand($this->entityManager, $this->downloader));
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->application = null; // avoid memory leaks
        $this->downloadCommand = null; // avoid memory leaks
        $this->entityManager = null; // avoid memory leaks
        $this->repository = null; // avoid memory leaks
    }

    /**
     * Test execute protected method when there is no camera.
     */
    public function testExecuteWithoutActiveCamera()
    {
        $command = $this->application->find('app:download');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),

            // pass arguments to the helper
            //'username' => 'Wouter',

            // prefix the key with two dashes when passing options,
            // e.g: '--some-option' => 'option_value',
        ));

        // the output of the command in the console
        $output = $commandTester->getDisplay();

        //Assertion tests
        $this->assertContains('Downloader lancé', $output);
        $this->assertContains('Aucune caméra à interroger', $output);
        $this->assertContains('Fin du processus', $output);
    }

    /**
     * Test execute protected method when there is no camera.
     */
    public function testExecuteWith4ActiveCamera()
    {
        //Preparation des 4 caméras retournées par la base de données (mock)
        /** @var Camera[] $cameras */
        $cameras = [];

        for ($index = 0; $index < 4; ++$index) {
            $cameras[$index] = new Camera();
            $cameras[$index]->setName("Caméra $index");
            $cameras[$index]->setCode("cam-$index");
            $cameras[$index]->setActive(true);
            $cameras[$index]->setIpCamera("non-existent-ip$index");
        }

        $this->repository
            ->expects(self::once())
            ->method('searchActive')
            ->willReturn($cameras);

        //Le lecteur de répertoire va retourner 0 fichier, puis 1 puis 2 puis 2
        $file['foo'] = 'bar';
        $files['foo'] = 'bar';
        $files['bar'] = 'foo';

        $this->downloader
            ->expects(self::exactly(4))
            ->method('getFiles')
            ->withConsecutive(
                self::equalTo('http://non-existent-ip0:8000/meci-L1/discr/output/'),
                self::equalTo('http://non-existent-ip1:8000/meci-L1/discr/output/'),
                self::equalTo('http://non-existent-ip2:8000/meci-L1/discr/output/'),
                self::equalTo('http://non-existent-ip3:8000/meci-L1/discr/output/')
            )
            ->willReturn(
                [], // Premier appel on renvoie vide
                $file, //Second appel on renvoie file
                $files, //Second appel on renvoie file
                $files //Second appel on renvoie file
            );

        //Le downloader va récupérer 7, 9, 13, 23, 42 lignes
        $this->downloader
            ->expects(self::exactly(5))
            ->method('downloadFile')
            ->willReturn(
                7,
                9,
                13,
                23,
                42
            );

        $command = $this->application->find('app:download');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName(),

            // pass arguments to the helper
            //'username' => 'Wouter',

            // prefix the key with two dashes when passing options,
            // e.g: '--some-option' => 'option_value',
        ));

        // the output of the command in the console
        $output = $commandTester->getDisplay();

        //Assertion tests
        $this->assertContains('Downloader lancé', $output);
        $this->assertContains('4 caméras actives et à interroger', $output);
        $this->assertContains('Interrogation de la caméra « Caméra 0 »', $output);
        $this->assertContains('Interrogation de la caméra « Caméra 1 »', $output);
        $this->assertContains('Interrogation de la caméra « Caméra 2 »', $output);
        $this->assertContains('Interrogation de la caméra « Caméra 3 »', $output);
        $this->assertContains('0 fichiers à télécharger', $output);
        $this->assertContains('1 fichiers à télécharger', $output);
        $this->assertContains('2 fichiers à télécharger', $output);
        $this->assertContains('Lecture du fichier « foo » de la caméra « Caméra 1 »', $output);
        $this->assertContains('Lecture du fichier « foo » de la caméra « Caméra 2 »', $output);
        $this->assertContains('Lecture du fichier « bar » de la caméra « Caméra 2 »', $output);
        $this->assertContains('Lecture du fichier « foo » de la caméra « Caméra 3 »', $output);
        $this->assertContains('Lecture du fichier « bar » de la caméra « Caméra 3 »', $output);
        $this->assertContains('7 passages anonymisés et récupérées', $output);
        $this->assertContains('9 passages anonymisés et récupérées', $output);
        $this->assertContains('13 passages anonymisés et récupérées', $output);
        $this->assertContains('23 passages anonymisés et récupérées', $output);
        $this->assertContains('42 passages anonymisés et récupérées', $output);
        $this->assertContains('Fin du processus', $output);
    }
}
