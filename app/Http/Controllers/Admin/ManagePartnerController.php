<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\TransactionHistory;
use App\Models\User;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class ManagePartnerController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function list(Request $request){
        $request = $request->merge([
            'type' => 'partner'
        ]);
        $partners = $this->userService->list($request);
        dd($partners);
        return view('pages.admin.manage.partner.list', [
            'partners' => $partners
        ]);
    }

    public function info(Request $request)
    {
        return view('pages.admin.manage.partner.info');
    }

    public function wallet(Request $request)
    {
        $orderBy = $request->order_by ?? 'id';
        $sort = $request->sort ?? 'desc';
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 10;
        $keyword = $request->keyword ?? '';
        
        $query = TransactionHistory::query()->with(['wallet', 'user']);

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('user', function ($subQuery) use ($keyword) {
                    $subQuery->whereRaw("unaccent(lower(name)) ILIKE unaccent(?)", ['%' . strtolower($keyword) . '%']);
                })
                ->orWhere('transaction_histories.id', 'like', "%{$keyword}%")
                ->orWhere('transaction_histories.reference_id', 'like', "%{$keyword}%")
                ->orWhere('transaction_histories.amount', 'like', "%{$keyword}%");
            });
        }

        if ($orderBy === 'user_name') {
            $query->join('wallets', 'transaction_histories.wallet_id', '=', 'wallets.id')
                ->join('users', 'wallets.user_id', '=', 'users.id')
                ->orderBy('users.name', $sort)
                ->select('transaction_histories.*');
        } else {
            $query->orderBy($orderBy, $sort);
        }

        $transactionHistories = $query->paginate($perPage, ['*'], 'page', $page)
            ->appends(request()->query());

        foreach ($transactionHistories as $transactionHistory) {
            $transactionHistory->formatted_created_at = $transactionHistory->created_at->format('d/m/Y H:i');
            $transactionHistory->payment_method = PaymentMethod::getLabel($transactionHistory->payment_method_id);
            $transactionHistory->amount = number_format($transactionHistory->amount, 0, ',', '.') . ' VND';
        }

        return view('pages.admin.manage.partner.wallet', compact('transactionHistories'));
    }

    public function project(Request $request)
    {
        $orderBy = $request->order_by ?? 'id';
        $sort = $request->sort ?? 'desc';
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 10;
        $keyword = $request->keyword ?? '';

        $query = Project::query()->with('missions');

        if ($keyword) {
            $query->whereRaw("unaccent(lower(name)) ILIKE unaccent(?)", ['%' . strtolower($keyword) . '%']);
        }

        if ($orderBy) {
            $query->orderBy($orderBy, $sort);
        }

        $projects = $query->paginate($perPage, ['*'], 'page', $page)
            ->appends(request()->query());

        foreach ($projects as $project) {
            $project->formatted_created_at = $project->created_at->format('d/m/Y H:i');
            $project->profit = number_format(10000, 0, ',', '.') . ' VND';
        }

        return view('pages.admin.manage.partner.project', compact('projects'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
    }

    public function update(Request $request, string $id)
    {
    }

    public function destroy(string $id)
    {
    }
}
