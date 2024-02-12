<?php

namespace App\Jobs;

use App\Mail\ExportCompleted;
use App\Models\DailyLoan;
use App\Models\DailySavings;
use App\Models\Export;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use League\Csv\Writer;

class ExportDailyLoansJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
  public function handle(): void
  {
    // Define chunk size
    $chunkSize = 500;
    // Generate and export CSV file
    $filename = 'দৈনিক_ঋণ_তালিকা_রিপোর্ট_' . now()->format('d-m-Y_H-i-s') . '.csv';
    $path = 'exports/' . $filename;

    try {
      // Set status to "processing"
      DB::transaction(function () use ($filename) {
        Export::create([
          'file_name' => $filename,
          'status' => 'processing',
        ]);
      });

      $csv = Writer::createFromPath(Storage::path($path), 'w+');
      // Define the order of columns
      $columnOrder = [
        'account_no',
        'name',
        'per_installment',
        'opening_date',
        'interest',
        'adjusted_amount',
        'commencement',
        'loan_amount',
        'total',
        'balance',
        'status',
        'grace',
        'paid_interest',
      ];

      $csv->insertOne($columnOrder);

      DailyLoan::with('user')->chunk($chunkSize, function ($dailySavings) use ($csv, $columnOrder) {
        foreach ($dailySavings as $dailySaving) {
          // Map the array to ensure the correct order
          $mappedData = array_map(function ($column) use ($dailySaving) {
            if ($column === 'name') {
              return $dailySaving->user->name; // Access the 'name' field from the User model
            }
            return $dailySaving->{$column};
          }, $columnOrder);

          $csv->insertOne($mappedData);
        }
      });

      // Log information instead of using info()
      logger()->info('Export job completed successfully. CSV file stored at: ' . $path);

      // Set status to "completed"
      DB::transaction(function () use ($filename) {
        $export = Export::where('file_name', $filename)->first();
        if ($export) {
          $export->update(['status' => 'completed']);
        }
      });

      // Send email to admin
      Mail::to('ctgclasher101@gmail.com')->send(new ExportCompleted($filename));

      // Log information instead of using info()
      logger()->info('Export job completed successfully. CSV file stored at: ' . $path);
    } catch (\Exception $e) {
      // Set status to "failed" in case of an exception
      DB::transaction(function () use ($filename) {
        $export = Export::where('file_name', $filename)->first();
        if ($export) {
          $export->update(['status' => 'failed']);
        }
      });

      // Log the exception
      logger()->error('Export job failed: ' . $e->getMessage());

      // Rethrow the exception to let Laravel handle it
      throw $e;
    }
  }
}
