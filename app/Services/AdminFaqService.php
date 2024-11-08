<?php

namespace App\Services;
use App\Repositories\AdminFaq\AdminFaqRepositoryInterface;
use Illuminate\Validation\ValidationException;

class AdminFaqService {
    protected $adminFaqRepository;

    public function __construct(
        AdminFaqRepositoryInterface $adminFaqRepository,
    )
    {
        $this->adminFaqRepository = $adminFaqRepository;
    }

    /**
     * Authenticates the adminFaq with the given credentials.
     *
     * @param array $credentials The adminFaq's login credentials.
     * @return mixed|null The authenticated adminFaq if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        $categories = $this->adminFaqRepository->list($request);
        return $categories;
    }

    public function fullList($request){
        $categories = $this->adminFaqRepository->list($request);
        return $categories;
    }

    public function create($request){
        $adminFaq = $this->filterData($request);
        $data = $this->adminFaqRepository->create($adminFaq);
        return $data;
    }

    public function show($id){
        $data = $this->adminFaqRepository->find($id);
        return $data;
    }

    public function update($request, $id){
        $adminFaq = $this->filterData($request);
        $data = $this->adminFaqRepository->update($adminFaq, $id);
        return $data; 
    }

    public function delete($id){
        $data = $this->adminFaqRepository->delete($id);
        return $data;
    }

    private function filterData($request): array{
        return array(
            'title' => $request->title ?? '',
            'content' => $request->content ?? '',
            'created_by' => auth()->user()->id ?? null,
        );
    }
}