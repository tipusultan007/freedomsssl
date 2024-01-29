<?php

namespace App\Jobs;

use App\Models\DailySavings;
use App\Models\SavingsCollection;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ProcessSavingsCollections implements ShouldQueue
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
//        if (count($expNum) > 0) {
//          $collection->account_no = 'DS' . str_pad($expNum[1], 4, '0', STR_PAD_LEFT);
//          $collection->save();
//        }
//        $saving = DailySavings::where('account_no',$collection->account_no)->first();
//        if ($saving){
//          $collection->daily_savings_id = $saving->id;
//          $collection->save();
//        }
        switch ($collection->type){
          case 'deposit':
            $collection->dailySavings->deposit += $collection->saving_amount;
            $collection->dailySavings->total += $collection->saving_amount;
            $collection->dailySavings->balance += $collection->saving_amount;
            $collection->dailySavings->save();
            $collection->total = $collection->saving_amount;
            $collection->balance = $collection->dailySavings->total;
            $collection->save();

            Transaction::create([
              'account_no' => $collection->account_no,
              'user_id' => $collection->user_id,
              'amount' => $collection->total,
              'type' => 'cashin',
              'transactionable_id' => $collection->id,
              'transactionable_type' => SavingsCollection::class,
              'date' => $collection->date,
              'manager_id' => $collection->manager_id
            ]);

            break;
          case 'withdraw':
            $collection->dailySavings->withdraw += $collection->saving_amount;
            $collection->dailySavings->total -= $collection->saving_amount;
            $collection->dailySavings->balance -= $collection->saving_amount;
            $collection->dailySavings->save();
            $collection->total = $collection->saving_amount;
            $collection->balance = $collection->dailySavings->total;
            $collection->save();

            Transaction::create([
              'account_no' => $collection->account_no,
              'user_id' => $collection->user_id,
              'amount' => $collection->total,
              'type' => 'cashout',
              'transactionable_id' => $collection->id,
              'transactionable_type' => SavingsCollection::class,
              'date' => $collection->date,
              'manager_id' => $collection->manager_id
            ]);
            break;
        }
      }
    }
}
