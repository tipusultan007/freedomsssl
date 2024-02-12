<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateReportJob;
use App\Models\GeneratedReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class GeneratedReportController extends Controller
{
  public function generatePDF(Request $request)
  {
    // Save information in the GenerateReport model
    $report = new GeneratedReport();
    $report->name = $request->input('name');
    $report->category = $request->input('category');
    $report->file_type = 'pdf'; // Assuming the file type is always PDF
    $report->save();

    // Create a unique progress key for this report
    $progressKey = 'report_progress_' . $report->id;

    // Dispatch the job for report generation
    GenerateReportJob::dispatch($report->toArray(), $progressKey)->onQueue('reports');

    return response()->json(['message' => 'Report generation started.']);
  }

  public function checkReportProgress($id)
  {
    // Retrieve the GenerateReport model by ID
    $report = GeneratedReport::find($id);

    // Get the progress key
    $progressKey = 'report_progress_' . $id;

    // Retrieve the progress from Redis
    $progress = Redis::get($progressKey);

    // Respond with the progress data
    return response()->json(['progress' => $progress]);
  }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GeneratedReport $generatedReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GeneratedReport $generatedReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GeneratedReport $generatedReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GeneratedReport $generatedReport)
    {
        //
    }
}
