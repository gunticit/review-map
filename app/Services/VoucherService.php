<?php

namespace App\Services;
use Illuminate\Support\Str;
use App\Repositories\Voucher\VoucherRepositoryInterface;
use App\Http\Resources\VoucherResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class VoucherService {
    protected $voucherRepository, $historyService;

    public function __construct(
        VoucherRepositoryInterface $voucherRepository,
        HistoryService $historyService,
    )
    {
        $this->voucherRepository = $voucherRepository;
        $this->historyService = $historyService;
    }

    /**
     * Authenticates the voucher with the given credentials.
     *
     * @param array $credentials The voucher's login credentials.
     * @return mixed|null The authenticated voucher if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        $vouchers = $this->voucherRepository->list($request);
        return $vouchers;
    }

    public function fullList($request){
        $vouchers = $this->voucherRepository->list($request);
        return $vouchers;
    }

    public function create($request){
        $voucher = $this->filterData($request);
        $data = $this->voucherRepository->create($voucher);
        return $data;
    }

    public function show($id){
        $data = $this->voucherRepository->find($id);
        return $data;
    }

    public function update($request, $id){
        $voucher = $this->filterData($request);
        $data = $this->voucherRepository->update($voucher, $id);
        return $data; 
    }

    public function delete($id){
        $data = $this->voucherRepository->delete($id);
        return $data;
    }

    public function checkAjaxApplyVoucher($request){
        $voucher_code = $request->voucher_code;
        $check_voucher = $this->voucherRepository->checkAjaxApplyVoucher($voucher_code);
        $history = [
            [
                'content' => json_encode([
                    'title' => 'Thanh toán dự án',
                    'content' => 'Bạn đã sử dụng mã voucher: ' . $voucher_code . (empty($check_voucher) ? ' lỗi' : ' thành công'),
                    'status' => empty($check_voucher) ? 'fail' : 'success', 
                    'user_id' => Auth::user()->id
                ]),
                'user_id' => Auth::user()->id
            ]
        ];
        $this->updateHistory($history);
        return $check_voucher;
    }

    private function filterData($request): array{
        return array(
            'code' => $request->code ?? '',
            'name' => $request->name ?? '',
            'description' => $request->description ?? null,
            'discount_type' => $request->discount_type ?? null,
            'discount_value' => $request->discount_value ?? 0,
            'start_date' => $request->start_date ?? null,
            'end_date' => $request->end_date ?? null,
            'max_uses' => $request->max_uses ?? 0,
            'uses_left' => $request->uses_left ?? 0,
            'status' => $request->status ?? 'active',
            'min_order_value' => $request->min_order_value ?? null
        );
    }

    public function updateHistory($histories = array()){
        if(!empty($histories)){
            $histories = array_map(function($history){
                $history['created_by'] = Auth::user()->id;
                $history['created_at'] = date('Y-m-d H:i:s');
                $history['updated_at'] = date('Y-m-d H:i:s');
                return $history;
            }, $histories);
            $this->historyService->insert($histories);
        }
    }
}