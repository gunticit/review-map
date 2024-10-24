<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Events\NotificationAdminEvent;

class NotificationController extends Controller
{
    public function indexCustomer(Request $request)
    {
        $perPage = $request->query('perPage', 10); // Lấy số lượng mục trên mỗi trang từ request, mặc định là 10
        $notifications = Notification::where('role', 'customer')->with('user')->orderBy('created_at', 'desc')->paginate($perPage); 
        return view('pages.notification', compact('notifications')); 
    }

    public function indexPartner(Request $request)
    {
        $perPage = $request->query('perPage', 10); // Lấy số lượng mục trên mỗi trang từ request, mặc định là 10
        $notifications = Notification::where('role', 'customer')->with('user')->orderBy('created_at', 'desc')->paginate($perPage); 
        return view('pages.notification', compact('notifications')); 
    }

    public function ajaxNotification(Request $request) 
    {
        $data = Notification::where('user_id', $request->user_id)->orderBy('created_at', 'desc')->paginate(10)->toArray();
        $countUnread = Notification::where('user_id', $request->user_id)->whereNull('read_at')->count();
        $data['countUnread'] = $countUnread;
        return response()->json($data);
    }

    public function ajaxMakeRead(Request $request) 
    {
        Notification::where('id', $request->id)->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    }
}
