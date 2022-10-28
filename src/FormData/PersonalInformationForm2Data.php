<?php

namespace App\FormData;

use App\Entity\Group;
use App\Repository\AcademicYearRepository;
use App\Repository\StudentRepository;

class PersonalInformationForm2Data implements FormDataInterface
{
    /**
     * @var \App\Repository\AcademicYearRepository
     */
    private AcademicYearRepository $academicYearRepository;

    /**
     * @var \App\Repository\StudentRepository
     */
    private StudentRepository $studentRepository;

    public function __construct(
        AcademicYearRepository $academicYearRepository,
        StudentRepository $studentRepository
    ) {
        $this->academicYearRepository = $academicYearRepository;
        $this->studentRepository = $studentRepository;
    }

    public static function getFormId(): string
    {
        return 'form_pers_dannie2';
    }

    public static function getFormName(): string
    {
        return 'Лист здоровья';
    }

    public function getData(Group $group): array
    {
        $currentAcademicYear = $this->academicYearRepository->findCurrentAcademicYear();

        $students = $this->studentRepository->createQueryBuilder('s')
            ->select('s, hg')
            ->innerJoin('s.healthgroup', 'hg')
            ->where('s.group = :group')
            ->setParameter('group', $group)
            ->orderBy('s.surname')
            ->addOrderBy('s.name')
            ->addOrderBy('s.patronymic')
            ->getQuery()
            ->getResult();

        return [
            'currentAcademicYear' => $currentAcademicYear,
            'students' => $students,
        ];
    }
}
