<?php

namespace App\FormData;

use App\Entity\Group;

interface FormDataInterface
{
    public static function getFormId(): string;

    public static function getFormName(): string;

    public function getData(Group $group): array;
}
