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
 * Passage anonymisé devant la caméra.
 *
 * @ORM\Entity(repositoryClass="App\Repository\PassageRepository")
 * @ORM\Table(
 *     name="te_passage",
 *     schema="data",
 *     indexes={
 *         @ORM\Index(name="ndx_passage_immatriculation", columns={"immatriculation"}),
 *         @ORM\Index(name="ndx_passage_immat", columns={"immat"}),
 *         @ORM\Index(name="ndx_passage_fiability", columns={"fiability"}),
 *         @ORM\Index(name="ndx_passage_fictive", columns={"data_fictive"})
 *     }
 * )
 */
class Passage
{
    /**
     * Identifiant primaire du passage.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    private $id;

    /**
     * Horodatage du passage devant la caméra.
     *
     * @ORM\Column(type="datetime", nullable=false)
     *
     * @var \DateTime
     */
    private $created;

    /**
     * Numéro d'incrément interne à la caméra.
     *
     * @ORM\Column(type="integer", nullable=false)
     *
     * @var int
     */
    private $increment;

    /**
     * Variable S inconnue.
     *
     * @ORM\Column(type="integer", nullable=false, options={"default":0})
     *
     * @var int
     */
    private $s;

    /**
     * Plaque d'immatriculation anonymisée.
     *
     * La plaque d'immatriculation est anonymisée via un algorithme de hachage après un salage de la plaque.
     *
     * @ORM\Column(type="string", length=32, nullable=false)
     *
     * @var string
     */
    private $immatriculation;

    /**
     * Plaque d'immatriculation anonymisée.
     *
     * La plaque d'immatriculation est anonymisée via un algorithme de hachage après un salage de la plaque.
     *
     * @ORM\Column(type="string", length=32, nullable=false)
     *
     * @var string
     */
    private $immat;

    /**
     * Variable inconnue r.
     *
     * @ORM\Column(type="integer", nullable=false)
     *
     * @var int
     */
    private $r;

    /**
     * Taux de fiabilité de la reconnaissance de plaque d'immatriculation.
     *
     * Sa valeur est comprise entre 0 et 100 inclus.
     *
     * @ORM\Column(type="smallint", nullable=false, options={"unsigned":true})
     *
     * @var int
     */
    private $fiability;

    /**
     * Coordonnées de la plaque d'immatriculation sur la photo.
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    private $coord;

    /**
     * Variable inconnue H.
     *
     * @ORM\Column(type="smallint", nullable=false)
     *
     * @var int
     */
    private $h;

    /**
     * Pays visible sur la plaque d'immatriculation.
     *
     * @ORM\Column(type="string", length=8, nullable=true)
     *
     * @var string
     */
    private $state;

    /**
     * @ORM\Column(type="boolean", nullable=false, name="data_fictive", options={"default":false})
     */
    private $dataFictive;

    /**
     * Caméra ayant enregistré ce passage.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Camera", inversedBy="passages")
     * @ORM\JoinColumn(name="camera_id", referencedColumnName="id", nullable=false)
     *
     * @var Camera
     */
    private $camera;

    /**
     * Fichier dans lequel ce passage est enregistré.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\File", inversedBy="passages")
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id", nullable=false)
     *
     * @var File
     */
    private $file;
}
