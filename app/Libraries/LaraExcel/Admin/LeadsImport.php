<?php

namespace App\Libraries\LaraExcel\Admin;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\ToModel;

class LeadsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $gender = ['male', 'female'];

        return new Lead([
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'gender' => $gender[array_rand($gender)],
            'phone_no' => fake()->phoneNumber(),
            'street' => fake()->streetAddress(),
            'postal_code' => fake()->postcode(),
            'city' => $row[0],
            'country' => $row[1],
            'map_longitude' => fake()->longitude(),
            'map_latitude' => fake()->latitude(),
        ]);
    }
}
