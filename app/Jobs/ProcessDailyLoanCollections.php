<?php

namespace App\Jobs;

use App\Models\DailyLoan;
use App\Models\DailyLoanCollection;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessDailyLoanCollections implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  protected $collections;
    /**
     * Create a new job instance.
     */
    public function __construct($collections)
    {
        $this->collections = $collections;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
      foreach ($this->collections as $collection) {
        /*$collection->dailyLoan->balance -= $collection->loan_installment;
        $collection->dailyLoan->save();
        $collection->loan_balance = $collection->dailyLoan->balance;
        $collection->save();

        Transaction::create([
          'account_no' => $collection->account_no,
          'user_id' => $collection->user_id,
          'amount' => $collection->loan_installment,
          'type' => 'cashin',
          'transactionable_id' => $collection->id,
          'transactionable_type' => DailyLoanCollection::class,
          'date' => $collection->date,
          'manager_id' => $collection->manager_id
        ]);*/

      }
    }
}
