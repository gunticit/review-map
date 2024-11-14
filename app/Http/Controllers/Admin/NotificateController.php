<?php

namespace App\Http\Controllers\Admin;

use App\Events\NotificationAdminEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerCreateRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\NotificationService;
use App\Events\NotificationEvent;
use App\Models\Role;
use App\Models\Notification;
use Illuminate\Support\Facades\Session;

class NotificateController extends Controller
{
    protected $notificationService;
    public function __construct(NotificationService $notificationService){
        $this->notificationService = $notificationService;
    }
    /**
     * Display a listing of the resource.
     */
    public function customer_list(Request $request)
    {
        $customer_ids = User::role('customer')->get()->pluck('id')->toArray();
        $request->merge(['user_ids' => $customer_ids]);
        $notifications = $this->notificationService->customer_list($request);
        return view('pages.admin.notification.customer-list',[
            'notifications' => $notifications
        ]);
    }
    public function partner_list(Request $request)
    {
        $partner_ids = User::role('partner')->get()->pluck('id')->toArray();
        $request->merge(['user_ids' => $partner_ids]);
        $notifications = $this->notificationService->partner_list($request);
        return view('pages.admin.notification.partner-list',[
            'notifications' => $notifications
        ]);
    }

    public function partner_detail($id){
        $notification = $this->notificationService->find($id);
        return view('pages.admin.notification.partner-detail',[
            'notification' => $notification
        ]);
    }

    public function partner_create(Request $request){
        return view('pages.admin.notification.partner-create');
    }

    public function customer_create(Request $request){
        $deparments = Department::all();
        return view('pages.admin.notification.customer-create');
    }

    public function partner_delete($id){
        $this->notificationService->destroy($id);
        return redirect()->back();
    }

    public function partner_store(Request $request)
    {
        try {
            $data = $request->all();
            $data['file_path'] = implode('|', $this->uploadImage($request));
            $partner_ids = User::role('partner')->get()->pluck('id')->toArray();
            $dataNotification = [];
            foreach($partner_ids as $partner_id) {
                $dataNotification = [
                    'user_id' => $partner_id,
                    'title' => $data['title'],
                    'content' => $data['content'],
                    'file_path' => $data['file_path'] ?? '',
                    'created_at' => now(),
                    'created_by' => auth()->user()->id
                ];
                $noti = Notification::create($dataNotification);
                event(new NotificationAdminEvent($noti->toArray(), $partner_id));
            }
            Session::flash('success', 'Tạo thông báo tới đối tác thành công');
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            Session::flash('success', 'Tạo thông báo tới đối tác không thành công');
            return redirect()->back()->withInput(); 
        }
    }

    public function customer_store(Request $request)
    {
        try {
            $data = $request->all();
            $data['filepath'] = implode('|', $this->uploadImage($request));
            $data['created_at'] = now();
            $customer_ids = User::role('customer')->get()->pluck('id')->toArray();
            $dataNotification = [];
            foreach($customer_ids as $customer_id) {
                $dataNotification = [
                    'user_id' => $customer_id,
                    'title' => $data['title'],
                    'content' => $data['content'],
                    'created_at' => $data['created_at'],
                    'created_by' => auth()->user()->id
                ];
                $noti = Notification::create($dataNotification);
                event(new NotificationAdminEvent($noti->toArray(), $customer_id));
            }
            Session::flash('success', 'Tạo thông báo tới đối tác thành công');
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            Session::flash('success', 'Tạo thông báo tới đối tác không thành công');
            return redirect()->back()->withInput(); 
        }   
    }

    public function uploadImage($request){
        $data = array();
        if ($request->hasFile('files')) {
            $folder = 'uploads' . '/notifications/' . date('Y-m') . '/' . date('d') . '/';
            foreach ($request->file('files') as $image) {
                $path = $image->store($folder, 'public');
                $data[] = $path;
            }
        }
        return $data;
    }

    public function customer_delete($id){
        $this->notificationService->destroy($id);
        return redirect()->back();
    }
}
