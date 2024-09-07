<?php

namespace App\Services;

use App\Repositories\Faq\FaqRepositoryInterface;
use Illuminate\Validation\ValidationException;

class FaqService {
    protected $faqRepository;



    public function __construct(FaqRepositoryInterface $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }

    /**
     * Authenticates the faq with the given credentials.
     *
     * @param array $credentials The faq's login credentials.
     * @return mixed|null The authenticated faq if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        $data = $this->faqRepository->list($request);
        return $data;
    }

    public function create($request){
        $faq = $this->filterData($request);
        $data = $this->faqRepository->create($faq);
        return $data;
    }

    private function filterData($request): array{
        $data = $request->all();
        return array(
            'title' => $data['title'],
            'content' => $data['content']
        );
    }
}