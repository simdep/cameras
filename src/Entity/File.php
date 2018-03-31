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

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fichier importé et anonymisé récupéré sur la caméra par l'importateur.
 *
 * @ORM\Entity(repositoryClass="App\Repository\FileRepository")
 * @ORM\Table(
 *     name="te_file",
 *     schema="data",
 *     indexes={@ORM\Index(name="ndx_file_md5_sum", columns={"md5sum"})},
 *     uniqueConstraints={@ORM\UniqueConstraint(name="ndx_file_name", columns={"directory","filename"})}
 * )
 */
class File
{
    /**
     * Identifiant primaire du fichier.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    private $id;

    /**
     * Repertoire relatif à data/import de stockage des fichiers.
     *
     * @ORM\Column(type="string", nullable=false, options={"default":"."})
     *
     * @var int
     */
    private $directory;

    /**
     * Nom du fichier.
     *
     * @ORM\Column(type="string", length=16, nullable=false)
     *
     * @var string
     */
    private $filename;

    /**
     * Code MD5 du fichier pour garantir sa non modification.
     *
     * @ORM\Column(type="string", length=32, nullable=false)
     *
     * @var string
     */
    private $md5sum;

    /**
     * Passages présents dans ce fichier.
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Passage", mappedBy="file")
     *
     * @var Passage[]
     */
    private $passages;
}
