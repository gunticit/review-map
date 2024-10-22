<?php

namespace App\Services;
use Illuminate\Support\Str;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryInterface;
use App\Http\Resources\PaymentMethodResource;
use Illuminate\Validation\ValidationException;

class PaymentMethodService {
    protected $paymentMethodRepository;

    public function __construct(
        PaymentMethodRepositoryInterface $paymentMethodRepository,
    )
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    /**
     * Authenticates the paymentwallet with the given credentials.
     *
     * @param array $credentials The paymentwallet's login credentials.
     * @return mixed|null The authenticated paymentwallet if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        $categories = $this->paymentMethodRepository->list($request);
        $categories = PaymentMethodResource::collection($categories)->resource;
        return $categories;
    }

    private function filterData($request): array{
        return array(
            'type' => $request->type ?? '',
            'owner_name' => $request->owner_name ?? '',
            'account_number' => $request->account_number ?? null,
            'bank_name' => $request->bank_name ?? '',
            'bank_branch' => $request->bank_branch ?? '',
            'note' => $request->note ?? ''
        );
    }
}