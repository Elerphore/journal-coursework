<?php

namespace App\FormData;

use App\Entity\Group;
use App\Repository\AcademicYearRepository;
use App\Repository\ClasshourRepository;

class Form15Data implements FormDataInterface
{
    /**
     * @var \App\Repository\AcademicYearRepository
     */
    private AcademicYearRepository $academicYearRepository;

    /**
     * @var \App\Repository\ClasshourRepository
     */
    private ClasshourRepository $classhourRepository;

    public function __construct(AcademicYearRepository $academicYearRepository, ClasshourRepository $classhourRepository)
    {
        $this->academicYearRepository = $academicYearRepository;
        $this->classhourRepository = $classhourRepository;
    }

    public static function getFormId(): string
    {
        return 'form15';
    }

    public static function getFormName(): string
    {
        return 'Тематика и учет часов общения с обучающимися колледжа';
    }

    public function getData(Group $group): array
    {
        $currentAcademicYear = $this->academicYearRepository->findCurrentAcademicYear();

        $data = $this->classhourRepository->createQueryBuilder('c')
            ->where('c.group = :group')
            ->andWhere('c.academicYear = :academicYear')
            ->setParameter('group', $group)
            ->setParameter('academicYear', $currentAcademicYear)
            ->orderBy('c.date')
            ->addOrderBy('c.subject')
            ->getQuery()
            ->getResult();

        return [
            'currentAcademicYear' => $currentAcademicYear,
            'classhours' => $data,
        ];
    }
}
