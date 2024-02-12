<?php

namespace App\Jobs;

use App\Mail\ExportCompleted;
use App\Models\Export;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use League\Csv\Writer;

class ExportUser implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public function handle()
  {
    // Define chunk size
    $chunkSize = 1000;

    // Generate and export CSV file
    $filename = 'সদস্য_তালিকা_রিপোর্ট_' . now()->format('d-m-Y_H-i-s') . '.csv';
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
        'name',
        'phone1',
        'phone2',
        'phone3',
        'present_address',
        'permanent_address',
        'occupation',
        'workplace',
        'father_name',
        'mother_name',
        'spouse_name',
        'marital_status',
        'join_date',
        'status',
        'wallet',
        'due'
      ];

      $csv->insertOne($columnOrder);

      User::chunk($chunkSize, function ($employees) use ($csv, $columnOrder) {
        foreach ($employees as $employee) {
          // Map the array to ensure the correct order
          $mappedData = array_map(function ($column) use ($employee) {
            return $employee->{$column};
          }, $columnOrder);

          $csv->insertOne($mappedData);
        }
      });

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

