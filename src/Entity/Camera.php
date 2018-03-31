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
 * Caméra.
 *
 * @ORM\Entity(repositoryClass="App\Repository\CameraRepository")
 * @ORM\Table(name="te_camera", schema="data", indexes={@ORM\Index(name="ndx_camera_active", columns={"active"})})
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
    private $active;

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
     * Passages enregistrés par la caméra.
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Passage", mappedBy="camera")
     *
     * @var Passage[]
     */
    private $passages;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getSerialNumber(): string
    {
        return $this->serialNumber;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getIpRouter(): string
    {
        return $this->ip_router;
    }

    /**
     * @return string
     */
    public function getIpCamera(): string
    {
        return $this->ip_camera;
    }

    /**
     * @return int
     */
    public function getMasque(): int
    {
        return $this->masque;
    }

    /**
     * @return Passage[]
     */
    public function getPassages(): array
    {
        return $this->passages;
    }

    /**
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
     * @param int $masque
     *
     * @return Camera
     */
    public function setMasque(int $masque): Camera
    {
        $this->masque = $masque;

        return $this;
    }
}
