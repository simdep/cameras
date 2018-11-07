<?php
/*
 * This file is part of the GMAO Application.
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Utils;

use App\Exception\LoadException;

class Csv
{
    /**
     * Position des colonnes en commençant à zéro pour un fichier de 49 colonnes (ou 50).
     */
    const C_49_TYPE = 0; //type
    const C_49_SN = 1; //SN
    const C_49_B = 2; //B
    const C_49_J = 3; //J
    const C_49_CREATED = 4; //T
    const C_49_INCREMENT = 5; //A
    const C_49_S = 6; //S
    const C_49_PLAQUE_COURT = 7; //P
    const C_49_PLAQUE_LONG = 8; //p
    const C_49_R = 9; //R
    const C_49_FIABILITE = 10; //f
    const C_49_COORD = 11; //c
    const C_49_H = 12; //H
    const C_49_PAYS = 13; //N
    const C_49_V = 14; //v
    const C_49_IMAGE = 15; //F
    const C_49_IMAGE_COULEUR = 16; //Fc
    const C_49_FRLV1 = 17; //flrv1
    const C_49_FRLV1C = 18; //flrv1c
    const C_49_FRLV2 = 19; //flrv2
    const C_49_FRLV2C = 20; //flrv2c
    const C_49_N = 21; //n
    const C_49_O = 22; //o
    const C_49_O2 = 23; //O
    const C_49_G = 24; //g
    const C_49_NATURE_VEHICULE = 25; //l
    const C_49_H2 = 26; //h
    const C_49_I = 27; //i
    const C_49_T = 28; //t
    const C_49_D = 29; //D
    const C_49_L2 = 30; //L
    const C_49_S2 = 31; //s
    const C_49_HEIGHT = 31; //height
    const C_49_LSD = 32; //lsd
    const C_49_SPEEDRNG = 33; //speedrng
    const C_49_K = 34; //k
    const C_49_LANE = 35; //lane
    const C_49_SPEEDEST = 36; //speedest
    const C_49_Q = 37; //q
    const C_49_BGMEAN = 38; //bgmean
    const C_49_FMEAN = 39; //fmean
    const C_49_EXP = 40; //exp
    const C_49_GAIN = 41; //gain
    const C_49_CREJECT = 42; //creject
    const C_49_RLVCREJ = 43; //rlvcrej
    const C_49_STOPLINE = 44; //stopline
    const C_49_RLVLOC = 45; //rlvLoc
    const C_49_VC = 46; //Vc
    const C_49_VRLVC = 47; //Vrlvc
    const C_49_PLAQUE_COLLISION = 48; //Vrlvc

    /**
     * Position des colonnes en commençant à zéro pour un fichier de 44 colonnes ou 45 colonnes.
     */
    const C_44_TYPE = 0; //type
    const C_44_B = 1; //B
    const C_44_J = 2; //J
    const C_44_CREATED = 3; //T
    const C_44_INCREMENT = 4; //A
    const C_44_S = 5; //S
    const C_44_PLAQUE_COURT = 6; //P
    const C_44_PLAQUE_LONG = 7; //p
    const C_44_R = 8; //R
    const C_44_FIABILITE = 9; //f
    const C_44_COORD = 10; //c
    const C_44_H = 11; //H
    const C_44_PAYS = 12; //N
    const C_44_V = 13; //v
    const C_44_IMAGE = 14; //F
    const C_44_IMAGE_COULEUR = 15; //Fc
    const C_44_N = 16; //n
    const C_44_O = 17; //o
    const C_44_O2 = 18; //O
    const C_44_G = 19; //g
    const C_44_NATURE_VEHICULE = 20; //l
    const C_44_H2 = 21; //h
    const C_44_I = 22; //i
    const C_44_T = 23; //t
    const C_44_D = 24; //D
    const C_44_L2 = 25; //L
    const C_44_S2 = 26; //s
    const C_44_HEIGHT = 27; //height
    const C_44_LSD = 28; //lsd
    const C_44_SPEEDRNG = 29; //speedrng
    const C_44_K = 30; //k
    const C_44_LANE = 31; //lane
    const C_44_SPEEDEST = 32; //speedest
    const C_44_Q = 33; //q
    const C_44_BGMEAN = 34; //bgmean
    const C_44_FMEAN = 35; //fmean
    const C_44_EXP = 36; //exp
    const C_44_GAIN = 37; //gain
    const C_44_CREJECT = 38; //creject
    const C_44_RLVCREJ = 39; //rlvcrej
    const C_44_STOPLINE = 40; //stopline
    const C_44_RLVLOC = 41; //rlvLoc
    const C_44_VC = 42; //Vc
    const C_44_VRLVC = 43; //Vrlvc
    const C_44_PLAQUE_COLLISION = 44; //Vrlvc

    /**
     * @param string $column
     * @param int    $columns
     *
     * @return int
     *
     * @throws LoadException
     */
    public static function getColumn(string $column, int $columns = 45)
    {
        switch ($column) {
            case 'coord':
                return Csv::is4445($columns) ? self::C_44_COORD : self::C_49_COORD;
            case 'created':
                return Csv::is4445($columns) ? self::C_44_CREATED : self::C_49_CREATED;
            case 'fiability':
                return Csv::is4445($columns) ? self::C_44_FIABILITE : self::C_49_FIABILITE;
            case 'h':
                return Csv::is4445($columns) ? self::C_44_H : self::C_49_H;
            case 'image':
                return Csv::is4445($columns) ? self::C_44_IMAGE : self::C_49_IMAGE;
            case 'plaque_collision':
                return Csv::getPlaqueCollision($columns);
            case 'plaque_court':
                return Csv::is4445($columns) ? self::C_44_PLAQUE_COURT : self::C_49_PLAQUE_COURT;
            case 'plaque_long':
                return Csv::is4445($columns) ? self::C_44_PLAQUE_LONG : self::C_49_PLAQUE_LONG;
            case 'increment':
                return Csv::is4445($columns) ? self::C_44_INCREMENT : self::C_49_INCREMENT;
            case 'nature_vehicule':
                return Csv::is4445($columns) ? self::C_44_NATURE_VEHICULE : self::C_49_NATURE_VEHICULE;
            case 'r':
                return Csv::is4445($columns) ? self::C_44_R : self::C_49_R;
            case 's':
                return Csv::is4445($columns) ? self::C_44_S : self::C_49_S;
            case 'pays':
                return Csv::is4445($columns) ? self::C_44_PAYS : self::C_49_PAYS;
            default:
                throw new LoadException('Code inconnu :'.$column);
        }
    }

    /**
     * Retourne vrai si 44 ou 45 colonnes.
     *
     * @param $columns
     *
     * @return bool
     */
    private static function is4445($columns): bool
    {
        return 45 == $columns || 44 == $columns;
    }

    /**
     * Retourne la colonne de la plaque d'immatriculation simplifiée ou la plaque courte si je n'ai pas pu le simplifier.
     *
     * @param $columns
     *
     * @return int
     */
    private static function getPlaqueCollision($columns): int
    {
        switch ($columns) {
            case 44:
                return self::C_44_PLAQUE_COURT;
            case 45:
                return self::C_44_PLAQUE_COLLISION;
            case 49:
                return self::C_49_PLAQUE_COURT;
            default:
                return self::C_49_PLAQUE_COLLISION;
        }
    }
}
