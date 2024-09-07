<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('perPage', 10); // Lấy số lượng mục trên mỗi trang từ request, mặc định là 10
        $notifications = Notification::with('user')->paginate($perPage); 

        return view('pages.notification', compact('notifications')); 
    }
}
