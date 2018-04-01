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

namespace App\Command;

use App\Exception\DownloadException;
use App\Repository\CameraRepository;
use App\Utils\DownloadUtils;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DownloadCommand extends Command
{
    /**
     * The object manager.
     *
     * @var ObjectManager
     */
    private $manager;

    /**
     * The entity manager.
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * The camera repository.
     *
     * @var CameraRepository
     */
    private $repository;

    /**
     * DownloadCommand constructor.
     *
     * @param ObjectManager          $manager
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ObjectManager $manager, EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->manager = $manager;
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository('App:Camera');
    }

    /**
     * Configure the command.
     */
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:download')

            // the short description shown while running "php bin/console list"
            ->setDescription('Download and hash available files from active cameras.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command downloads all available files from active cameras. Immatriculation are immediately hashed.')
        ;
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Downloader lancé',
            '================',
            'Étape 1 : interrogation de la base de données pour déterminer le nombre de caméras ...',
            '---------',
        ]);

        $cameras = $this->repository->searchActive();
        $nCamera = count($cameras);

        if ($nCamera) {
            $output->writeln([
                "$nCamera caméras actives et à interroger",
                'Étape 2: Interrogations des caméras et anonymisation des plaques.',
                '--------',
            ]);
        } else {
            $output->writeln('Aucune caméra à interroger. Fin du processus.');
        }

        foreach ($cameras as $camera) {
            $output->writeln([
                sprintf('Interrogation de la caméra « %s »', $camera->getName()),
                '    Interrogation de son répertoire de téléchargement : '.$camera->getDirectory(),
            ]);
            //Try to retrieve an array of files to download
            try {
                $files = DownloadUtils::getFiles($camera->getDirectory());
            } catch (DownloadException $e) {
                $output->writeln('Erreur à la lecture du répertoire : '.$e->getMessage());
                continue;
            }

            $output->writeln(sprintf('    %s fichiers à télécharger.', count($files)));
            foreach ($files as $key => $file) {
                $output->writeln(sprintf('        Lecture du fichier « %s » de la caméra « %s »', $key, $camera->getName()));
                try {
                    $lines = DownloadUtils::downloadFile($file);
                    $output->writeln(sprintf('           %s passages anonymisés et récupérées', $lines));
                } catch (DownloadException $e) {
                    $output->writeln('Erreur à la lecture du fichier : '.$e->getMessage());

                }
            }
        }
        $output->writeln('Fin du processus.');
    }
}
