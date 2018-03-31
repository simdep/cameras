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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @var string
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

    /**
     * File constructor.
     */
    public function __construct()
    {
        $this->passages = new ArrayCollection();
    }

    /**
     * Retourne l'identifiant primaire de ce fichier dans la base de données.
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Récupère le répertoire de ce fichier.
     *
     * @return string
     */
    public function getDirectory(): ?string
    {
        return $this->directory;
    }

    /**
     * Récupère le nom du fichier.
     *
     * @return string
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * Récupère le code md5 de ce fichier.
     *
     * @return string
     */
    public function getMd5sum(): ?string
    {
        return $this->md5sum;
    }

    /**
     * Liste les passages associés à ce fichier.
     *
     * @return Passage[]|Collection
     */
    public function getPassages(): Collection
    {
        return $this->passages;
    }

    /**
     * Définit le répertoire relatif de stockage du fichier.
     *
     * @param string $directory
     *
     * @return File
     */
    public function setDirectory(string $directory): File
    {
        $this->directory = $directory;

        return $this;
    }

    /**
     * Définit le nom du fichier.
     *
     * @param string $filename
     *
     * @return File
     */
    public function setFilename(string $filename): File
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Définit le code MD5 du fichier en fonction de son contenu.
     *
     * @param string $md5sum
     *
     * @return File
     */
    public function setMd5sum(string $md5sum): File
    {
        $this->md5sum = $md5sum;

        return $this;
    }
}
