<?php

namespace App\Modules\Sample\Controllers;

# System
use Illuminate\Http\Request;
use App\Exceptions\ProcessException;
use App\Http\Controllers\BaseController;
# Request
use App\Modules\Sample\Requests\CreateSampleRequest;
use App\Modules\Sample\Requests\UpdateSampleRequest;
# Service
use App\Modules\Sample\Services\SampleService;
# Resource
use App\Modules\Sample\Resources\SampleResource;
# Model, Helper...
use app\Helpers\Helper;

class SampleController extends BaseController
{
    private $sampleService;

    public function __construct(SampleService $sampleService)
    {
        $this->sampleService = $sampleService;
    }

    public function index(Request $request)
    {
        try {
            $list = $this->sampleService->pagination($request);
            $data = SampleResource::collection($list)->resource;
            return $this->sendResponse($data, __('common.action_success.list'));
         } catch (\Exception $e) {
            throw new ProcessException($e);
        }
    }

    public function store(CreateSampleRequest $request){
        try {
            $sample = $this->sampleService->create($request);
            $data = new SampleResource($sample);
            return $this->sendResponse($data, __('common.action_success.store'));
        } 
        catch (\Exception $e) {
            throw new ProcessException($e);
        }
    }

    public function show(int $id)
    {
        try {
            $sample = $this->sampleService->find($id);
            $data = new SampleResource($sample);
            return $this->sendResponse($data, __('common.action_success.detail'));
        } catch (\Exception $e) {
            throw new ProcessException($e);
        }

    }

    public function update(UpdateSampleRequest $request, int $id){
        try {
            $sample = $this->sampleService->update($request, $id);
            $data = new SampleResource($sample);
            return $this->sendResponse($data, __('common.action_success.update'));
        }
        catch (\Exception $e) {
            throw new ProcessException($e);
        }
    }

    public function delete(int $id){
        try {
            $this->sampleService->delete($id);
            return $this->sendResponse(null, __('common.action_success.delete'));
        } catch (\Exception $e) {
            throw new ProcessException($e);
        }
    }
}
