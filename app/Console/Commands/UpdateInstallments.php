<?php

namespace App\Console\Commands;

use App\Jobs\ProcessDpsInstallments;
use App\Jobs\ProcessInstallment;
use Illuminate\Console\Command;
use App\Jobs\ProcessInstallmentChunk;
use App\Models\DpsInstallment;

class UpdateInstallments extends Command
{
  protected $signature = 'update:installments';

  protected $description = 'Update installments using jobs and chunks';

  public function handle()
  {
    $this->info('Dispatching jobs for updating installments...');

//    DpsInstallment::groupBy('account_no', 'date')
//      ->select('account_no', 'date', \DB::raw('MAX(id) as max_id'), \DB::raw('COUNT(id) as installments'))
//      ->get()
//      ->each(function ($installment) {
//        ProcessInstallment::dispatch($installment->account_no, $installment->date, $installment->max_id, $installment->installments);
//      });

    $chunkSize = 5000;
    $page = 1;
    do {
      $collections = DpsInstallment::with('user')->orderBy('date','asc')->skip(($page - 1) * $chunkSize)
        ->take($chunkSize)
        ->get();

      if ($collections->isNotEmpty()) {
        ProcessDpsInstallments::dispatch($collections);
      }

      $page++;
    } while ($collections->count() === $chunkSize);

    $this->info('Jobs dispatched.');
  }
}
