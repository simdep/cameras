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

use App\Repository\FileRepository;
use App\Utils\LoadUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckFileCommand extends Command
{
    use LockableTrait;

    /**
     * The file repository.
     *
     * @var FileRepository
     */
    private $fileRepository;

    /**
     * Entity manager.
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

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
            ->setName('app:check:file')

            // the short description shown while running "php bin/console list"
            ->setDescription('Vérifie le nombre de colonnes de chaque fichier.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Cette commande regarde chaque fichier uCL téléchargé et compte les colonnes.')
        ;
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null null or 0 if everything went fine, or an error code
     *
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->lock()) {
            $output->writeln('<error>The command is already running in another process.</error>');

            return 1;
        }
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            '<info>Vérificateur lancé</info>',
            '<info>================</info>',
        ]);

        $directoryName = __DIR__.'/../../data/downloaded/';
        $directoryInfo = new \SplFileInfo($directoryName);

        if (!$directoryInfo->isDir()) {
            $output->writeln(sprintf('<error>%s n’est pas un répertoire</error>', $directoryName));
            return 2;
        }

        if (!$directoryInfo->isReadable()) {
            $output->writeln(sprintf('<error>Le répertoire %s n’est pas lisible</error>', $directoryName));
            return 3;
        }

        foreach (scandir($directoryName) as $subDirectory) {
            $subDirectoryInfo = new \SplFileInfo($directoryName.'/' . $subDirectory);


            //on élimine les répertoires qui ne commencent pas par camera-
            if ('camera-' !== substr($subDirectory,0,7)) {
                $output->writeln(sprintf('<comment>Sous-répertoire %s ignoré</comment>', $subDirectoryInfo->getFilename()));
                continue;
            }

            foreach (scandir($subDirectoryInfo) as $file) {
                $fileInfo = new \SplFileInfo($directoryName . '/' . $subDirectory . '/' . $file);

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
                $lignes = $this->loader->getLines($fileObject);
                $min = 9999;
                $max = 0;
                while ($lignes > 0 && !$fileObject->eof()) {
                    $csv = $fileObject->fgetcsv("\t");
                    if (empty($csv) || 1 === count($csv)) {
                        //fichier ou ligne vide
                        continue;
                    }
                    $columns = count($csv);
                    $min = min( $columns, $min);
                    $max = max( $columns, $max);
                }

                $output->writeln(sprintf('<info>Fichier %s/%s analysé (%d lignes, %d colonnes minimales, %d colonnes maximales).</info> ', $directoryName, $fileInfo->getFilename(), $lignes, $min, $max));
            }

            $output->writeln(sprintf('<comment>Mémoire consommée : %s</comment>', memory_get_usage()));

            //Fermeture du répertoire
            unset($directoryInfo);
        }
        $output->writeln('Fin du processus.');

        // if not released explicitly, Symfony releases the lock
        // automatically when the execution of the command ends
        $this->release();
        return 0;
    }
}
