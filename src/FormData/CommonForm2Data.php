<?php

namespace App\FormData;

use App\Entity\Group;
use App\Repository\AcademicYearRepository;

class CommonForm2Data implements FormDataInterface
{
    /**
     * @var \App\Repository\AcademicYearRepository
     */
    private AcademicYearRepository $academicYearRepository;

    public function __construct(AcademicYearRepository $academicYearRepository)
    {
        $this->academicYearRepository = $academicYearRepository;
    }

    public static function getFormId(): string
    {
        return 'form_obshaya2';
    }

    public static function getFormName(): string
    {
        return 'Форма списка обучающихся на учебный год';
    }

    public function getData(Group $group): array
    {
        $currentAcademicYear = $this->academicYearRepository->findCurrentAcademicYear();

        return [
            'currentAcademicYear' => $currentAcademicYear,
            'students' => $group->getStudents(),
        ];
    }
}
