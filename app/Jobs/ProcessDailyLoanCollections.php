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
//        $expNum = explode('-', $collection->account_no);
//        if (count($expNum) == 2) {
//          $collection->account_no = 'DS' . str_pad($expNum[1], 4, '0', STR_PAD_LEFT);
//          $collection->save();
//        }

//        $collection->dailyLoan->balance -= $collection->loan_installment;
//        $collection->dailyLoan->save();
//          $collection->user_id = $collection->dailyLoan->user_id;
//          $collection->save();

        Transaction::create([
          'account_no' => $collection->account_no,
          'user_id' => $collection->user_id,
          'amount' => $collection->loan_installment + $collection->loan_late_fee + $collection->loan_other_fee,
          'type' => 'cashin',
          'transactionable_id' => $collection->id,
          'transactionable_type' => DailyLoanCollection::class,
          'date' => $collection->date,
          'manager_id' => $collection->manager_id
        ]);

      }
    }
}
