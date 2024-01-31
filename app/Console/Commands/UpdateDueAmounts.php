<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UpdateDueAmountJob;
use App\Models\DpsInstallment;

class UpdateDueAmounts extends Command
{
  protected $signature = 'update:due-amounts';

  protected $description = 'Update due amounts using jobs';

  public function handle()
  {
    $this->info('Dispatching jobs for updating due amounts...');

    DpsInstallment::where('due', '>', 0)->groupBy(['trx_id', 'id'])
      ->select('trx_id', \DB::raw('MAX(id) as id'))
      ->chunk(5000, function ($installments) {
        foreach ($installments as $installment) {
          UpdateDueAmountJob::dispatch($installment->id);
        }
      });

    $this->info('Jobs dispatched.');
  }
}
