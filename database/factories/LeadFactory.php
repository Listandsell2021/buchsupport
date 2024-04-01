<?php

namespace Database\Factories;


use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class LeadFactory extends Factory
{
    protected $model = Lead::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = ['male', 'female'];
        $leadStatusId = 1;
        $countries = ['Germany', 'Belgium', 'Croatia', 'France', 'Italy', 'Netherlands', 'Poland', 'Portugal', 'Spain', 'Switzerland'];

        $latitude = 27.6947603;
        $longitude = 85.3700714;

        $center = [
            'lng' => $longitude,
            'lat' => $latitude
        ];

        $mapLocation = $this->generateRandomPoint($center, 1000);

        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'gender' => $gender[array_rand($gender)],
            'phone_no' => fake()->phoneNumber(),
            'street' => fake()->streetAddress(),
            'postal_code' => rand(0, 99999),
            'city' => fake()->city(),
            'country' => $countries[array_rand($countries)],
            'map_longitude' => $mapLocation['lng'],
            'map_latitude' => $mapLocation['lat'],
            'lead_status_id' => $leadStatusId,
        ];
    }


    private function generateRandomPoints($center, $radius, $count): array
    {
        $points = [];
        for ($i=0; $i<$count; $i++) {
            $points[] = $this->generateRandomPoint($center, $radius);
        }
        return $points;
   }


    /**
     * Generates number of random geolocation points given a center and a radius.
     * Reference URL: http://goo.gl/KWcPE.
     * @param $center
     * @param $radius
     * @return array {Object} The generated random points as JS object with lat and lng attributes.
     */
    public function generateRandomPoint($center, $radius): array
    {
        $x0 = $center['lng'];
        $y0 = $center['lat'];

        // Convert Radius from meters to degrees->
        $rd = $radius/111300;

        $u = $this->random();
        $v = $this->random();

        $w = $rd * sqrt($u);
        $t = 2 * pi() * $v;
        $x = $w * cos($t);
        $y = $w * sin($t);

        $xp = $x/cos($y0);

        // Resulting point.
        return ['lat'=> $y+$y0, 'lng'=> $xp+$x0];
    }

    private function random(): float
    {
        return (float)rand()/(float)getrandmax();
    }


}
