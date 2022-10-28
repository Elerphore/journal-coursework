<?php

namespace App\FormData;

use App\Entity\Group;
use App\Repository\AcademicYearRepository;

class PersonalInformationForm1Data implements FormDataInterface
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
        return 'form_pers_dannie1';
    }

    public static function getFormName(): string
    {
        return 'Сводная информация по группе';
    }

    public function getData(Group $group): array
    {
        $currentAcademicYear = $this->academicYearRepository->findCurrentAcademicYear();

        return [
            'currentAcademicYear' => $currentAcademicYear,
        ];
    }
}
