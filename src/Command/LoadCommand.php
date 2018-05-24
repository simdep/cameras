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

use App\Entity\File;
use App\Entity\Passage;
use App\Repository\CameraRepository;
use App\Repository\FileRepository;
use App\Utils\LoadUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadCommand extends Command
{
    use LockableTrait;

    /**
     * Nombre de colonnes.
     */
    const COLUMN = 49;

    /**
     * Position des colonnes en commençant à zéro.
     */
    const C_TYPE = 0; //type
    const C_SN = 1; //SN
    const C_B = 2; //B
    const C_J = 3; //J
    const C_CREATED = 4; //T
    const C_INCREMENT = 5; //A
    const C_S = 6; //S
    const C_PLAQUE_COURT = 7; //P
    const C_PLAQUE_LONG = 8; //p
    const C_R = 9; //R
    const C_FIABILITE = 10; //f
    const C_COORD = 11; //c
    const C_H = 12; //H
    const C_PAYS = 13; //N
    const C_V = 14; //v
    const C_IMAGE = 15; //F
    const C_IMAGE_COULEUR = 16; //Fc
    const C_FRLV1 = 17; //flrv1
    const C_FRLV1C = 18; //flrv1c
    const C_FRLV2 = 19; //flrv2
    const C_FRLV2C = 20; //flrv2c
    const C_N = 21; //n
    const C_O = 22; //o
    const C_O2 = 23; //O
    const C_G = 24; //g
    const C_L = 25; //l
    const C_H2 = 26; //h
    const C_I = 27; //i
    const C_T = 28; //t
    const C_D = 29; //D
    const C_L2 = 30; //L
    const C_S2 = 31; //s
    const C_HEIGHT = 31; //height
    const C_LSD = 32; //lsd
    const C_SPEEDRNG = 33; //speedrng
    const C_K = 34; //k
    const C_LANE = 35; //lane
    const C_SPEEDEST = 36; //speedest
    const C_Q = 37; //q
    const C_BGMEAN = 38; //bgmean
    const C_FMEAN = 39; //fmean
    const C_EXP = 40; //exp
    const C_GAIN = 41; //gain
    const C_CREJECT = 42; //creject
    const C_RLVCREJ = 43; //rlvcrej
    const C_STOPLINE = 44; //stopline
    const C_RLVLOC = 45; //rlvLoc
    const C_VC = 46; //Vc
    const C_VRLVC = 47; //Vrlvc

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
    private $cameraRepository;

    /**
     * The file repository.
     *
     * @var FileRepository
     */
    private $fileRepository;

    /**
     * Loader service.
     *
     * @var LoadUtils
     */
    private $loader;

    /**
     * DownloadCommand constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param LoadUtils              $loader
     */
    public function __construct(EntityManagerInterface $entityManager, LoadUtils $loader)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->cameraRepository = $entityManager->getRepository('App:Camera');
        $this->fileRepository = $entityManager->getRepository('App:File');
        $this->loader = $loader;
    }

    /**
     * Configure the command.
     */
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:load')

            // the short description shown while running "php bin/console list"
            ->setDescription('Charge en base le contenu des fichiers téléchargées .')

            //Add an option for purge to purge database
            ->addOption('purge', 'p', InputArgument::OPTIONAL, 'Répondre y si vous voulez purger les données en base (y/n)', 'n')

            //Add an option for reload file already loaded
            ->addOption('overload', 'o', InputArgument::OPTIONAL, 'Répondre y si vous voulez recharger les fichiers déjà chargés (y/n)', 'n')

            //Add an option for reload file already loaded
            ->addOption('transaction', 't', InputArgument::OPTIONAL, 'Valider la transaction après chaque fichier, à la fin du processus ? (f/p)', 'f')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Cette commande charge en base le contenu des fichiers téléchargés.')
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
            $output->writeln('<error>The command is already running in another process.</error>');

            return 0;
        }
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            '<info>Loader lancé</info>',
            '<info>================</info>',
            '<info>Étape 1 : interrogation de la base de données pour déterminer le nombre de caméras...</info>',
            '<info>---------</info>',
        ]);

        $cameras = $this->cameraRepository->searchActive();
        $nCamera = count($cameras);

        if ($nCamera) {
            $output->writeln([
                "<comment>$nCamera caméras actives</comment>",
                '<info>Étape 2: Interrogations des fichiers à charger en base.</info>',
                '<info>--------</info>',
            ]);
        } else {
            $output->writeln('<error>Aucune caméra à interroger. Fin du processus.</error>');

            return;
        }

        //On débute une transaction
        if ('f' !== $input->getOption('transaction')) {
            $this->entityManager->beginTransaction();
        }

        foreach ($cameras as $camera) {
            $output->writeln(sprintf('<comment>Parcours des fichiers la caméra « %s »</comment>', $camera->getName()));
            $directoryname = __DIR__.'/../../data/downloaded/camera-'.$camera->getCode();
            $directoryInfo = new \SplFileInfo($directoryname);
            if (!$directoryInfo->isDir()) {
                $output->writeln(sprintf('<error>%s n’est pas un répertoire</error>', $directoryname));
                continue;
            }

            if (!$directoryInfo->isReadable()) {
                $output->writeln(sprintf('<error>Le répertoire %s n’est pas lisible</error>', $directoryname));
                continue;
            }

            //Parcours du répertoire
            foreach (scandir($directoryname) as $filename) {
                $fileInfo = new \SplFileInfo($directoryname.'/'.$filename);
                //on élimine silencieusement les répertoires
                if ($fileInfo->isDir()) {
                    $output->writeln(sprintf('<comment>Répertoire %s ignoré</comment>', $fileInfo->getFilename()));
                    continue;
                }

                //on ne garde que les fichiers csv
                if ('csv' !== $fileInfo->getExtension()) {
                    $output->writeln(sprintf('<comment>Fichier %s ignoré en raison de son extension inconnue</comment>', $fileInfo->getFilename()));
                    continue;
                }

                //Le fichier est vide
                if (0 === $fileInfo->getSize()) {
                    $output->writeln(sprintf('<info>Fichier %s vide et donc ignoré</info>', $fileInfo->getFilename()));
                    continue;
                }

                //Le fichier est-il lisible ?
                if (!$fileInfo->isReadable()) {
                    $output->writeln(sprintf('<error>Fichier %s ignoré, le fichier n’est pas autorisé à la lecture</error>.', $fileInfo->getFilename()));
                    continue;
                }

                $fileObject = $fileInfo->openFile('r');
                $output->write(sprintf('<comment>Fichier %s en cours d’analyse :</comment> ', $fileInfo->getFilename()));
                $index = 0;

                $empreinte = md5_file($fileInfo->getRealPath());
                $output->write(" $empreinte\n");
                if ($this->fileRepository->existsWithEmpreinte($empreinte)) {
                    if ('y' == $input->getOption('overload')) {
                        // FIXME purger tous les passages de ce fichier ???
                        die('cas non traité. Ne choisissez pas l’option overload pour le moment.');
                    } else {
                        $output->writeln(sprintf('<info>Fichier %s ignoré, ce fichier est déjà chargé en base de données.</info>', $fileInfo->getFilename()));
                        continue;
                    }
                }

                if ('f' === $input->getOption('transaction')) {
                    $this->entityManager->beginTransaction();
                }

                $fileEntity = new File();
                $fileEntity->setFilename($filename);
                $fileEntity->setDirectory('data/downloaded');
                $fileEntity->setMd5sum($empreinte);
                $this->entityManager->persist($fileEntity);

                $lignes = $this->loader->getLines($fileObject);
                $output->write(sprintf('<comment>Fichier %s en cours de chargement (%d lignes).</comment> ', $fileInfo->getFilename(), $lignes));

                //TODO Ajouter une progressbar
                //https://symfony.com/doc/current/components/console/helpers/progressbar.html
                // creates a new progress bar (50 units)
                $progressBar = new ProgressBar($output, $lignes);
                // starts and displays the progress bar
                $progressBar->start();

                while ($lignes > 0 && !$fileObject->eof()) {
                    $progressBar->advance();
                    $csv = $fileObject->fgetcsv("\t");
                    if (empty($csv) || 1 === count($csv)) {
                        //fichier ou ligne vide
                        continue;
                    }
                    if (0 === $index) {
                        //On passe l’entête.
                        ++$index;
                        continue;
                    }
                    if (self::COLUMN !== count($csv)) {
                        //On continue car on n'a pas le bon nombre de colonnes.
                        continue;
                    }

                    $passage = new Passage();
                    $passage
                        ->setCamera($camera)
                        ->setCoord($csv[self::C_COORD])
                        ->setCreated(new \DateTime(substr($csv[self::C_CREATED], 0, -3)))
                        ->setDataFictive(false)
                        ->setFiability($csv[self::C_FIABILITE])
                        ->setFile($fileEntity)
                        ->setH($csv[self::C_H])
                        ->setImmat($csv[self::C_PLAQUE_COURT])
                        ->setImmatriculation($csv[self::C_PLAQUE_LONG])
                        ->setIncrement($csv[self::C_INCREMENT])
                        ->setR((int) $csv[self::C_R])
                        ->setS((int) $csv[self::C_S])
                        ->setState($csv[self::C_PAYS]);
                    $this->entityManager->persist($passage);
                    $this->entityManager->flush();
                    $output->write('.');
                    unset($passage,$csv);
                }
                //Fermeture du fichier
                unset($fileEntity, $fileObject, $empreinte, $lignes);
                $progressBar->finish();
                $output->writeln("\n");
                if ('f' === $input->getOption('transaction')) {
                    // Validation pour chaque fichier
                    $output->writeln('<info>Validation de la transaction.</info>');
                    $this->entityManager->commit();
                }
            }
            // Validation de l'ensemble du processus
            if ('f' !== $input->getOption('transaction')) {
                $output->writeln('<info>Validation de la transaction.</info>');
                $this->entityManager->commit();
            }
            $output->writeln(sprintf('<comment>Mémoire consommée : %s</comment>', memory_get_usage()));

            //Fermeture du répertoire
            unset($directoryInfo, $directoryname);
        }
        $output->writeln('Fin du processus.');

        // if not released explicitly, Symfony releases the lock
        // automatically when the execution of the command ends
        $this->release();
    }
}
