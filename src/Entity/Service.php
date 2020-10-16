<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 */
class Service
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=HopitalService::class, mappedBy="service")
     */
    private $hopitalServices;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut;

    public function __construct()
    {
        $this->hopitalServices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|HopitalService[]
     */
    public function getHopitalServices(): Collection
    {
        return $this->hopitalServices;
    }

    public function addHopitalService(HopitalService $hopitalService): self
    {
        if (!$this->hopitalServices->contains($hopitalService)) {
            $this->hopitalServices[] = $hopitalService;
            $hopitalService->setService($this);
        }

        return $this;
    }

    public function removeHopitalService(HopitalService $hopitalService): self
    {
        if ($this->hopitalServices->contains($hopitalService)) {
            $this->hopitalServices->removeElement($hopitalService);
            // set the owning side to null (unless already changed)
            if ($hopitalService->getService() === $this) {
                $hopitalService->setService(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }
}
