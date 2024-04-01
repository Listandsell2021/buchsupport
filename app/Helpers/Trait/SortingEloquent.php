<?php

namespace App\Helpers\Trait;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use function Psy\debug;

trait SortingEloquent
{
    /**
     * Sorting
     *
     * @param $query
     * @param array $sortingColumns
     * @param string $defaultColumn
     * @param string $defaultSort
     * @return void
     */
    public function scopeSorting($query, array $sortingColumns, string $defaultColumn = '', string $defaultSort = ''): void
    {
        $sortingArray = $this->getSortingArray($sortingColumns);

        if (count($sortingArray) > 0) {

            foreach ($sortingArray as $sortItem) {
                $query->orderBy(DB::raw("ISNULL(".$sortItem['column']."), ".$sortItem['column']), $sortItem['order']);
            }
        } else {
            if (!empty($defaultColumn) && !empty($defaultSort)) {
                //$query->orderBy(DB::raw("ISNULL(".$defaultColumn."), ".$defaultColumn), $defaultSort);
                $query->orderBy($defaultColumn, $defaultSort);
            }
        }
    }

    /**
     * Sorting Array
     *
     * @param array $sortingColumns
     * @return array
     */
    private function getSortingArray(array $sortingColumns): array
    {
        $columns = request()->input('columns');

        if (!$columns) {
            return [];
        }

        $sortingArray = [];

        foreach ($columns as $column) {

            if (
                isset($column['key']) &&
                isset($column['sort']) &&
                in_array($column['key'], $sortingColumns) &&
                in_array($column['sort'], ['asc', 'desc'])
            ) {
                $sortingArray[] = [
                    'column'    => $column['key'],
                    'order'     => $column['sort']
                ];
            }
        }

        return $sortingArray;
    }

}
