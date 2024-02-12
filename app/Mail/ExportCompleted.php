<?php

namespace App\Mail;

use App\Models\Export;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExportCompleted extends Mailable
{
  use Queueable, SerializesModels;

  public $filename;
  public $downloadUrl;

  public function __construct($filename)
  {
    $this->filename = $filename;
    $this->downloadUrl = route('download.export', ['filename' => $filename]);
  }

  public function build()
  {
    $subject = 'Export Completed: ' . $this->filename;

    return $this->subject($subject)->view('mail.export.completed');
  }
}
