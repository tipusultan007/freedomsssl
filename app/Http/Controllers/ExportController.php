<?php

namespace App\Http\Controllers;

use App\Jobs\ExportDailyLoansJob;
use App\Jobs\ExportDailySavingsJob;
use App\Jobs\ExportDpsJob;
use App\Jobs\ExportDpsLoanJob;
use App\Jobs\ExportFdrJob;
use App\Jobs\ExportSpecialDpsJob;
use App\Jobs\ExportSpecialLoansJob;
use App\Models\Export;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $exports = Export::latest()->paginate(10);

    return view('exports.index', compact('exports'));
  }

  public function show(Export $export)
  {
    return view('exports.show', compact('export'));
  }

  public function download(Export $export)
  {
    $path = 'exports/' . $export->file_name;

    //return Storage::download($path);
    return response()->download(Storage::path($path), $export->file_name, [
      'Content-Type' => 'text/csv; charset=UTF-8',
      'Content-Disposition' => 'attachment; filename="' . $export->file_name . '"',
    ]);
  }

  public function destroy(Export $export)
  {
    $path = 'exports/' . $export->file_name;

    // Delete the file from storage
    Storage::delete($path);

    // Delete the export record from the database
    $export->delete();

    return redirect()->route('exports.index')->with('success', 'Export file deleted successfully');
  }

  /**
   * @throws \Exception
   */
  public function generateReport(Request $request)
  {
    switch ($request->type){
      case "daily_savings":
        dispatch(new ExportDailySavingsJob());
        break;
      case "daily_loans":
        dispatch(new ExportDailyLoansJob());
        break;
      case "dps_savings":
        dispatch(new ExportDpsJob());
        break;
      case "dps_loans":
        dispatch(new ExportDpsLoanJob());
        break;
      case "special_dps":
        dispatch(new ExportSpecialDpsJob());
        break;
      case "special_loans":
        dispatch(new ExportSpecialLoansJob());
        break;
      case "fdr":
        dispatch(new ExportFdrJob());
        break;
      default:
        throw new \Exception('Unexpected value');
    }

    return redirect()->back()->with('success','রিপোর্ট জেনারেশন প্রক্রিয়াধীন।');
  }
}
