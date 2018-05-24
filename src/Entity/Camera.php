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
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * Caméra.
 *
 * @ORM\Entity(repositoryClass="App\Repository\CameraRepository")
 * @ORM\Table(name="te_camera", schema="data", indexes={@ORM\Index(name="ndx_camera_active", columns={"active"})})
 *
 * @ApiResource
 */
class Camera
{
    /**
     * Identifiant primaire de la caméra.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    private $id;

    /**
     * Type de la caméra.
     *
     * @ORM\Column(type="string", length=8, nullable=true)
     *
     * @var string
     */
    private $type;

    /**
     * Numéro de série de la caméra.
     *
     * @ORM\Column(type="string", length=32, nullable=true)
     *
     * @var string
     */
    private $serialNumber;

    /**
     * Libellé complet du site d'implantation de la caméra.
     *
     * @ORM\Column(type="string", length=64, nullable=true)
     *
     * @var string
     */
    private $name;

    /**
     * Indicateur d'activité de la caméra.
     *
     * Si l'importateur doit interroger la caméra et télécharger ses fichiers,
     * alors cet indicateur doit être à vrai.
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default":true})
     *
     * @var bool
     */
    private $active = true;

    /**
     * Code de la caméra.
     *
     * Il s'agit du code d'implantation du site de la caméra, celui qu'on retrouve sur le document
     * d'architecture réseau de Christophe.
     *
     * @ORM\Column(type="string", length=16, nullable=false)
     *
     * @var string
     */
    private $code;

    /**
     * Adresse IP du routeur de la caméra.
     *
     * @ORM\Column(type="string", length=15, nullable=false)
     *
     * @var string
     */
    private $ip_router;

    /**
     * Adresse IP de la caméra.
     *
     * @ORM\Column(type="string", length=15, nullable=true)
     *
     * @var string
     */
    private $ip_camera;

    /**
     * Masque du sous-réseau de la caméra.
     *
     * @ORM\Column(type="smallint", nullable=false, options={"default":29,"unsigned":true})
     *
     * @var int
     */
    private $masque = 29;

    /**
     * Indicateur sur le statut de la caméra.
     *
     * À vrai, cet indicateur indique qu'il s'agit d'une caméra de test et que les données ne sont pas à prendre en compte.
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default":false})
     *
     * @var bool
     */
    private $test = false;

    /**
     * Latitude de la caméra.
     *
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $latitude;

    /**
     * Longitude de la caméra.
     *
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $longitude;

    /**
     * Passages enregistrés par la caméra.
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Passage", mappedBy="camera")
     *
     * @ApiSubresource
     *
     * @var Passage[]
     */
    private $passages;

    /**
     * Camera constructor.
     */
    public function __construct()
    {
        $this->passages = new ArrayCollection();
    }

    /**
     * Retourne le répertoire où se trouvent les fichiers à télécharger.
     *
     * @return null|string
     */
    public function getDirectory(): ?string
    {
        if (null === $this->getIpCamera()) {
            return null;
        }

        return "http://{$this->getIpCamera()}:8000/meci-L1/discr/output/";
    }

    /**
     * Retourne le répertoire où se trouvent les images à télécharger.
     *
     * @return null|string
     */
    public function getImageDirectory(): ?string
    {
        if (null === $this->getIpCamera()) {
            return null;
        }

        return "http://{$this->getIpCamera()}:8000/meci-L1/discr/images/";
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Récupération de la latitude.
     *
     * @return float
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * Récupération de la longitude.
     *
     * @return float
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * Retourne le numéro de série de la caméra.
     *
     * @return string
     */
    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Retourne le nom de la caméra.
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Retourne le code de la caméra.
     *
     * @return string
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Retourne l'adresse IP du routeur devant la caméra.
     *
     * @return string
     */
    public function getIpRouter(): ?string
    {
        return $this->ip_router;
    }

    /**
     * Retourne l'adresse IP de la caméra.
     *
     * @return string
     */
    public function getIpCamera(): ?string
    {
        return $this->ip_camera;
    }

    /**
     * Retourne le masque du réseau de cette caméra.
     *
     * @return int
     */
    public function getMasque(): ?int
    {
        return $this->masque;
    }

    /**
     * Retourne les passages enregistrés par cette caméra.
     *
     * @return Passage[]|Collection
     */
    public function getPassages(): Collection
    {
        return $this->passages;
    }

    /**
     * Indique si on a les coordonnées des caméras ou non.
     *
     * @return bool
     */
    public function hasCoordonnees(): bool
    {
        return (null !== $this->latitude && null !== $this->longitude);
    }

    /**
     * Est-ce que la caméra est active ?
     *
     * Une caméra active est interrogée par l'importateur.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Est-ce qu'il s'agit d'une caméra de test ?
     *
     * Les passages d'une caméra de tests sont sensés à être des données fictives à ne pas étudier.
     *
     * @return bool
     */
    public function isTest(): bool
    {
        return $this->test;
    }

    /**
     * Setter de la latitude.
     *
     * @param float $latitude
     * @return Camera
     */
    public function setLatitude(?float $latitude): Camera
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Setter de la longitude.
     *
     * @param float $longitude
     * @return Camera
     */
    public function setLongitude(?float $longitude): Camera
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Définit le type de la caméra.
     *
     * @param string $type
     *
     * @return Camera
     */
    public function setType(string $type): Camera
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Définit le numéro de série de la caméra.
     *
     * @param string $serialNumber
     *
     * @return Camera
     */
    public function setSerialNumber(string $serialNumber): Camera
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }

    /**
     * Définit le nom de la caméra.
     *
     * @param string $name
     *
     * @return Camera
     */
    public function setName(string $name): Camera
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Déclare la caméra active ou inactive.
     *
     * Une caméra active est interrogée par l'importateur.
     *
     * @param bool $active
     *
     * @return Camera
     */
    public function setActive(bool $active): Camera
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Définit le code unique de la caméra.
     *
     * @param string $code
     *
     * @return Camera
     */
    public function setCode(string $code): Camera
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Définit l'adresse IP du routeur devant la caméra.
     *
     * @param string $ip_router
     *
     * @return Camera
     */
    public function setIpRouter(string $ip_router): Camera
    {
        $this->ip_router = $ip_router;

        return $this;
    }

    /**
     * Définit l'adresse IP de la caméra.
     *
     * @param string $ip_camera
     *
     * @return Camera
     */
    public function setIpCamera(string $ip_camera): Camera
    {
        $this->ip_camera = $ip_camera;

        return $this;
    }

    /**
     * Définit le masque du réseau de la caméra.
     *
     * @param int $masque
     *
     * @return Camera
     */
    public function setMasque(int $masque): Camera
    {
        $this->masque = $masque;

        return $this;
    }

    /**
     * Positionne l'indicateur de test à vrai ou faux.
     *
     * @param bool $test
     *
     * @return Camera
     */
    public function setTest(bool $test): Camera
    {
        $this->test = $test;

        return $this;
    }
}
