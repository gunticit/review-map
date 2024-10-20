<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerCreateRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\NotificationService;

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
        $notifications = $this->notificationService->list($request);
        return view('pages.admin.notification.customer-list',[
            'notifications' => $notifications
        ]);
    }
    public function partner_list(Request $request)
    {
        $partner_ids = User::role('partner')->get()->pluck('id')->toArray();
        $request->merge(['user_ids' => $partner_ids]);
        $notifications = $this->notificationService->list($request);
        return view('pages.admin.notification.partner-list',[
            'notifications' => $notifications
        ]);
    }

    public function partner_create(Request $request){
        $deparments = Department::all();
        return view('pages.admin.notification.partner-create',[
            'departments' => $deparments
        ]);
    }

    public function customer_create(Request $request){
        $deparments = Department::all();
        return view('pages.admin.notification.customer-create',[
            'departments' => $deparments
        ]);
    }

    public function partner_delete($id){
        $this->notificationService->destroy($id);
        return redirect()->back();
    }
}
