<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique->email,
           /* 'phone' => $this->faker->phoneNumber,*/
            'password' => \Hash::make('password'),
            /*'present_address' => $this->faker->text,
            'permanent_address' => $this->faker->text,
            'national_id' => $this->faker->text(255),
            'birth_id' => $this->faker->text(255),*/
            'gender' => \Arr::random(['male', 'female', 'other']),
           /* 'birthdate' => $this->faker->date,
            'father_name' => $this->faker->text(255),
            'mother_name' => $this->faker->text(255),*/
            'status' => \Arr::random(['active', 'inactive']),
            'join_date' => $this->faker->date,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
