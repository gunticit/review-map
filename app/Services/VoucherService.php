<?php

namespace App\Services;
use Illuminate\Support\Str;
use App\Repositories\Voucher\VoucherRepositoryInterface;
use App\Http\Resources\VoucherResource;
use Illuminate\Validation\ValidationException;

class VoucherService {
    protected $voucherRepository;

    public function __construct(
        VoucherRepositoryInterface $voucherRepository,
    )
    {
        $this->voucherRepository = $voucherRepository;
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
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/vouchers', 'public');
            $request->image = $imagePath;
        }
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
        $voucher = $this->voucherRepository->checkAjaxApplyVoucher($voucher_code);
        $data = array();
        $status = 'active';
        $date_now = date('Y-m-d');
        if($voucher){
            if($voucher->max_uses == ($voucher->used_uses + 1)){
                $status = 'used';
            }
            if($voucher->start_date > $date_now){
                return null; // Thời gian chưa bắt đầu sử dụng
            }
            if($voucher->end_date < $date_now){
                $status = 'expired'; // Hết hạn sử dụng
            }
            $data = array(
                'status' => $status,
                'voucher' => $voucher
            );
        }
        if(!empty($request->project_id)){
            $project_id = $request->project_id;
        }
        return $data;
    }

    private function filterData($request): array{
        return array(
            'name' => $request->name ?? '',
            'slug' => Str::slug($request->name) ?? '',
            'parent_id' => $request->parent ?? null,
            'description' => $request->description ?? '',
            'image' => $request->image ?? '',
            'created_by' => auth()->user()->id ?? null,
        );
    }
}