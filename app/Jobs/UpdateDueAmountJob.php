<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\DpsInstallment;

class UpdateDueAmountJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $installmentId;

  public function __construct($installmentId)
  {
    $this->installmentId = $installmentId;
  }

  public function handle()
  {
    $installment = DpsInstallment::find($this->installmentId);

    if ($installment) {
      // Update due_amount to null for records with the same trx_id except the one with the minimum id
      DpsInstallment::where('trx_id', $installment->trx_id)
        ->where('id', '!=', $installment->id)
        ->update(['due' => null]);
    }
  }
}
