<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
  public function index() {
    $notifications = Notification::paginate(30);
    return view('notifications',compact('notifications'));
  }
}
