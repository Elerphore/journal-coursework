<?php

namespace App\Entity;

use App\Repository\StudentParentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=StudentParentRepository::class)
 * @ORM\Table(name="student_parent_typeofparent")
 */
class StudentParent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="studentParents")
     * @ORM\JoinColumn(name="id_student", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $student;

    /**
     * @ORM\ManyToOne(targetEntity=Parents::class, inversedBy="studentParents")
     * @ORM\JoinColumn(name="id_parent", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $parent;

    /**
     * @ORM\ManyToOne(targetEntity=ParentType::class)
     * @ORM\JoinColumn(name="id_typeofparent", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $parentType;

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

    public function getParent(): ?Parents
    {
        return $this->parent;
    }

    public function setParent(?Parents $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getParentType(): ?ParentType
    {
        return $this->parentType;
    }

    public function setParentType(?ParentType $parentType): self
    {
        $this->parentType = $parentType;

        return $this;
    }
}
