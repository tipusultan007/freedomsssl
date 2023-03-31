<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\DpsLoanCollection;
use Illuminate\Database\Eloquent\Factories\Factory;

class DpsLoanCollectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DpsLoanCollection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_no' => $this->faker->text(255),
            'trx_id' => $this->faker->text(255),
            'loan_installment' => $this->faker->randomNumber(0),
            'balance' => $this->faker->randomNumber(0),
            'interest' => $this->faker->randomNumber(0),
            'date' => $this->faker->date,
            'receipt_no' => $this->faker->text(255),
            'user_id' => \App\Models\User::factory(),
            'dps_loan_id' => \App\Models\DpsLoan::factory(),
            'collector_id' => \App\Models\User::factory(),
            'dps_installment_id' => \App\Models\DpsInstallment::factory(),
        ];
    }
}
