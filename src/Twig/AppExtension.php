<?php

namespace App\Twig;

use App\Entity\Role;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

use function Symfony\Component\String\u;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('ensure_end', [$this, 'ensureEnd']),
            new TwigFilter('group_by', [$this, 'groupBy']),
            new TwigFilter('role_name', [$this, 'roleName']),
        ];
    }

    public function ensureEnd(string $string, string $suffix): string
    {
        return u($string)->ensureEnd($suffix)->toString();
    }

    public function roleName(string $role): string
    {
        return Role::ROLE_NAMES[$role] ?? 'Пользователь';
    }
    /**
     * @param array $array
     * @param string|callable $groupBy
     *
     * @return array
     */
    public function groupBy(array $array, $groupBy): array
    {
        $groups = [];

        if (is_string($groupBy)) {
            foreach ($array as $row) {
                $groups[$row[$groupBy]][] = $row;
            }
        } elseif (is_callable($groupBy)) {
            foreach ($array as $row) {
                $groups[$groupBy($row)][] = $row;
            }
        }

        return $groups;
    }
}
