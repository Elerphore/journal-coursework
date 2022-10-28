<?php

namespace App\Entity;

use App\Repository\StudentViolationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=StudentViolationRepository::class)
 * @UniqueEntity({"student", "violation"})
 */
class StudentViolation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="studentViolations")
     * @ORM\JoinColumn(name="id_student", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $student;

    /**
     * @ORM\ManyToOne(targetEntity=Violation::class, inversedBy="studentViolations")
     * @ORM\JoinColumn(name="id_violation", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $violation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getViolation(): ?Violation
    {
        return $this->violation;
    }

    public function setViolation(?Violation $violation): self
    {
        $this->violation = $violation;

        return $this;
    }
}
