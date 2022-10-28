<?php

namespace App\Entity;

use App\Repository\EventParticipationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EventParticipationRepository::class)
 * @ORM\Table(name="participationevents")
 */
class EventParticipation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="Result", type="string", length=150)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=150)
     */
    private $result;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class)
     * @ORM\JoinColumn(name="id_event", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="eventParticipations")
     * @ORM\JoinColumn(name="id_student", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $student;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(string $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
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
}
