<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrdonnanceRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OrdonnanceRepository::class)
 */
class Ordonnance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Mentiens can't be null")
     * 
     */
    private $mentions;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message = "Details can't be null")
     * 
     */
    private $details;

    /**
     * @ORM\ManyToOne(targetEntity=Prescription::class, inversedBy="ordonnances")
     */
    private $prescription;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMentions(): ?string
    {
        return $this->mentions;
    }

    public function setMentions(string $mentions): self
    {
        $this->mentions = $mentions;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getPrescription(): ?Prescription
    {
        return $this->prescription;
    }

    public function setPrescription(?Prescription $prescription): self
    {
        $this->prescription = $prescription;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
