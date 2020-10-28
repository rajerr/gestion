<?php

namespace App\Entity;

use App\Repository\SuiviRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SuiviRepository::class)
 */
class Suivi
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Libelle can't be null")
     * 
     */
    private $libelle;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message = "Date Prise can't be null")
     * 
     */
    private $dateprise;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message = "Date Retour can't be null")
     * 
     */
    private $dateretour;

    /**
     * @ORM\Column(type="time")
     * @Assert\NotBlank(message = "Heure can't be null")
     * 
     */
    private $timeretour;

    /**
     * @ORM\ManyToOne(targetEntity=Consultation::class, inversedBy="suivis")
     */
    private $consultation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDateprise(): ?\DateTimeInterface
    {
        return $this->dateprise;
    }

    public function setDateprise(\DateTimeInterface $dateprise): self
    {
        $this->dateprise = $dateprise;

        return $this;
    }

    public function getDateretour(): ?\DateTimeInterface
    {
        return $this->dateretour;
    }

    public function setDateretour(\DateTimeInterface $dateretour): self
    {
        $this->dateretour = $dateretour;

        return $this;
    }

    public function getTimeretour(): ?\DateTimeInterface
    {
        return $this->timeretour;
    }

    public function setTimeretour(\DateTimeInterface $timeretour): self
    {
        $this->timeretour = $timeretour;

        return $this;
    }

    public function getConsultation(): ?Consultation
    {
        return $this->consultation;
    }

    public function setConsultation(?Consultation $consultation): self
    {
        $this->consultation = $consultation;

        return $this;
    }
}
