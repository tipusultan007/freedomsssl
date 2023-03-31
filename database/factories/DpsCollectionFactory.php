<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\DpsCollection;
use Illuminate\Database\Eloquent\Factories\Factory;

class DpsCollectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DpsCollection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_no' => $this->faker->text(255),
            'dps_amount' => $this->faker->randomNumber(0),
            'balance' => $this->faker->randomNumber(0),
            'receipt_no' => $this->faker->text(255),
            'late_fee' => $this->faker->randomNumber(0),
            'other_fee' => $this->faker->randomNumber(0),
            'advance' => $this->faker->randomNumber(0),
            'month' => $this->faker->monthName,
            'year' => $this->faker->year,
            'trx_id' => $this->faker->text(255),
            'date' => $this->faker->date,
            'collector_id' => \App\Models\User::factory(),
            'user_id' => \App\Models\User::factory(),
            'dps_id' => \App\Models\Dps::factory(),
            'dps_installment_id' => \App\Models\DpsInstallment::factory(),
        ];
    }
}
