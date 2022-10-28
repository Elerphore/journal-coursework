<?php

namespace App\FormData;

use App\Entity\Group;
use DateTime;

class Form13Data implements FormDataInterface
{
    public static function getFormId(): string
    {
        return 'form13';
    }

    public static function getFormName(): string
    {
        return 'Индивидуальная работа с родителями';
    }

    public function getData(Group $group): array
    {
        return [
            'data' => [
                ['fio' => 'Фамилия Имя Отчество', 'discussion' => 'Обсуждаемые вопросы', 'date' => new DateTime('2022-05-15')],
                ['fio' => 'Фамилия Имя Отчество', 'discussion' => 'Обсуждаемые вопросы', 'date' => new DateTime('2022-05-15')],
                ['fio' => 'Фамилия Имя Отчество', 'discussion' => 'Обсуждаемые вопросы', 'date' => new DateTime('2022-05-15')],
                ['fio' => 'Фамилия Имя Отчество', 'discussion' => 'Обсуждаемые вопросы', 'date' => new DateTime('2022-05-15')],
                ['fio' => 'Фамилия Имя Отчество', 'discussion' => 'Обсуждаемые вопросы', 'date' => new DateTime('2022-05-15')],
                ['fio' => 'Фамилия Имя Отчество', 'discussion' => 'Обсуждаемые вопросы', 'date' => new DateTime('2022-05-15')],
                ['fio' => 'Фамилия Имя Отчество', 'discussion' => 'Обсуждаемые вопросы', 'date' => new DateTime('2022-05-15')],
                ['fio' => 'Фамилия Имя Отчество', 'discussion' => 'Обсуждаемые вопросы', 'date' => new DateTime('2022-05-15')],
                ['fio' => 'Фамилия Имя Отчество', 'discussion' => 'Обсуждаемые вопросы', 'date' => new DateTime('2022-05-15')],
                ['fio' => 'Фамилия Имя Отчество', 'discussion' => 'Обсуждаемые вопросы', 'date' => new DateTime('2022-05-15')],
                ['fio' => 'Фамилия Имя Отчество', 'discussion' => 'Обсуждаемые вопросы', 'date' => new DateTime('2022-05-15')],
                ['fio' => 'Фамилия Имя Отчество', 'discussion' => 'Обсуждаемые вопросы', 'date' => new DateTime('2022-05-15')],
                ['fio' => 'Фамилия Имя Отчество', 'discussion' => 'Обсуждаемые вопросы', 'date' => new DateTime('2022-05-15')],
                ['fio' => 'Фамилия Имя Отчество', 'discussion' => 'Обсуждаемые вопросы', 'date' => new DateTime('2022-05-15')],
            ],
        ];
    }
}
