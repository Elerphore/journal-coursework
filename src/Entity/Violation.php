<?php

namespace App\Entity;

use App\Repository\ViolationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ViolationRepository::class)
 */
class Violation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="Name", type="string", length=200)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=200)
     */
    private $name;

    /**
     * @ORM\Column(name="Date", type="date")
     *
     * @Assert\NotBlank()
     */
    private $date;

    /**
     * @ORM\Column(name="MeasuresTaken", type="string", length=150)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=150)
     */
    private $measuresTaken;

    /**
     * @ORM\Column(name="Note", type="string", length=150)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=150)
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity=TypeOfViolation::class)
     * @ORM\JoinColumn(name="id_typeOfViolation", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $typeOfViolation;

    /**
     * @ORM\ManyToOne(targetEntity=AcademicYear::class)
     * @ORM\JoinColumn(name="id_academicYear", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $academicYear;

    /**
     * @ORM\OneToMany(targetEntity=StudentViolation::class, mappedBy="violation")
     */
    private $studentViolations;

    public function __construct()
    {
        $this->studentViolations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getMeasuresTaken(): ?string
    {
        return $this->measuresTaken;
    }

    public function setMeasuresTaken(string $measuresTaken): self
    {
        $this->measuresTaken = $measuresTaken;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getTypeOfViolation(): ?TypeOfViolation
    {
        return $this->typeOfViolation;
    }

    public function setTypeOfViolation(?TypeOfViolation $typeOfViolation): self
    {
        $this->typeOfViolation = $typeOfViolation;

        return $this;
    }

    public function getAcademicYear(): ?AcademicYear
    {
        return $this->academicYear;
    }

    public function setAcademicYear(?AcademicYear $academicYear): self
    {
        $this->academicYear = $academicYear;

        return $this;
    }

    /**
     * @return Collection<int, StudentViolation>
     */
    public function getStudentViolations(): Collection
    {
        return $this->studentViolations;
    }

    public function addStudentViolation(StudentViolation $studentViolation): self
    {
        if (!$this->studentViolations->contains($studentViolation)) {
            $this->studentViolations[] = $studentViolation;
            $studentViolation->setViolation($this);
        }

        return $this;
    }

    public function removeStudentViolation(StudentViolation $studentViolation): self
    {
        if ($this->studentViolations->removeElement($studentViolation)) {
            // set the owning side to null (unless already changed)
            if ($studentViolation->getViolation() === $this) {
                $studentViolation->setViolation(null);
            }
        }

        return $this;
    }
}
