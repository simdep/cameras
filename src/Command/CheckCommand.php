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

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckCommand extends Command
{
    use LockableTrait;

    /**
     * Configure the command.
     */
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:check:mmr')

            // the short description shown while running "php bin/console list"
            ->setDescription('Vérifie que toutes les images des caméras sont passées au MMR et ont un fichier JSON.')

            //Add an option for purge to purge database
            ->addOption('directory', 'd', InputArgument::OPTIONAL , 'Répertoire à analyser', '.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Cette commande vérifie que pour chaque image, on est bien un fichier json généré par le MMR.')
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
            $output->writeln('<error>Le processus est déjà en cours d’exécution.</error>');

            return 1;
        }

        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            sprintf('<info>Vérificateur lancé à %s</info>', strftime('%c')),
            '<info>====================================</info>',
        ]);

        $directoryName = $input->getOption('directory');
        $directoryInfo = new \SplFileInfo($directoryName);

        if (!$directoryInfo->isDir()) {
            $output->writeln(sprintf('<error>%s n’est pas un répertoire</error>', $directoryName));
            return 2;
        }

        if (!$directoryInfo->isReadable()) {
            $output->writeln(sprintf('<error>Le répertoire %s n’est pas lisible</error>', $directoryName));
            return 3;
        }

        $output->writeln(sprintf('<info>Analyse du répertoire %s</info>', $directoryInfo));

        foreach (array_diff(scandir($directoryInfo),[".",".."]) as $subDirectory) {
            $subDirectoryInfo = new \SplFileInfo($directoryName.'/' . $subDirectory);
            if (!$subDirectoryInfo->isDir()) {
                continue;
            }

            $subDirectories = array_filter(scandir($subDirectoryInfo), [CheckCommand::class, "isImageDirectory"]);

            if (0 === count($subDirectories)) {
                $output->writeln(sprintf('<error>Aucun sous-répertoire horodaté sous %s</error>', $subDirectory));
                return 3;
            }

            foreach ($subDirectories as $imageDirectory) {
                $imageDirectoryInfo = new \SplFileInfo("$directoryName/$subDirectory/$imageDirectory");

                if (!$imageDirectoryInfo->isDir()) {
                    continue;
                }

                if (!$imageDirectoryInfo->isReadable()) {
                    $output->writeln(sprintf('<error>%s : Répertoire non lisible</error>', $directoryName));
                    continue;
                }

                $allFiles = scandir($imageDirectoryInfo);
                $jpgFiles = array_map([CheckCommand::class, "removeJpg"], array_filter($allFiles, [CheckCommand::class, "isImage"]));
                if (0 === count($jpgFiles)) {
                    $output->writeln(sprintf('<error>%s : Aucune image.</error>', $imageDirectoryInfo));
                    continue;
                }

                $jsonFiles = array_map([CheckCommand::class,"removeJson"], array_filter($allFiles, [CheckCommand::class, "isJson"]));
                if (0 === count($jsonFiles)) {
                    $output->writeln(sprintf('<error>%s : Aucun fichier MMR.</error>', $imageDirectoryInfo));
                    continue;
                }

                if (count($jsonFiles) === count($jpgFiles)) {
                    $output->writeln(sprintf('<info>%s : OK : intégralement traité.</info>', $imageDirectoryInfo));
                    continue;
                } else {
                    $output->writeln(sprintf('<error>%s : %s images et %s fichiers MMR.</error>',count($jpgFiles), count($jsonFiles) ));
                }
            }
        }
        $output->writeln('Fin du processus.');

        // if not released explicitly, Symfony releases the lock
        // automatically when the execution of the command ends
        $this->release();
        return 0;

    }

    /**
     * Détermine s'il s'agit d'un répertoire d'image des caméras LAPI.
     *
     * @param $directory
     * @return bool
     */
    static private function isImageDirectory($directory): bool
    {
        return 1 === preg_match( "/^[0-9]{10}E$/", $directory);
    }

    /**
     * Détermine s'il s'agit d'une image non colorisée.
     *
     * @param $directory
     * @return bool
     */
    static private function isImage($directory): bool
    {
        return 1 === preg_match("/\.jpg$/", $directory) && 0 === preg_match("/-colour-/", $directory) ;
    }

    /**
     * Détermine s'il s'agit d'un fichier JSON.
     *
     * @param $directory
     * @return bool
     */
    static private function isJson($directory): bool
    {
        return 1 === preg_match("/\.json$/", $directory);
    }

    static private function removeJpg($filename): string
    {
        return substr($filename, 0, -4);
    }

    static private function removeJson($filename): string
    {
        return substr($filename, 0, -5);
    }
}
