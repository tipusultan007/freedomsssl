<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
  public function index(Request $request) {
    $query = Notification::query();
    $notificationType = '';
    // Check if a notification type filter is applied
    if ($request->has('notificationType')) {
      $notificationType = $request->input('notificationType');

      // Modify the query based on the selected notification type
      if ($notificationType == 'dps') {
        $query->where('notifiable_type', 'App\Models\DpsLoan');
      }elseif ($notificationType == 'special') {
        $query->where('notifiable_type', 'App\Models\SpecialDpsLoan');
      }else{
        $query->where('notifiable_type', 'App\Models\Fdr');
      }
      //$notificationType =  $request->input('notificationType');
    }

    $notifications = $query->paginate(30);

    return view('notifications', compact('notifications','notificationType'));
  }

}
