<?php


namespace App\Libraries\HelperTraits;


use App\Models\Service;
use App\Models\User;

trait SortingHelper
{


    /**
     * Get Sorting Key
     *
     * @param $key
     * @return string
     */
    private function getSortingKey($key, $array): string
    {
        if (in_array($key, $array)) {
            return $key;
        }
        return '';
    }

    /**
     * Get Sort Order
     * @param $key
     * @param string $default
     * @return string
     */
    private function getSortOrder($key, string $default = 'asc'): string
    {
        if (in_array($key, ['asc', 'desc'])) {
            return $key;
        }
        return $default;
    }


}
