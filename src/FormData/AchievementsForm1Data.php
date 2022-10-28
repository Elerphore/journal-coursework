<?php

namespace App\FormData;

use App\Entity\Group;
use App\Repository\AcademicYearRepository;
use App\Repository\EventParticipationRepository;
use App\Repository\StudentRepository;
use App\Repository\TypeOfEventRepository;

class AchievementsForm1Data implements FormDataInterface
{
    /**
     * @var \App\Repository\AcademicYearRepository
     */
    private AcademicYearRepository $academicYearRepository;

    /**
     * @var \App\Repository\StudentRepository
     */
    private StudentRepository $studentRepository;

    /**
     * @var \App\Repository\TypeOfEventRepository
     */
    private TypeOfEventRepository $typeOfEventRepository;

    /**
     * @var \App\Repository\EventParticipationRepository
     */
    private EventParticipationRepository $eventParticipationRepository;

    public function __construct(
        AcademicYearRepository $academicYearRepository,
        StudentRepository $studentRepository,
        TypeOfEventRepository $typeOfEventRepository,
        EventParticipationRepository $eventParticipationRepository
    ) {
        $this->academicYearRepository = $academicYearRepository;
        $this->studentRepository = $studentRepository;
        $this->typeOfEventRepository = $typeOfEventRepository;
        $this->eventParticipationRepository = $eventParticipationRepository;
    }

    public static function getFormId(): string
    {
        return 'form_dostijeniya1';
    }

    public static function getFormName(): string
    {
        return 'Учет индивидуальных достижений обучающихся';
    }

    public function getData(Group $group): array
    {
        $currentAcademicYear = $this->academicYearRepository->findCurrentAcademicYear();

        $students = $this->studentRepository->createQueryBuilder('s')
            ->indexBy('s', 's.id')
            ->where('s.group = :group')
            ->setParameter('group', $group)
            ->orderBy('s.surname')
            ->addOrderBy('s.name')
            ->addOrderBy('s.patronymic')
            ->getQuery()
            ->getResult();

        $typeOfEvents = $this->typeOfEventRepository->createQueryBuilder('toe')
            ->indexBy('toe', 'toe.id')
            ->orderBy('toe.id')
            ->getQuery()
            ->getResult();

        /** @var \App\Entity\EventParticipation[] $eventParticipations */
        $eventParticipations = $this->eventParticipationRepository->createQueryBuilder('ep')
            ->select('ep, e')
            ->innerJoin('ep.event', 'e')
            ->innerJoin('ep.student', 's')
            ->getQuery()
            ->getResult();

        $events = [];
        foreach ($eventParticipations as $participation) {
            $studentId = $participation->getStudent()->getId();
            $typeOfEventId = $participation->getEvent()->getTypeOfEvent()->getId();

            $events[$studentId][$typeOfEventId][] = $participation;
        }

        return [
            'currentAcademicYear' => $currentAcademicYear,
            'students' => $students,
            'typeOfEvents' => $typeOfEvents,
            'events' => $events,
        ];
    }
}
