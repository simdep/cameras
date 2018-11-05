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
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DownloadCommand extends Command
{
    use LockableTrait;

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
     * Downloader service.
     *
     * @var DownloadUtils
     */
    private $downloader;

    /**
     * DownloadCommand constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param DownloadUtils          $downloader
     */
    public function __construct(EntityManagerInterface $entityManager, DownloadUtils $downloader)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository('App:Camera');
        $this->downloader = $downloader;
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
            ->setDescription('Télécharge et crypte les fichiers d’immatriculations pour les caméras actives.')

            //configure option for day to download
            ->addOption('day', 'd', InputArgument::OPTIONAL, 'Journée à récupérer (all, nottoday, today, yesterday)', 'yesterday')

            //Add an option for image to download
            ->addOption('image', 'i', InputArgument::OPTIONAL, 'Mettre à true si vous voulez forcer le téléchargement des images. ATTENTION à la bande passante', false)

            //Add an option to override files
            ->addOption('override', 'o', InputArgument::OPTIONAL, 'Mettre à true si vous voulez écraser les fichiers déjà existants', false)

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Cette commande télécharge, par défaut, tous les fichiers de la veille des caméras déclarées actives dans la base de données. Les immatriculations sont aussitôt cryptées. Les fichiers déjà téléchargés ne sont pas retéléchargés par défaut. Les options permettent de personnaliser les téléchargements.')
        ;
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     *
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->lock()) {
            $output->writeln('<error>La commande tourne déjà dans un autre processus.</error>');

            return;
        }

        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Downloader lancé' . strftime("%c"),
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
            $output->writeln(sprintf('Interrogation de la caméra « %s »', $camera->getName()));

            if ('all' == $input->getOption('day')) {
                $output->writeln([
                    sprintf('Interrogation de la caméra « %s »', $camera->getName()),
                    '    Interrogation de son répertoire de téléchargement : ' . $camera->getDirectory(),
                ]);
                //Try to retrieve an array of files to download
                try {
                    $files = $this->downloader->getFiles($camera->getDirectory());
                } catch (DownloadException $e) {
                    $output->writeln('Erreur à la lecture du répertoire : ' . $e->getMessage());
                    continue;
                }
            }
            elseif ('nottoday' == $input->getOption('day')) {
                $output->writeln([
                    sprintf('Interrogation de la caméra « %s »', $camera->getName()),
                    '    Interrogation de son répertoire de téléchargement : '.$camera->getDirectory(),
                ]);
                //Try to retrieve an array of files to download
                try {
                    $files = $this->downloader->getFiles($camera->getDirectory());
                    //Suppress last day (today)
                    array_pop($files);
                } catch (DownloadException $e) {
                    $output->writeln('Erreur à la lecture du répertoire : '.$e->getMessage());
                    continue;
                }
            }
            elseif ('today' == $input->getOption('day')) {
                $today = new \DateTime();
                $cle = 'ucL1'.$today->format('Y_m_d');
                $files[$cle] = $camera->getDirectory().$cle;
            } else {
                $yesterday = new \DateTime();
                $yesterday->sub(new \DateInterval('P1D'));
                $cle = 'ucL1'.$yesterday->format('Y_m_d');
                $files[$cle] = $camera->getDirectory().$cle;
            }

            $output->writeln(sprintf('    %d fichier(s) à télécharger.', count($files)));
            foreach ($files as $key => $file) {
                $output->writeln(sprintf('        Lecture du fichier « %s » de la caméra « %s »', $key, $camera->getName()));
                try {
                    $lines = $this->downloader->downloadFile($file, $camera->getCode(), $input->getOption('override'));
                    $output->writeln(sprintf('           %s passages anonymisés et récupérées', count($lines)));
                } catch (DownloadException $e) {
                    $output->writeln('Erreur : '.$e->getMessage());
                    continue;
                }

                if ('true' == $input->getOption('image')) {
                    $output->writeln(sprintf('           Nombre de paires d’images à télécharger : %d', count($lines)));
                    foreach ($lines as $images) {
                        foreach ($images as $image) {
                            $result = $this->downloader->downloadImage($image, $camera->getCode(), $camera->getImageDirectory());
                            if (null === $result) {
                                $message = 'S';
                            } else {
                                $message = $result ? 'D' : 'E';
                            }

                            $output->write($message);
                        }
                    }
                    $output->writeln('');
                }
            }
        }
        $output->writeln('Fin du processus.');

        // if not released explicitly, Symfony releases the lock
        // automatically when the execution of the command ends
        $this->release();
    }
}
