<?php

namespace App\Services;
use App\Repositories\Setting\SettingRepositoryInterface;
use Illuminate\Validation\ValidationException;

class SettingService {
    protected $settingRepository;

    public function __construct(
        SettingRepositoryInterface $settingRepository,
    )
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * Authenticates the adminFaq with the given credentials.
     *
     * @param array $credentials The adminFaq's login credentials.
     * @return mixed|null The authenticated adminFaq if successful, null otherwise.
     * @throws ValidationException
     */

    public function list($request){
        $categories = $this->settingRepository->list($request);
        return $categories;
    }

    public function fullList($request){
        $categories = $this->settingRepository->list($request);
        return $categories;
    }

    public function create($request){
        $adminFaq = $this->filterData($request);
        $data = $this->settingRepository->create($adminFaq);
        return $data;
    }

    public function show($id){
        $data = $this->settingRepository->find($id);
        return $data;
    }

    public function update($request, $id){
        $adminFaq = $this->filterData($request);
        $data = $this->settingRepository->update($adminFaq, $id);
        return $data; 
    }

    public function delete($id){
        $data = $this->settingRepository->delete($id);
        return $data;
    }

    private function filterData($request): array{
        return array(
            'code_setting' => $request->code_setting ?? '',
            'key_setting' => $request->key_setting ?? '',
            'value_setting' => $request->value_setting ?? null,
        );
    }
}