<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="`group`")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"group_search"})
     */
    private $id;

    /**
     * @ORM\Column(name="Name", type="string", length=50)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=50)
     *
     * @Groups({"group_search"})
     */
    private $name;

    /**
     * @ORM\Column(name="Year", type="smallint")
     *
     * @Assert\NotBlank()
     * @Assert\Type("int")
     * @Assert\Range(min="1900", max="2099")
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity=Specialty::class, inversedBy="groups")
     * @ORM\JoinColumn(name="id_specialty", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $specialty;

//    /**
//     * @ORM\ManyToOne(targetEntity=Instructor::class, inversedBy="groups")
//     * @ORM\JoinColumn(name="id_instructor", nullable=false)
//     *
//     * @Assert\NotBlank()
//     */
//    private $instructor;
    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="groups")
     * @ORM\JoinColumn(name="id_roles", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity=Classhour::class, mappedBy="group")
     */
    private $classhours;

    /**
     * @ORM\OneToMany(targetEntity=Student::class, mappedBy="group")
     * @ORM\OrderBy({"surname": "asc", "name": "asc", "patronymic": "asc"})
     */
    private $students;

    /**
     * @ORM\OneToMany(targetEntity=ParentsMeeting::class, mappedBy="group")
     */
    private $parentsMeetings;

    public function __construct()
    {
        $this->classhours = new ArrayCollection();
        $this->students = new ArrayCollection();
        $this->parentsMeetings = new ArrayCollection();
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

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getSpecialty(): ?Specialty
    {
        return $this->specialty;
    }

    public function setSpecialty(?Specialty $specialty): self
    {
        $this->specialty = $specialty;

        return $this;
    }

    public function getInstructor(): ?Instructor
    {
        return $this->instructor;
    }

    public function setInstructor(?Instructor $instructor): self
    {
        $this->instructor = $instructor;

        return $this;
    }

    /**
     * @return Collection<int, Classhour>
     */
    public function getClasshours(): Collection
    {
        return $this->classhours;
    }

    public function addClasshour(Classhour $classhour): self
    {
        if (!$this->classhours->contains($classhour)) {
            $this->classhours[] = $classhour;
            $classhour->setGroup($this);
        }

        return $this;
    }

    public function removeClasshour(Classhour $classhour): self
    {
        if ($this->classhours->removeElement($classhour)) {
            // set the owning side to null (unless already changed)
            if ($classhour->getGroup() === $this) {
                $classhour->setGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->setGroup($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getGroup() === $this) {
                $student->setGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ParentsMeeting>
     */
    public function getParentsMeetings(): Collection
    {
        return $this->parentsMeetings;
    }

    public function addParentsMeeting(ParentsMeeting $parentsMeeting): self
    {
        if (!$this->parentsMeetings->contains($parentsMeeting)) {
            $this->parentsMeetings[] = $parentsMeeting;
            $parentsMeeting->setGroup($this);
        }

        return $this;
    }

    public function removeParentsMeeting(ParentsMeeting $parentsMeeting): self
    {
        if ($this->parentsMeetings->removeElement($parentsMeeting)) {
            // set the owning side to null (unless already changed)
            if ($parentsMeeting->getGroup() === $this) {
                $parentsMeeting->setGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles): void
    {
        $this->roles = $roles;
    }
}
