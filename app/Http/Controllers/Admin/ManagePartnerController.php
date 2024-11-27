<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\TransactionHistory;
use App\Models\User;
use App\Models\Wallet;
use App\Services\ExpenditureStatisticService;
use App\Services\ProjectService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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

        // if ($orderBy) {
        //     $query->orderBy($orderBy, $sort);
        // }
        // $projects = $query->paginate($perPage, ['*'], 'page', $page)
        //     ->appends(request()->query());
        $projects = $query->get();

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

    public function wallet(Request $request, $user_id)
    {
        $wallet = Wallet::where('user_id', $user_id)->first();
        $type_transaction = config('constants.type_histories');
        if(!empty($wallet->id)){
            $transactionHistories = TransactionHistory::leftjoin('wallets', 'wallets.id', '=', 'transaction_histories.wallet_id')
            ->where('transaction_histories.wallet_id', $wallet->id)->get();
        }
        $data_transaction = array();
        $user_name = User::find($user_id)->name;
        if(!empty($transactionHistories)){
            foreach($transactionHistories as $transactionHistory){
                $data_transaction[] = [
                    'id' => $transactionHistory->id,
                    'wallet_id' => $transactionHistory->wallet_id,
                    'reference_id' => $transactionHistory->reference_id,
                    'payment_method' => $transactionHistory->type,
                    'amount' => $transactionHistory->amount,
                    'user_name' => $user_name,
                    'created_at' => $transactionHistory->created_at,
                    'status' => $transactionHistory->status,
                    'transaction_code' => $transactionHistory->transaction_code,
                    'type' => $type_transaction[$transactionHistory->type]
                ];
            }
        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;  // Adjust as needed
        $currentItems = array_slice($data_transaction, ($currentPage - 1) * $perPage, $perPage);

        $data_transaction = new LengthAwarePaginator(
            $currentItems,
            count($data_transaction),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
        return view('pages.admin.manage.partner.wallet', [
            'transactionHistories' => $data_transaction,
            'partner_id' => $user_id
        ]);
    }

    public function project(Request $request, $user_id)
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
            'partner_id' => $user_id
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
