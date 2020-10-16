<?php

namespace App\Entity;

use App\Repository\HopitalServiceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HopitalServiceRepository::class)
 */
class HopitalService
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Hopital::class, inversedBy="hopitalServices")
     */
    private $hopital;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="hopitalServices")
     */
    private $service;

    /**
     * @ORM\ManyToOne(targetEntity=Medecin::class, inversedBy="hopitalServices")
     */
    private $medecin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHopital(): ?Hopital
    {
        return $this->hopital;
    }

    public function setHopital(?Hopital $hopital): self
    {
        $this->hopital = $hopital;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getMedecin(): ?Medecin
    {
        return $this->medecin;
    }

    public function setMedecin(?Medecin $medecin): self
    {
        $this->medecin = $medecin;

        return $this;
    }
}
