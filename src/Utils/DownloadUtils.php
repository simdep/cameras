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

namespace App\Utils;
use App\Exception\DownloadException;

/**
 * Outils pour faciliter le téléchargement
 */
class DownloadUtils
{
    /**
     * Ouvre un fichier distant, en récupère la liste de tous les fichiers disponibles.
     *
     * @param string $directory
     *
     * @return array
     *
     * @throws DownloadException
     */
    public static function getFiles(string $directory): array
    {
        //FIXME implement it
        return [
            'toto' => 'url de toto',
            'titi' => 'url de titi',
        ];
    }

    /**
     * Télécharge un fichier de passage et anonymise à la volée les plaques d'immatriculation.
     *
     * @param $file
     *
     * @return int
     *
     * @throws DownloadException
     */
    public static function downloadFile($file): int
    {
        //FIXME implement it
        return 42;
    }
}
