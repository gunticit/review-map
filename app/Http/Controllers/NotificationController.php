<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('perPage', 10); // Lấy số lượng mục trên mỗi trang từ request, mặc định là 10
        $notifications = Notification::where('user_id', Auth::user()->id)->with('user');
        if(!empty($request->keyword)){
            $notifications = $notifications->where(function($query) use ($request){
                $query->where('title', 'like', '%'.$request->keyword.'%')
                    ->orWhere('content', 'like', '%'.$request->keyword.'%');
            });
        }
        $notifications = $notifications->orderBy('created_at', 'desc')->paginate($perPage); 
        return view('pages.notification.list', compact('notifications')); 
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

    public function ajaxDeleteNotification(Request $request){
        Notification::where('id', $request->id)->delete();
        return response()->json(['success' => true]);
    }

    public function show($id){
        $notification = Notification::find($id);
        if(empty($notification)){
            return redirect()->route('notification');
        }
        if(is_null($notification->read_at)){
            Notification::where('id', $id)->update(['read_at' => now(), 'status' => 1]);
        }
        return view('pages.notification.detail', ['notification' => $notification]);
    }
}
