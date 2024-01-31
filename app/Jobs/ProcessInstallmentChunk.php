<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\DpsInstallment;

class ProcessInstallmentChunk implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $installments;

  public function __construct($installments)
  {
    $this->installments = $installments;
  }

  public function handle()
  {
    foreach ($this->installments as $installment) {
      $dps = DpsInstallment::find($installment->max_id);
      $dps->dps_installments = $installment->installments;
      $dps->save();
    }
  }
}
