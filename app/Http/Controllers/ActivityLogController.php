<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
  public function index(Request $request)
  {
    // Get manager ID from the request
    $managerId = $request->input('manager_id');

    // Get start and end date from the request (assuming you have date inputs in your form)
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Query activity logs based on filters
    $activityLogsQuery = Activity::query();

    if ($managerId) {
      $activityLogsQuery->where('causer_id', $managerId);
    }

    if ($startDate && $endDate) {
      $activityLogsQuery->whereDate('created_at', '>=', $startDate)
        ->whereDate('created_at', '<=', $endDate);
    }
    // Get the filtered logs
    $activityLogs = $activityLogsQuery->latest()->paginate(30);
    return view('activity-log.index', compact('activityLogs'));
  }
}
