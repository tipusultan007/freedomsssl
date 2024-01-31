<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\DpsInstallment;

class ProcessInstallment implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $accountNo;
  protected $date;
  protected $maxId;
  protected $installments;

  public function __construct($accountNo, $date, $maxId, $installments)
  {
    $this->accountNo = $accountNo;
    $this->date = $date;
    $this->maxId = $maxId;
    $this->installments = $installments;
  }

  public function handle()
  {
    //$installment = DpsInstallment::find($this->maxId);
    $installments = DpsInstallment::where('account_no',$this->accountNo)
      ->where('date', $this->date)->get();

    foreach ($installments as $installment){
      if ($installment->id != $this->maxId){
        $installment->delete();
      }
    }
  }
}
