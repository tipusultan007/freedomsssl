<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\LoanDocuments;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanDocumentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LoanDocuments::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_no' => $this->faker->text(255),
            'document_name' => $this->faker->text(255),
            'document_location' => $this->faker->text(255),
            'date' => $this->faker->date,
            'collect_by' => \App\Models\User::factory(),
            'taken_loan_id' => \App\Models\TakenLoan::factory(),
        ];
    }
}
