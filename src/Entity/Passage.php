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
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

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
 *         @ORM\Index(name="ndx_passage_immat_collision", columns={"immat_collision"}),
 *         @ORM\Index(name="ndx_passage_fiability", columns={"fiability"}),
 *         @ORM\Index(name="ndx_passage_fictive", columns={"data_fictive"}),
 *         @ORM\Index(name="ndx_file_primary", columns={"file_id"}),
 *         @ORM\Index(name="ndx_camera_primary", columns={"camera_id"})
 *     }
 * )
 *
 * @ApiResource(
 *     collectionOperations={
 *         "get",
 *         "get_unique_cars"={"method"="GET", "path"="/passages/get_unique_cars"},
 *         "get_unique_trucks"={"method"="GET", "path"="/passages/get_unique_trucks"},
 *         "get_unique_unknown"={"method"="GET", "path"="/passages/get_unique_unknown"}
 *     },
 *     itemOperations={"get"}
 * )
 *
 * @ApiFilter(SearchFilter::class, properties={"immatriculation": "exact"})
 */
class Passage
{
    /**
     * Valeur pour un Camion.
     */
    const TRUCK = 1;

    /**
     * Valeur pour un inconnu.
     */
    const UNKNOWN = -1;

    /**
     * Valeur pour un véhicule léger.
     */
    const CAR = 0;

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
     * Plaque d'immatriculation avec tiret anonymisée.
     *
     * La plaque d'immatriculation est anonymisée via un algorithme de hachage après un salage de la plaque.
     *
     * @ORM\Column(type="string", length=64, nullable=false)
     *
     * @var string
     */
    private $immatriculation;

    /**
     * Plaque d'immatriculation sans tiret anonymisée.
     *
     * La plaque d'immatriculation est anonymisée via un algorithme de hachage après un salage de la plaque.
     *
     * @ORM\Column(type="string", length=64, nullable=false)
     *
     * @var string
     */
    private $immat;

    /**
     * Plaque d'immatriculation anonymisée après remplacement des O par des 0, des i par des 1, etc.
     *
     * La plaque d'immatriculation est anonymisée via un algorithme de hachage après un salage de la plaque.
     *
     * @ORM\Column(type="string", length=64, nullable=false)
     *
     * @var string
     */
    private $immatCollision;

    /**
     * Variable inconnue r.
     *
     * @ORM\Column(type="bigint", nullable=false)
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
     * Est-ce un camion ?
     *
     * 1 pour camion, 0 pour voiture, -1 pour plantage ?
     *
     * @ORM\Column(type="smallint", nullable=false)
     *
     * @var int
     */
    private $l;

    /**
     * Pays visible sur la plaque d'immatriculation.
     *
     * La longueur est importante, car dans certains cas, la caméra remonte plein de valeurs possibles.
     *
     * @ORM\Column(type="string", length=32, nullable=true)
     *
     * @var string
     */
    private $state;

    /**
     * Indique s'il s'agit d'une donnée fictive ou non.
     *
     * @ORM\Column(type="boolean", nullable=false, name="data_fictive", options={"default":false})
     *
     * @var bool
     */
    private $dataFictive;

    /**
     * Nom du fichier image en noir et blanc.
     *
     * @ORM\Column(type="string", length=128, nullable=true)
     *
     * @var string
     */
    private $image;

    /**
     * Caméra ayant enregistré ce passage.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Camera")
     * @ORM\JoinColumn(name="camera_id", referencedColumnName="id", nullable=false)
     *
     * @var Camera
     */
    private $camera;

    /**
     * Fichier dans lequel ce passage est enregistré.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\File")
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id", nullable=false)
     *
     * @var File
     */
    private $file;

    /**
     * Retourne l'identifiant primaire du passage.
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne l'horodatage du passage devant la caméra.
     *
     * @return \DateTime
     */
    public function getCreated(): ?\DateTime
    {
        return $this->created;
    }

    /**
     * Récupère le nom du fichier image.
     *
     * @return string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Retourne le numéro de passage selon l'incrément interne de la caméra.
     *
     * @return int
     */
    public function getIncrement(): ?int
    {
        return $this->increment;
    }

    /**
     * Retourne la plaque d'immatriculation anonymisée.
     *
     * @return string
     */
    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    /**
     * Retourne la plaque d'immatriculation anonymisée selon l'autre format, celui sans les séparateurs.
     *
     * @return string
     */
    public function getImmat(): ?string
    {
        return $this->immat;
    }

    /**
     * Retourne la plaque d'immatriculation anonymisée après avoir transformé les O en 0, etc.
     *
     * @return string
     */
    public function getImmatCollision(): ?string
    {
        return $this->immatCollision;
    }

    /**
     * Cette donnée indique s'il s'agit d'un camion ou non.
     *
     * @return int
     */
    public function getL(): ?int
    {
        return $this->l;
    }

    /**
     * Cette donnée est inconnue.
     *
     * @return int
     */
    public function getR(): ?int
    {
        return $this->r;
    }

    /**
     * Cette donnée est inconnue.
     *
     * @return int
     */
    public function getS(): ?int
    {
        return $this->s;
    }

    /**
     * Retourne le taux de fiabilité de détermination de la plaque d'immatriculation.
     *
     * @return int
     */
    public function getFiability(): ?int
    {
        return $this->fiability;
    }

    /**
     * Retourne une chaine de caractère correspondant à la position de la plaque sur la photo.
     *
     * @return string
     */
    public function getCoord(): ?string
    {
        return $this->coord;
    }

    /**
     * Cette donnée est inconnue.
     *
     * @return int
     */
    public function getH(): ?int
    {
        return $this->h;
    }

    /**
     * Retourne le pays indiqué sur la plaque d'immatriculation.
     *
     * @return string
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * Retourne la caméra ayant enregistré le passage actuel.
     *
     * @return Camera
     */
    public function getCamera(): ?Camera
    {
        return $this->camera;
    }

    /**
     * Retourne le fichier où est spécifié ce passage.
     *
     * @return File
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * Retourne vrai s'il s'agit d'un camion.
     *
     * @return bool
     */
    public function isCamion(): bool
    {
        return self::TRUCK === $this->l;
    }

    /**
     * Indique s'il s'agit d'une donnée fictive ou non.
     *
     * Une donnée fictive est une donnée de test à ne pas utiliser pour le statistiques.
     *
     * @return bool
     */
    public function isDataFictive(): ?bool
    {
        return $this->dataFictive;
    }

    /**
     * Définit l'horodatage du passage devant la caméra.
     *
     * @param \DateTime $created
     *
     * @return Passage
     */
    public function setCreated(\DateTime $created): Passage
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Retourne le nom du fichier image.
     *
     * @param string $image
     *
     * @return Passage
     */
    public function setImage(string $image): Passage
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Définit le numéro du passage selon l'incrément interne de la caméra.
     *
     * @param int $increment
     *
     * @return Passage
     */
    public function setIncrement(int $increment): Passage
    {
        $this->increment = $increment;

        return $this;
    }

    /**
     * Définit la variable inconnue S.
     *
     * @param int $s
     *
     * @return Passage
     */
    public function setS(int $s): Passage
    {
        $this->s = $s;

        return $this;
    }

    /**
     * Définit l'immatriculation.
     *
     * Cette donnée a préalablement été hashée, par conséquent on n'a jamais la véritable plaque.
     *
     * @param string $immatriculation
     *
     * @return Passage
     */
    public function setImmatriculation(?string $immatriculation = null): Passage
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    /**
     * Définit l'immatriculation.
     *
     * Cette donnée a préalablement été hashée, par conséquent on n'a jamais la véritable plaque.
     *
     * @param string $immat
     *
     * @return Passage
     */
    public function setImmat(string $immat): Passage
    {
        $this->immat = $immat;

        return $this;
    }

    /**
     * Définit l'immatriculation.
     * Il s'agissait de l'immatriculation dont on avait remplacé les O par des 0, 1 et i,I par des L, etc.
     *
     * Cette donnée a préalablement été hashée, par conséquent on n'a jamais la véritable plaque.
     *
     * @param string $immatCollision
     *
     * @return Passage
     */
    public function setImmatCollision(string $immatCollision): Passage
    {
        $this->immatCollision = $immatCollision;

        return $this;
    }

    /**
     * Définit le type de véhicule.
     *
     * @param int $l
     *
     * @return Passage
     */
    public function setL(int $l): Passage
    {
        $this->l = $l;

        return $this;
    }

    /**
     * Définit la variable inconnue R.
     *
     * @param int $r
     *
     * @return Passage
     */
    public function setR(int $r): Passage
    {
        $this->r = $r;

        return $this;
    }

    /**
     * Définit la fiabilité de la lecture de plaque.
     *
     * @param int $fiability
     *
     * @return Passage
     */
    public function setFiability(int $fiability): Passage
    {
        $this->fiability = $fiability;

        return $this;
    }

    /**
     * Définit la position de la plaque d'immatriculation sur la photo.
     *
     * @param string $coord
     *
     * @return Passage
     */
    public function setCoord(string $coord): Passage
    {
        $this->coord = $coord;

        return $this;
    }

    /**
     * Set the unknown variable H.
     *
     * @param int $h
     *
     * @return Passage
     */
    public function setH(int $h): Passage
    {
        $this->h = $h;

        return $this;
    }

    /**
     * Set state.
     *
     * @param string $state
     *
     * @return Passage
     */
    public function setState(string $state): Passage
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Set data fictive or not.
     *
     * @param bool $dataFictive
     *
     * @return Passage
     */
    public function setDataFictive(bool $dataFictive): Passage
    {
        $this->dataFictive = $dataFictive;

        return $this;
    }

    /**
     * Set the camera.
     *
     * @param Camera $camera
     *
     * @return Passage
     */
    public function setCamera(Camera $camera): Passage
    {
        $this->camera = $camera;

        return $this;
    }

    /**
     * Set the file.
     *
     * @param File $file
     *
     * @return Passage
     */
    public function setFile(File $file): Passage
    {
        $this->file = $file;

        return $this;
    }
}
