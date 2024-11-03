<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\TransactionHistory;
use App\Models\User;
use App\Services\ExpenditureStatisticService;
use App\Services\ProjectService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class ManagePartnerController extends Controller
{
    protected $userService, $expenditure, $projectService;
    public function __construct(
        UserService $userService, 
        ExpenditureStatisticService $expenditureStatisticService,
        ProjectService $projectService
    )
    {
        $this->userService = $userService;
        $this->expenditure = $expenditureStatisticService;
        $this->projectService = $projectService;
    }
    public function list(Request $request){
        $request = $request->merge([
            'type' => 'partner'
        ]);
        $partners = $this->userService->list($request);
        $heading_title = 'Danh sách đối tác';
        return view('pages.admin.manage.partner.list', [
            'partners' => $partners,
            'heading_title' => $heading_title
        ]);
    }

    public function info(Request $request, $id)
    {
        $partner_info = $this->userService->find($id);
        $expenditure_info = $this->expenditure->getAllExpenditureByUser($partner_info->id);
        $project_info = $this->projectService->list($request);

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
        return view('pages.admin.manage.partner.info',[
            'partner_id' => $id,
            'partner_info' => $partner_info,
            'project_info' => $project_info,
            'expenditure_info' => $expenditure_info,
            'projects' => $projects
        ]);
    }

    public function wallet(Request $request, $id)
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
            $transactionHistory->payment_method = $transactionHistory->payment_method_id ? PaymentMethod::getLabel($transactionHistory->payment_method_id) : '';
            $transactionHistory->amount = number_format($transactionHistory->amount, 0, ',', '.') . ' VND';
        }

        return view('pages.admin.manage.partner.wallet', [
            'transactionHistories' => $transactionHistories,
            'partner_id' => $id
        ]);
    }

    public function project(Request $request, $id)
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

        return view('pages.admin.manage.partner.project', [
            'projects' => $projects,
            'partner_id' => $id
        ]);
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
        return view('pages.admin.manage.partner.edit');
    }

    public function update(Request $request, string $id)
    {
    }

    public function destroy(string $id)
    {
    }
}
