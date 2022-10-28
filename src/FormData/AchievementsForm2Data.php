<?php

namespace App\FormData;

use App\Entity\Group;
use App\Repository\AcademicYearRepository;
use App\Repository\EventParticipationRepository;

class AchievementsForm2Data implements FormDataInterface
{
    /**
     * @var \App\Repository\AcademicYearRepository
     */
    private AcademicYearRepository $academicYearRepository;

    /**
     * @var \App\Repository\EventParticipationRepository
     */
    private EventParticipationRepository $eventParticipationRepository;

    public function __construct(
        AcademicYearRepository $academicYearRepository,
        EventParticipationRepository $eventParticipationRepository
    ) {
        $this->academicYearRepository = $academicYearRepository;
        $this->eventParticipationRepository = $eventParticipationRepository;
    }

    public static function getFormId(): string
    {
        return 'form_dostijeniya2';
    }

    public static function getFormName(): string
    {
        return 'Сведения об участии студентов в университетских, городских, областных и общероссийских мероприятиях';
    }

    public function getData(Group $group): array
    {
        $currentAcademicYear = $this->academicYearRepository->findCurrentAcademicYear();

        $participations = $this->eventParticipationRepository->createQueryBuilder('ep')
            ->select('ep, e, s')
            ->innerJoin('ep.event', 'e')
            ->innerJoin('ep.student', 's')
            ->where('s.group = :group')
            ->andWhere('e.academicYear = :academicYear')
            ->setParameter('group', $group)
            ->setParameter('academicYear', $currentAcademicYear)
            ->orderBy('e.date')
            ->addOrderBy('s.surname')
            ->addOrderBy('s.name')
            ->addOrderBy('s.patronymic')
            ->getQuery()
            ->getResult();

        return [
            'currentAcademicYear' => $currentAcademicYear,
            'participations' => $participations,
        ];
    }
}
