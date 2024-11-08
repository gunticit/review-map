<?php
namespace App\Repositories\TransactionHistory;

use App\Models\TransactionHistory;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\Repositories\TransactionHistory\TransactionHistoryRepositoryInterface;

class TransactionHistoryRepository extends BaseRepository implements TransactionHistoryRepositoryInterface
{
    protected $model;

    public function __construct(TransactionHistory $transactionHistory)
    {
        $this->model = $transactionHistory;
    }

    public function handleFilter(){
        $query = $this->model->query();
        return $query;
    }

    public function list($request){
        $query = $this->handleFilter();
        $query->with(['created_by','paymentMethod']);
        $orderBy = $request->order_by ?? [];
        if(!empty($orderBy)){
            foreach ($orderBy as $column => $direction) {
                $query->orderBy($column, $direction);
            }
        }
        
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 15;
        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function fullList($request){
        $query = $this->handleFilter();
        $query->with(['created_by','paymentMethod']);
        $orderBy = $request->order_by ?? [];
        if(!empty($orderBy)){
            foreach ($orderBy as $column => $direction) {
                $query->orderBy($column, $direction);
            }
        }
        return $query->get();
    }

    public function listHistoriesByUser($user_id){
        $query = $this->handleFilter();
        $query->leftjoin('wallets', 'wallets.id', '=', 'transaction_histories.wallet_id');
        $query->where('user_id', $user_id);
        $query->select('*','transaction_histories.id as history_id');
        $orderBy = $request->order_by ?? [];
        if(!empty($orderBy)){
            foreach ($orderBy as $column => $direction) {
                $query->orderBy($column, $direction);
            }
        }
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 15;
        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function totalMoneyHistoriesByField($request){
        $query = $this->handleFilter();
        $query = $query->with(['created_by','wallet' => function($query) use ($request) {
            if (!empty($request->user_id)) {
                $query->where('user_id', $request->user_id);
            }
        }]);
        if(isset($request->type)){
            $query->where('type', $request->type);
        }
        if(isset($request->year)){
            $query->whereYear('created_at', $request->year);
        }
        $monthlyTotals = $query->select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(amount) as total')
        )
        ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
        ->get();

        // Tính tổng cả năm
        $yearlyTotal = $query->sum('amount');

        return [
            'monthly_totals' => $monthlyTotals,
            'yearly_total' => $yearlyTotal,
        ];
    }
}
