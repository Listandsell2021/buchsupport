<?php


namespace App\Libraries\HelperTraits;


use App\Models\Service;
use App\Models\User;

trait SortingEloquent
{


    public function scopeVsSorting($query, $sortingColumns, $defaultColumn = '', $defaultSort = '')
    {
        $sortingArray = $this->getSortingArray($sortingColumns);

        if (count($sortingArray) > 0) {
            foreach ($sortingArray as $sortItem) {
                $query->orderBy($sortItem['column'], $sortItem['order']);
            }
        } else {
            if (!empty($defaultColumn) && !empty($defaultSort)) {
                $query->orderBy($defaultColumn, $defaultSort);
            }
        }
    }

    /**
     * Sorting Array
     *
     * @return array
     */
    private function getSortingArray($sortingColumns): array
    {
        $columns = request()->get('columns');

        $sortingArray = [];

        foreach ($columns as $column) {
            if (in_array($column['key'], $sortingColumns) && $column['sort'] != 'none') {
                $sortingArray[] = [
                    'column'    => $column['key'],
                    'order'     => $column['sort']
                ];
            }
        }

        return $sortingArray;
    }

}
