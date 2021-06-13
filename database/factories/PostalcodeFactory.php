<?php

namespace Database\Factories;

use App\Models\Postalcode;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostalcodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Postalcode::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => rand(700001, 700098)
        ];
    }
}
