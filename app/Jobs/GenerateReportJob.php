<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;
use Mpdf\Mpdf;

class GenerateReportJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $reportData;
  protected $progressKey;

  /**
   * Create a new job instance.
   *
   * @param array $reportData
   * @param string $progressKey
   */
  public function __construct($reportData, $progressKey)
  {
    $this->reportData = $reportData;
    $this->progressKey = $progressKey;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    // Initial progress
    $this->setProgress(0);

    // Your logic to generate the PDF content
    $pdfContent = view('pdf.template')->render();
    $mpdf = new Mpdf();
    $mpdf->WriteHTML($pdfContent);

    // Save the PDF to storage
    $pdfPath = 'pdf-reports/' . uniqid() . '.pdf';
    $storagePath = storage_path('app/' . $pdfPath);
    $mpdf->Output($storagePath, 'F');

    // Update progress to 100%
    $this->setProgress(100);

    // Save information in the GenerateReport model or perform other necessary operations
  }

  /**
   * Set the progress value in Redis.
   *
   * @param int $progress
   */
  protected function setProgress($progress)
  {
    Redis::set($this->progressKey, $progress);
  }
}
