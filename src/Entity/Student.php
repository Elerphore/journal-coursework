<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="Surname", type="string", length=100)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    private $surname;

    /**
     * @ORM\Column(name="Name", type="string", length=100)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    private $name;

    /**
     * @ORM\Column(name="Patronymic", type="string", length=100)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    private $patronymic;

    /**
     * @ORM\Column(name="DateOfBirthday", type="date")
     *
     * @Assert\NotBlank()
     */
    private $birthday;

    /**
     * @ORM\Column(name="Address", type="string", length=1000)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=1000)
     */
    private $address;

    /**
     * @ORM\Column(name="Actual_address", type="string", length=1000)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=1000)
     */
    private $actualAddress;

    /**
     * @ORM\Column(name="Phone", type="string", length=30)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=30)
     */
    private $phone;

    /**
     * @ORM\Column(name="Hostel", type="string", length=20)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=20)
     */
    private $hostel;

    /**
     * @ORM\ManyToOne(targetEntity=Group::class, inversedBy="students")
     * @ORM\JoinColumn(name="id_group", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $group;

    /**
     * @ORM\ManyToOne(targetEntity=Healthgroup::class)
     * @ORM\JoinColumn(name="id_healthGroup", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $healthgroup;

    /**
     * @ORM\ManyToOne(targetEntity=Active::class)
     * @ORM\JoinColumn(name="id_actives", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class)
     * @ORM\JoinColumn(name="id_status", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=EventParticipation::class, mappedBy="student", orphanRemoval=true)
     */
    private $eventParticipations;

    /**
     * @ORM\OneToMany(targetEntity=Conversation::class, mappedBy="student")
     */
    private $conversations;

    /**
     * @ORM\OneToMany(targetEntity=HostelSchedule::class, mappedBy="student")
     */
    private $hostelSchedules;

    /**
     * @ORM\OneToMany(targetEntity=StudentParent::class, mappedBy="student")
     */
    private $studentParents;

    /**
     * @ORM\OneToMany(targetEntity=StudentViolation::class, mappedBy="student")
     */
    private $studentViolations;

    public function __construct()
    {
        $this->eventParticipations = new ArrayCollection();
        $this->conversations = new ArrayCollection();
        $this->hostelSchedules = new ArrayCollection();
        $this->studentParents = new ArrayCollection();
        $this->studentViolations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
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

    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    public function setPatronymic(string $patronymic): self
    {
        $this->patronymic = $patronymic;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getActualAddress(): ?string
    {
        return $this->actualAddress;
    }

    public function setActualAddress(string $actualAddress): self
    {
        $this->actualAddress = $actualAddress;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getHostel(): ?string
    {
        return $this->hostel;
    }

    public function setHostel(string $hostel): self
    {
        $this->hostel = $hostel;

        return $this;
    }

    public function getGroup(): ?Group
    {
        return $this->group;
    }

    public function setGroup(?Group $group): self
    {
        $this->group = $group;

        return $this;
    }

    public function getHealthgroup(): ?Healthgroup
    {
        return $this->healthgroup;
    }

    public function setHealthgroup(?Healthgroup $healthgroup): self
    {
        $this->healthgroup = $healthgroup;

        return $this;
    }

    public function getActive(): ?Active
    {
        return $this->active;
    }

    public function setActive(?Active $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, EventParticipation>
     */
    public function getEventParticipations(): Collection
    {
        return $this->eventParticipations;
    }

    public function addEventParticipation(EventParticipation $eventParticipation): self
    {
        if (!$this->eventParticipations->contains($eventParticipation)) {
            $this->eventParticipations[] = $eventParticipation;
            $eventParticipation->setStudent($this);
        }

        return $this;
    }

    public function removeEventParticipation(EventParticipation $eventParticipation): self
    {
        if ($this->eventParticipations->removeElement($eventParticipation)) {
            // set the owning side to null (unless already changed)
            if ($eventParticipation->getStudent() === $this) {
                $eventParticipation->setStudent(null);
            }
        }

        return $this;
    }

    public function getFio(): ?string
    {
        $fioParts = [
            $this->getSurname(),
            $this->getName(),
            $this->getPatronymic(),
        ];

        return implode(' ', array_filter($fioParts, static fn($string) => $string !== null && $string !== ''));
    }

    /**
     * @return Collection<int, Conversation>
     */
    public function getConversations(): Collection
    {
        return $this->conversations;
    }

    public function addConversation(Conversation $conversation): self
    {
        if (!$this->conversations->contains($conversation)) {
            $this->conversations[] = $conversation;
            $conversation->setStudent($this);
        }

        return $this;
    }

    public function removeConversation(Conversation $conversation): self
    {
        if ($this->conversations->removeElement($conversation)) {
            // set the owning side to null (unless already changed)
            if ($conversation->getStudent() === $this) {
                $conversation->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HostelSchedule>
     */
    public function getHostelSchedules(): Collection
    {
        return $this->hostelSchedules;
    }

    public function addHostelSchedule(HostelSchedule $hostelSchedule): self
    {
        if (!$this->hostelSchedules->contains($hostelSchedule)) {
            $this->hostelSchedules[] = $hostelSchedule;
            $hostelSchedule->setStudent($this);
        }

        return $this;
    }

    public function removeHostelSchedule(HostelSchedule $hostelSchedule): self
    {
        if ($this->hostelSchedules->removeElement($hostelSchedule)) {
            // set the owning side to null (unless already changed)
            if ($hostelSchedule->getStudent() === $this) {
                $hostelSchedule->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StudentParent>
     */
    public function getStudentParents(): Collection
    {
        return $this->studentParents;
    }

    public function addStudentParent(StudentParent $studentParent): self
    {
        if (!$this->studentParents->contains($studentParent)) {
            $this->studentParents[] = $studentParent;
            $studentParent->setStudent($this);
        }

        return $this;
    }

    public function removeStudentParent(StudentParent $studentParent): self
    {
        if ($this->studentParents->removeElement($studentParent)) {
            // set the owning side to null (unless already changed)
            if ($studentParent->getStudent() === $this) {
                $studentParent->setStudent(null);
            }
        }

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
            $studentViolation->setStudent($this);
        }

        return $this;
    }

    public function removeStudentViolation(StudentViolation $studentViolation): self
    {
        if ($this->studentViolations->removeElement($studentViolation)) {
            // set the owning side to null (unless already changed)
            if ($studentViolation->getStudent() === $this) {
                $studentViolation->setStudent(null);
            }
        }

        return $this;
    }
}
