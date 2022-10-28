<?php

namespace App\FormData;

use App\Entity\Group;
use App\Repository\AcademicYearRepository;
use App\Repository\ParentsMeetingRepository;

class CommonForm1Data implements FormDataInterface
{
    /**
     * @var \App\Repository\AcademicYearRepository
     */
    private AcademicYearRepository $academicYearRepository;

    /**
     * @var \App\Repository\ParentsMeetingRepository
     */
    private ParentsMeetingRepository $parentsMeetingRepository;

    public function __construct(AcademicYearRepository $academicYearRepository, ParentsMeetingRepository $parentsMeetingRepository)
    {
        $this->academicYearRepository = $academicYearRepository;
        $this->parentsMeetingRepository = $parentsMeetingRepository;
    }

    public static function getFormId(): string
    {
        return 'form_obshaya1';
    }

    public static function getFormName(): string
    {
        return 'Планируемая тематика родительских собраний';
    }

    public function getData(Group $group): array
    {
        $currentAcademicYear = $this->academicYearRepository->findCurrentAcademicYear();

        $data = $this->parentsMeetingRepository->createQueryBuilder('pm')
            ->where('pm.group = :group')
            ->andWhere('pm.academicYear = :academicYear')
            ->setParameter('group', $group)
            ->setParameter('academicYear', $currentAcademicYear)
            ->orderBy('pm.date')
            ->addOrderBy('pm.subject')
            ->getQuery()
            ->getResult();

        return [
            'currentAcademicYear' => $currentAcademicYear,
            'parentsMeetings' => $data,
        ];
    }
}
