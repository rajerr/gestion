<?php

namespace App\Entity;

use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MedecinRepository::class)
 */
class Medecin extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $specialite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $biographie;

    /**
     * @ORM\OneToMany(targetEntity=HopitalService::class, mappedBy="medecin")
     */
    private $hopitalServices;

    /**
     * @ORM\OneToMany(targetEntity=Consultation::class, mappedBy="medecin")
     */
    private $consultations;

    public function __construct()
    {
        $this->hopitalServices = new ArrayCollection();
        $this->consultations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getBiographie(): ?string
    {
        return $this->biographie;
    }

    public function setBiographie(string $biographie): self
    {
        $this->biographie = $biographie;

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
            $hopitalService->setMedecin($this);
        }

        return $this;
    }

    public function removeHopitalService(HopitalService $hopitalService): self
    {
        if ($this->hopitalServices->contains($hopitalService)) {
            $this->hopitalServices->removeElement($hopitalService);
            // set the owning side to null (unless already changed)
            if ($hopitalService->getMedecin() === $this) {
                $hopitalService->setMedecin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Consultation[]
     */
    public function getConsultations(): Collection
    {
        return $this->consultations;
    }

    public function addConsultation(Consultation $consultation): self
    {
        if (!$this->consultations->contains($consultation)) {
            $this->consultations[] = $consultation;
            $consultation->setMedecin($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): self
    {
        if ($this->consultations->contains($consultation)) {
            $this->consultations->removeElement($consultation);
            // set the owning side to null (unless already changed)
            if ($consultation->getMedecin() === $this) {
                $consultation->setMedecin(null);
            }
        }

        return $this;
    }
}
